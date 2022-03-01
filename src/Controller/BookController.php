<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        dump($books);
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
        dump($book);
        $em->remove($book);
        $em->flush();

        $this->addFlash(
            'error',
            'Todo deleted'
        );

        return $this->redirectToRoute('book_show');

    }

    /**
     * @Route("/book/edit/{id}", name="book_edit")
     */
    public function editBook(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('book_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/book/create", name="book_create", methods={"GET","POST"})
     */
    public function bookCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setCategoryId($request->request->get('book')['category_id']);
            $book->setAuthorId($request->request->get('book')['author_id']);
            $book->setBookName($request->request->get('book')['book_name']);
            $book->setDescription($request->request->get('book')['description']);
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('book');
        }

        return $this->renderForm('book/create.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }
}
