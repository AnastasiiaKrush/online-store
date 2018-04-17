<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Category;
use App\Form\CategoryType;

class CategoryController extends Controller
{
    /**
     * @Route("/admin/category/create", name="admin_create_category")
     */
    public function createAction(Request $request, ValidatorInterface $validator)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
        } elseif ($form->isSubmitted() && ($form->isValid() === false)) {

            $errors = $validator->validate($category);
        }

        $em = $this->getDoctrine()->getManager();
        $categories = $em
            ->createQueryBuilder()
            ->select('c')
            ->addSelect('(SELECT count(pc.id) FROM App\Entity\ProductCategory pc WHERE pc.category = c.id ) as post_count')
            ->from('App\Entity\Category', 'c')
            ->getQuery()
            ->getScalarResult();

        $result = [
            'categories' => $categories,
            'form' => $form->createView(),
        ];

        if (isset($errors)) {
            $result['errors'] = $errors;
        }
        return $this->render('admin/category/create_category.html.twig', $result);
    }

    /**
     * @Route("/admin/category/edit/{id}", name="admin_edit_category")
     */
    public function editAction($id, Request $request, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository(Category::class)->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id '.$id
            );
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
            $success = true;
        } elseif ($form->isSubmitted() && ($form->isValid() === false)) {

            $errors = $validator->validate($category);
        }

        $result = [
            'category' => $category,
            'form' => $form->createView(),
        ];

        if (isset($errors)) {
            $result['errors'] = $errors;
        } elseif (isset($success) && ($success === true)) {
            $result['success'] = $success;
        }

        return $this->render('admin/category/edit_category.html.twig', $result);
    }

    /**
     * @Route("/admin/category/delete/{id}", name="admin_delete_category")
     */
    public function deleteAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository(Category::class)->find($id);

        return $this->render(
            'admin/category/delete_category.html.twig',
            [
                'category' => $category
            ]);
    }

    /**
     * @Route("/admin/category/delete/{id}/{slug}", name="admin_delete_category_true")
     */
    public function deleteTrueAction($id, $slug)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository(Category::class)->find($id);

        if ($slug === 'yes') {
            $entityManager->remove($category);
            $entityManager->flush();
            return $this->redirectToRoute('admin_create_category');
        }

    }
}