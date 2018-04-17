<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/admin", name="main_admin_page")
     */
    public function indexAction()
    {
        return $this->redirect('/');
    }
}