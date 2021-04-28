<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        if ( $this->getUser()!=null && $this->getUser()->getType()=="Admin") {
               return $this->redirectToRoute('app_admin_users');
             }
        else{
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);}
    }
}
