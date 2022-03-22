<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\RestaurantPicture;
use App\Repository\CityRepository;
use App\Repository\RestaurantRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
//    /**
//     * @Route("/restaurant", name="app_restaurant")
//     */
//    public function index(): Response
//    {
//        return $this->render('restaurant/index.html.twig', [
//            'controller_name' => 'RestaurantController',
//        ]);
//    }

 //  /**
 //    * @Route("/restaurants", name="restaurant.index" , methods={"GET","POST"})
   // */
   // public function restaurants(ManagerRegistry $doctrine)
   //{
     //  $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
      //  $restaurantsPicture = $doctrine->getRepository(RestaurantPicture::class)->findAll();
      //  return new Response(
        //    $this->renderView(
         //       "restaurant/restaurants.html.twig",
         //       [
          //          "restaurants"=>$restaurants,
               //     "restaurantsPicture"=>$restaurantsPicture
             //   ]
           // )
       // );
   // }

    /**
     * @Route("/restaurants/{id}", name="restaurant_detail")
     */
    public function detail(RestaurantRepository $repo ,Request $request , ReviewRepository $repos): Response
    {
        $id=$request->get('id');
        $restaurant=$repo->find($id);
        $reviews=$repos->findBy(array('restaurantId' =>$id));
        $sum=0;
        foreach ($reviews as $key=>$value){
            $sum = $sum + $value->getRating();
        }
        if(empty($reviews)){
            $moyenne=0;
        }else{
            $moyenne=$sum/count($reviews);
        }
        return $this->render('restaurant/detail.html.twig', [
            'restaurant' => $restaurant,
            'reviews'=> $reviews,
            'moyenne'=>$moyenne
        ]);
    }
    /**
     * @Route("/restaurant/new",name="restaurant.new", methods={"GET"})
     */
    public function new(CityRepository $repository,Request $request)
    {
        //get all cities
        $cities =$repository->findAll();
        return new Response(
            $this->renderView(
                "restaurant/new.html.twig",
                [
                    "cities" => $cities,
                ]
            )
        );
    }
    /**
     * @Route("/restaurant/create",name="app_restaurant_new", methods={"POST"})
     */
    public function create(CityRepository $repository,Request $request,EntityManagerInterface $em):Response
    {
        $restaurant=new Restaurant();
        $restaurant->setName($request->get('name'));
        $restaurant->setDescription($request->get('description'));
        $city=$repository->find($request->get('city'));
        $restaurant->setCityId($city);
        $em->persist($restaurant);
        $em->flush();
        return $this->redirectToRoute('restaurant.index');
    }
    /**
     * @Route("/restaurants/{restaurant}", name="restaurant.index",defaults={"restaurant"=1})
     */
    public function restaurants(RestaurantRepository $repo): Response
    {
        $search= $_GET['restaurant'] ?? '';
       //$rest=$repo->threeBestRestaurants();
        if($search){
            $rest=$_GET['restaurant'];
            $restaurants= $repo->findByName($rest);
        }else{
            $restaurants=  $repo->getLatest(6);
        }
        return $this->render('restaurant/restaurants.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }
    /**
     * @Route("/requets", name="restaurant.index")
     */
    public function requetsThree(RestaurantRepository $repo ,EntityManagerInterface $en): Response
    {
        $restaurants = $repo->threeBestRestaurants();
        dd($restaurants);
    }


}
