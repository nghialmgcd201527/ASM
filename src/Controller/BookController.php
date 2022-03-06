<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/welcome", name="welcome")
     */
    public function welcome(BookRepository $bookRepository): Response
    {
        return $this->render('book/index_customer.html.twig', [
            'books' => $bookRepository->findAll(),
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
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('book_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/create.html.twig', [
            'book' => $book,
            'form' => $form,
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
     * @IsGranted("ROLE_ADMIN")
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
     * @Route("/api/books", methods={"GET"}, name="api_get_books")
     */
    public function getCars(): JsonResponse
    {
        // Call Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Call Car Repo
        $bookRepo = $em->getRepository(Book::class);

        // Get all cars
        $result = $bookRepo->findAll();

        // Return a json response
        return new JsonResponse($result, 200, []);
    }

    /**
     * @Route("/search_book", name="search_book")
     */
    public function searchBook(BookRepository $bookRepository): Response
    {
        return $this->render('search_book.html');
    }

    /**
     * @Route("/api/books/{id}", methods={"GET"}, name="api_get_books_by_id")
     */
    public function getBooksById($id): JsonResponse
    {
        // Call Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Call Car Repo
        $bookRepo = $em->getRepository(Book::class);

        // Get car by id
        $result = $bookRepo->find($id);

        // Return a json response
        return new JsonResponse($result, 200, []);
    }
}
