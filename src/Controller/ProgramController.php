<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series',
            'programs' => $programs
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new Program();

        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // Deal with the submitted data
            // For example : persiste & flush the entity
            $programRepository->save($program, true);
            // And redirect to a route that display the result
            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show(Program $program): Response
    {

        if(!$program) {
            throw $this->createNotFoundException(
                'No program with id: ' . $program['id'] . ' found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/{programId}/seasons/{seasonId}', name: 'season_show')]
    #[Entity('program', options: ['mapping' => ['programId' => 'id']])]
    #[Entity('season', options: ['mapping' => ['seasonId' => 'id']])]
    //public function showSeason(int $programId, ProgramRepository $programRepository, int $seasonId, SeasonRepository $seasonRepository): Response
    public function showSeason(Program $program, Season $season): Response
    {
        //$program = $programRepository->findOneBy(['id' => $programId]);
        //$season = $seasonRepository->findOneBy(['id' => $seasonId]);
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season
        ]);
    }

    #[Route('/{programId}/season/{seasonId}/episode/{episodeId}', name: 'episode_show')]
    #[Entity('program', options: ['mapping' => ['programId' => 'id']])]
    #[Entity('season', options: ['mapping' => ['seasonId' => 'id']])]
    #[Entity('episode', options: ['mapping' => ['episodeId' => 'id']])]
    //#[Route('/{program}/season/{season}/episode/{episode}', name: 'episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    }
}