<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/book", name="book_show")
     */
    public function show(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    /**
     * @Route("/book/{id}", name="book_detail")
     */
    public function detail(Book $books): Response
    {
        return $this->render('book/detail.html.twig', [
            'book' => $books,
        ]);
    }

    /**
     * @Route("/book/delete/{id}", name="book_delete")
     */
    public function deleteBookById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $bookRepo = $em->getRepository(Book::class);
        $book = $bookRepo->find($id);
        $em->remove($book);
        $em->flush();

        $this->addFlash(
            'error',
            'Todo deleted'
        );

        return $this->redirectToRoute('book_show');

    }
}
