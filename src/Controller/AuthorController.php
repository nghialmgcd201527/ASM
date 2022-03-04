<?php
namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
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
        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }
    /**
     * @Route("/author/author_create", name="author_create", methods={"GET","POST"})
     */
    public function authorCreate(Request $request, EntityManagerInterface $entityManager): Response
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

}
