<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{

        #[Route('/new', name: 'new')]
        public function new(Request $request, CategoryRepository $categoryRepository)
        {
            $category = new Category();
    
            // Create the form, linked with $category
            $form = $this->createForm(CategoryType::class, $category);
            
            $form->handleRequest($request);
            // Was the form submitted ?

            if ($form->isSubmitted()) {
                $categoryRepository->add($category, true);   
                // Deal with the submitted data
                // For example : persiste & flush the entity
                // And redirect to a route that display the result
            }
            // Render the form (best practice)
            return $this->renderForm('category/new.html.twig', [
                'form' => $form,
            ]);
    
            // Alternative
            // return $this->render('category/new.html.twig', [
            //   'form' => $form->createView(),
            // ]);
        }

    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $itemByCategory = [];

        foreach ($categories as $item) {
            $itemByCategory[$item->getName()] = count($item->getPrograms());
        }

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'itemByCategory' => $itemByCategory
        ]);
    }

    #[Route('/{categoryName}', name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository)
    {
        $categorie = $categoryRepository->findByName($categoryName);

        if (!$categorie) {
            throw $this->createNotFoundException(
                'Categorie "' . $categoryName . '" does not exist in Database'
            );
        }

        $categoryResults = $programRepository->findByCategory(
            $categorie,
            ['id' => 'ASC']
        );


        return $this->render('category/show.html.twig', [
            'categoryResults' => $categoryResults,
            'category' => $categoryName
        ]);
    }
}

