<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuController extends Controller
{
    public function topMenu()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render(
            'layout/top_menu.html.twig',
            [
                'categories' => $categories,
                'user' => $user
            ]
        );
    }
}