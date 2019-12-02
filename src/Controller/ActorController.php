<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Program;
use App\Repository\ActorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actor")
 */
class ActorController extends AbstractController
{
    /**
     * @Route("/actor/{name}", name="actor_name", methods={"GET"})
     * @param $name
     * @return Response
     */
    public function index($name): Response
    {
        if (!$name) {
            throw $this
                ->createNotFoundException('No actor has been sent to find an actor in actor\'s table.');
        }

        $name = $this
            ->getDoctrine()
            ->getRepository(Actor::class)
            ->findOneBy(['name' => $name]);

        return $this->render('actor/index.html.twig', [
            'name' => $name,
        ]);
    }
}
