<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
            $categories = $categoryRepository->findAll();
    
            return $this->render(
                'category/index.html.twig',
                ['categories' => $categories]
            );

    }

    #[Route('/{categoryName}', name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository) {
    $category = $categoryRepository -> findByName($categoryName);
    {
        if (!$category) {
            throw $this->createNotFoundException(
                'No category with name : '.$categoryName.' found in category\'s table.'
            );
        }

        $categoryResults = $programRepository->findByCategory($category);
        
        return $this->render('category/show.html.twig', [
                        'categoryResults' => $categoryResults,
                        'category' => $categoryName,
        ]);
                   
    }
}
}


