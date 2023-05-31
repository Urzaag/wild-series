<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Form\ActorType;
use App\Repository\ActorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('actor/index.html.twig', [
            'controller_name' => 'ActorController',
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ActorRepository $actorRepository, SluggerInterface $slugger, MailerInterface $mailer): Response
    {
        $actor = new Actor();

        $form = $this->createForm(ActorType::class, $actor);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // Deal with the submitted data
            /*$slug = $slugger->slug($actor->getName());
            $actor->setSlug($slug);*/
            // For example : persiste & flush the entity
            $actorRepository->save($actor, true);
            $this->addFlash('success', 'The new program has been created');

            /*$email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('your_email@example.com')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html($this->renderView('program/newProgramEmail.html.twig', ['program' => $program]));

            $mailer->send($email);*/
            // And redirect to a route that display the result
            return $this->redirectToRoute('actor_index');
        }

        return $this->renderForm('actor/new.html.twig', [
            'form' => $form,
            'actor' => $actor,
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(Actor $actor): Response
    {
        return $this->render('actor/show.html.twig',[
            'actor' => $actor
        ]);
    }
}
