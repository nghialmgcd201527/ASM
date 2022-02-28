<?php

namespace App\Controller;

use App\Entity\CategoryBook;
use App\Repository\CategoryBookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryBookController extends AbstractController
{
    /**
     * @Route("/category", name="list_category")
     */
    public function show(CategoryBookRepository $categoryBookRepository): Response
    {
        return $this->render('category_book/index.html.twig', [
            'categories' => $categoryBookRepository->findAll(),
        ]);
    }

    /**
     * @Route("/category/{id}", name="book_detail")
     */
    public function detail(CategoryBook $categories): Response
    {
        return $this->render('category_book/detail.html.twig', [
            'category_book' => $categories,
        ]);
    }
}
