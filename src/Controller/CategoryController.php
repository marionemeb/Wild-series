<?php


namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/form", name="formCategory")
     */
    public function category()
    {
        $form = $this
            ->createForm(CategoryType::class);

        return $this->render('form/categoryForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/form", name="addCategory")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function add(EntityManagerInterface $entityManager) :Response
    {
        // declare a new category
        $category = new Category();

        // set category properties
        $category->setName('name');

        // declare object to doctrine (no SQL query is done)
        $entityManager->persist($category);

        // execute SQL query
        // for this object but also all doctrine objects of the script
        $entityManager->flush();

        return $this->render('form/categoryForm.html.twig', [
            'category' => $category,
        ]);
    }

}