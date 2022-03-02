<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\CategoryBook;
use App\Form\BookType;
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
     * @Route("/category/{id}", name="category_detail")
     */
    public function detail(CategoryBook $categories): Response
    {
        return $this->render('category_book/category_detail.html.twig', [
            'category' => $categories,
        ]);
    }

    /**
     * @Route("/category/delete/{id}", name="category_delete")
     */
    public function deleteCategoryById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryBookRepo = $em->getRepository(CategoryBook::class);
        $category = $categoryBookRepo->find($id);
        dump($category);
        $em->remove($category);
        $em->flush();

        $this->addFlash(
            'error',
            'Todo deleted'
        );

        return $this->redirectToRoute('list_category');

    }

}
