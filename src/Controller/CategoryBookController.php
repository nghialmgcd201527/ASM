<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\CategoryBook;
use App\Form\BookType;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoryBookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    /**
     * @Route("/category/edit/{id}", name="category_edit")
     */
    public function editCategory(Request $request, CategoryBook $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('list_category', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_book/category_edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/category_create", name="create_category", methods={"GET","POST"})
     */
    public function bookCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new CategoryBook();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setCategoryName($request->request->get('category')['category_name']);
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('list_category');
        }

        return $this->renderForm('category_book/category_create.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
}
