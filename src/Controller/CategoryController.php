<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'new')]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        // Create a new Category Object
        $category = new Category();
        // Create the associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // For example : persiste & flush the entity
            $categoryRepository->save($category, true);
            // And redirect to a route that display the result
            return $this->redirectToRoute('category_index');
        }

        // Render the form
        return $this->render('category/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{categoryName}', name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);


        if(!$category) {
            throw $this->createNotFoundException(
                'No category with name ' . $categoryName . ' in category table'
            );
        } else {
            $categoryId = $category->getId();
            $programsInCategory = $programRepository->findBy(
                ['category' => $categoryId],
                ['id' => 'DESC'],
                3);
        }

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programsInCategory,
        ]);
    }
}