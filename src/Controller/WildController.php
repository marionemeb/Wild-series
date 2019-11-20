<?php
// src/Controller/WildController.php
namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

Class WildController extends AbstractController
{
    /**
     * @Route("/wild", name="wild_index")
     */
    public function index(): Response
    {
        return $this->render('wild/index.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }

    /**
     * @Route("show/{slug}", requirements={"slug"="[a-z0-9-]+"}, defaults={"slug"="Aucune série sélectionnée, veuillez choisir une série"}, name="wild_show")
     * @param string $slug
     * @return Response
     */
    public function show(string $slug): Response
    {
        $newSlug = ucwords(str_replace("-", " ", $slug));
        return $this->render('wild/show.html.twig', ['newSlug' => $newSlug]);
    }
}