<?php

namespace App\Controller\admin;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Product;
use App\Form\ProductType;

class ProductController extends Controller
{
    /**
     * @Route("/admin/product/category/characteristic/value/image/create", name="admin_add_product")
     */
    public function createAction(Request $request, ValidatorInterface $validator)
    {
        $productCategoryIds = $_POST['product_category_ids'];
        $productCharacteristics = $_POST['product_characteristics'];
        $imageNames = isset($_POST['product_image_names']) ? $_POST['product_image_names'] : null;

        if (isset($_FILES["product_images"])) {
            $productImages = $_FILES["product_images"];

            $uploadPath = __DIR__ . '/../../../public/assets/img/';

            foreach ($productImages["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $name = basename($productImages["name"][$key]);
                    $imageNames[] = $name;
                    $tmp_name = $productImages["tmp_name"][$key];
                    move_uploaded_file($tmp_name, "$uploadPath/$name");
                }
            }

            $imageNames = implode(',', $imageNames);
        }

        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productCategoryIds = $_POST['product_category_ids'];
            $productCharacteristics = $_POST['product_characteristics'];
            $imageNames = $_POST['product_image_names'];
            $imageNames = explode(',', $imageNames);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

        foreach ($imageNames as $imageName) {
            $entityManager
                ->createQueryBuilder()
                ->insert('App\Entity\ProductImages', 'pi')
                ->values(['product_id' => '?', 'is_preview' => '?', 'link' => '?', 'is_slider' => '?'])
                ->setParameter(0, $product->getId())
                ->setParameter(1, 0)
                ->setParameter(2, $imageName)
                ->setParameter(3, 0);
        }
            return $this->render(
                'admin/product/save_product.html.twig',
                [
                    'product_id' => $product->getId(),
                ]
            );
        }

        return $this->render(
            'admin/product/add_product.html.twig',
                [
                    'form' => $form->createView(),
                    'product_category_ids' => $productCategoryIds,
                    'product_characteristics'=> $productCharacteristics,
                    'product_image_names'=> $imageNames
                ]
        );
    }

    /**
     * @Route("/admin/product/category", name="admin_choose_product_category")
     */
    public function chooseCategoryForProduct()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categories = $entityManager->getRepository(Category::class)->findAll();
        return $this->render(
            'admin/product/choose_category.html.twig',
            [
                'categories' => $categories
            ]
        );
    }

    /**
     * @Route("/admin/product/category/characteristic", name="admin_choose_product_category_characteristic")
     */
    public function chooseCharacterisitcForProduct()
    {
        $productCategoryIds = $_POST['product']['category'];
        $entityManager = $this->getDoctrine()->getManager();

        $characteristics = $entityManager
            ->createQueryBuilder()
            ->select('c')
            ->from('App\Entity\CategoryCharacteristic', 'cc')
            ->innerJoin('App\Entity\Characteristic', 'c', "WITH", 'c.id = cc.characteristic')
            ->where('cc.category IN (:ids)')
            ->setParameter('ids', $productCategoryIds)
            ->getQuery()
            ->getResult();

        $productCategoryIds = implode(',', $productCategoryIds);

        return $this->render(
            'admin/product/choose_characteristic.html.twig',
            [
                'product_category_ids' => $productCategoryIds,
                'characteristics'=> $characteristics
            ]
        );
    }

    /**
     * @Route("/admin/create/category/characteristic/value", name="admin_choose_product_characteristic_value")
     */
    public function chooseCharacteristicValueForProduct()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $productCategoryIds = $_POST['product_category_ids'];
        $productCharacteristicIds = $_POST['product']['characteristic'];

        $productCharacteristics = $entityManager
            ->createQueryBuilder()
            ->select('ch.id,ch.name')
            ->from('App\Entity\Characteristic', 'ch')
            ->where('ch.id IN (:ids)')
            ->setParameter('ids', $productCharacteristicIds)
            ->getQuery()
            ->getResult();

        return $this->render(
            'admin/product/characteristic_value.html.twig',
            [
                'product_category_ids' => $productCategoryIds,
                'product_characteristics'=> $productCharacteristics
            ]
        );
    }

    /**
     * @Route("/admin/product/category/characteristic/value/image", name="admin_choose_product_images")
     */
    public function chooseImagesForProduct()
    {
        $productCategoryIds = $_POST['product_category_ids'];
        $productCharacteristicsStr = '';
        $productCharacteristics = $_POST['product_characteristics'];

        foreach ($productCharacteristics as $key => $value)
        {
            $productCharacteristicsStr.= $key . ',' . $value . ';';
        }

        return $this->render(
            'admin/product/choose_images.html.twig',
            [
                'product_category_ids' => $productCategoryIds,
                'product_characteristics'=> $productCharacteristicsStr
            ]
        );

    }

    /**
     * @Route("/admin/product/category/characteristic/value/image/create/save", name="admin_save_product")
     */
    public function saveAction(Request $request, ValidatorInterface $validator)
    {
        return $this->render('admin/product/save_product.html.twig');
    }
}