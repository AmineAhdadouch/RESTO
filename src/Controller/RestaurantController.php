<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\RestaurantPicture;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    /**
     * @Route("/restaurant", name="app_restaurant")
     */
    public function index(): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'controller_name' => 'RestaurantController',
        ]);
    }

    /**
     * @Route("/restaurants", name="restaurant.index" , methods={"GET","POST"})
     */
    public function restaurants(ManagerRegistry $doctrine)
    {
        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
        $restaurantsPicture = $doctrine->getRepository(RestaurantPicture::class)->findAll();
        return new Response(
            $this->renderView(
                "restaurant/restaurants.html.twig",
                [
                    "restaurants"=>$restaurants,
                    "restaurantsPicture"=>$restaurantsPicture
                ]
            )
        );
    }
}
