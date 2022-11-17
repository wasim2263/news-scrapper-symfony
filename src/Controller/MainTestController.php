<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainTestController extends AbstractController
{
    /**
     * @Route("/main/test", name="app_main_test")
     */
    public function index(): Response
    {
        return $this->render('main_test/index.html.twig', [
            'controller_name' => 'MainTestController',
        ]);
    }
}
