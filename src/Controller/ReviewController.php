<?php

namespace App\Controller;

use App\Entity\Review;
use App\Repository\CityRepository;
use App\Repository\RestaurantRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    /**
     * @Route("/restaurant_review/new",name="review.new")
     */
    public function newReview(UserRepository $repository,RestaurantRepository $repo)
    {

        $users =$repository->findAll();
        $restaurants=$repo->findAll();
        return new Response(
            $this->renderView(
                "review/new.html.twig",
                [
                    "users" => $users,
                    "restaurants"=> $restaurants
                ]
            )
        );
    }
    /**
     * @Route("/restaurant_review/create",name="review.create")
     */
    public function addReview(UserRepository $repository,RestaurantRepository $repo,EntityManagerInterface $em ,Request $request)
    {
        $review= new Review();
        $review->setMessage($request->get('message'));
        $review->setRating($request->get('rating'));
        $user=$repository->find($request->get('user'));
        $restaurant=$repo->find($request->get('restaurant'));
        $review->setUserId($user);
        $review->setRestaurantId($restaurant);
        $em->persist($review);
        $em->flush();
        return $this->redirectToRoute('restaurant.index');
    }

}
