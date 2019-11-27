<?php


namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/form", name="formCategory")
     * @param Request $request
     * @return Response
     */
    public function category(Request $request): Response
    {
        $form = $this
            ->createForm(CategoryType::class);
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $data->setName('name');
            $request->persist($data);
            $request->flush();
        }

        return $this->render('form/categoryForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

//    /**
//     * @Route("/form", name="addCategory")
//     * @param EntityManagerInterface $entityManager
//     * @return Response
//     */
//    public function add(Request $request): Response
//    {
//        // declare a new category
//        $category = new Category();
//
//        // set category properties
//        $category->setName('name');
//
//        // declare object to doctrine (no SQL query is done)
//        $entityManager->persist($category);
//
//        // execute SQL query
//        // for this object but also all doctrine objects of the script
//        $entityManager->flush();
//
//        return $this->render('form/categoryForm.html.twig', [
//            'category' => $category,
//        ]);
//    }

}