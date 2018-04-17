<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;

class MainController extends Controller
{
    /**
     * @Route("/", name="main_page")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Category::class)->findAll();

        $products = $em
            ->createQueryBuilder()
            ->select('c.id category_id, p.id product_id, p.name product_name, p.description_short, p.price_old, p.price_new')
            ->from('App\Entity\Category', 'c')
            ->leftJoin('App\Entity\ProductCategory', 'pc', "WITH", 'c.id = pc.category')
            ->leftJoin('App\Entity\Product', 'p', "WITH", 'pc.product = p.id')
            ->where('c.id = pc.category')
            ->getQuery()
            ->getResult();

        return $this->render(
            'main/main_page.html.twig',
            [
                'categories' => $categories,
                'products' => $products
            ]
        );
    }
}