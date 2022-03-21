<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantPicturController extends AbstractController
{
    /**
     * @Route("/restaurant/pictur", name="app_restaurant_pictur")
     */
    public function index(): Response
    {
        return $this->render('restaurant_pictur/index.html.twig', [
            'controller_name' => 'RestaurantPicturController',
        ]);
    }
}
