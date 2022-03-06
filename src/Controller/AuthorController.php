<?php
namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author", name="author_show")
     */
    public function show(AuthorRepository $authorRepository): Response
    {
        return $this->render('author/index.html.twig', [
            'authors' => $authorRepository->findAll(),
        ]);
    }
    /**
     * @Route("/author/{id}", name="author_detail")
     */
    public function detail(Author $authors): Response
    {
        dump($authors);
        return $this->render('author/author_detail.html.twig', [
            'author' => $authors,
        ]);
    }
    /**
     * @Route("/author_create", name="author_create", methods={"GET","POST"})
     */
    public function CreateAuthor(Request $request, EntityManagerInterface $entityManager): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('author_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('author/author_create.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/author/author_delete/{id}", name="author_delete")
     */
    public function deleteAuthorById($id, BookRepository $bookRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $authorRepo = $em->getRepository(Author::class);
        $bookRepo = $bookRepository->findOneBy(['author_id'=>$id]);
        if(!$bookRepo){
            $author = $authorRepo->find($id);
            try{
                dump($author);
                $em->remove($author);
                $em->flush();
            }catch(Exception $ex){
                $this->addFlash(
                    'error',
                    'Todo deleted'
                );
            }
        }
        return $this->redirectToRoute('author_show');

    }

    /**
     * @Route("/author/author_edit/{id}", name="author_edit")
     */
    public function editAuthor(Request $request, Author $author, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('author_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('author/author_edit.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }
}
