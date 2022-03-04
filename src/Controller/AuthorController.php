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
            'author' => $authors,
        ]);
    }
}
