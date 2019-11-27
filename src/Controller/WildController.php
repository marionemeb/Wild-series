<?php
// src/Controller/WildController.php
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Category;
use App\Entity\Season;
use App\Form\ProgramSearchType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

Class WildController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }

        $form = $this->createForm(ProgramSearchType::class, null,
            ['method' => Request::METHOD_GET]);


        return $this->render('home.html.twig', [
            'programs' => $programs,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Show all rows from Program’s entity
     *
     * @Route("/wild/", name="wild_index")
     * @return Response A response instance
     */
    public function showProgram(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }

        return $this->render('wild/program.html.twig', [
            'programs' => $programs,
        ]);
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show")
     * @return Response
     */
    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this
            ->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with ' . $slug . ' title, found in program\'s table.'
            );
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug' => $slug,
        ]);
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $categoryName The slugger
     * @Route("/showByCategory/{categoryName<^[a-zA-Z0-9-]+$>}", defaults={"categoryName" = "horreur"}, name="category")
     * @return Response
     */
    public function showByCategory(string $categoryName): Response
    {
        if (!$categoryName) {
            throw $this
                ->createNotFoundException('No category has been sent to find a program in program\'s table.');
        }

        $categoryName = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($categoryName)), "-")
        );

        $category = $this
            ->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => mb_strtolower($categoryName)]);

        $categoryId = $category->getId();

        $listMovies = $this
            ->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $categoryId], ['id' => 'DESC'], 3);

        return $this->render('wild/category.html.twig', [
            'movies' => $listMovies,
            'categoryName' => $categoryName,
        ]);
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $program
     * @Route("/showByProgram/{program<^[a-zA-Z0-9-]+$>}", defaults={"program" = null}, name="program")
     * @return Response
     */
    public function showByProgram($program)
    {
        if (!$program) {
            throw $this
                ->createNotFoundException('No program has been sent to find a program in program\'s table.');
        }

        $program = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($program)), "-")
        );

        $title = $this
            ->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($program)]);

        $titleId = $title->getId();

        $season = $this
            ->getDoctrine()
            ->getRepository(Season::class)
            ->findBy(['program' => $titleId]);

        return $this->render('wild/program.html.twig', [
            'title' => $title,
            'season' => $season,
        ]);
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param int $id
     * @Route("/showBySeason/{id}", defaults={"id" = 2}, name="id")
     * @return Response
     */
    public function showBySeason(int $id)
    {
        if (!$id) {
            throw $this
                ->createNotFoundException('No seasons with this number');
        }

        $season = $this
            ->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => $id]);

        $program = $season->getProgram();
        $episodes = $season->getEpisode();

        return $this->render('wild/programEpisode.html.twig', [
            'program' => $program,
            'episodes' => $episodes,
        ]);
    }

    /**
     * @Route("/episode/{id}", name="episode")
     * @param Episode $episode
     * @return Response
     */
    public function showEpisode(Episode $episode): Response
    {
        $season = $episode->getSeason();
        $program = $season->getProgram();

        return $this->render('wild/episode.html.twig', [
            'episode' => $episode,
            'season' => $season,
            'program' => $program,
        ]);
    }
}