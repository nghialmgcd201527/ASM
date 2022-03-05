<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerBookController extends AbstractController
{
    /**
     * @Route("/customer", name="account")
     */
    public function show(UserRepository $customerRepository): Response
    {
        return $this->render('user/list_customer.html.twig', [
            'customers' => $customerRepository->findAll(),
        ]);
    }
}
