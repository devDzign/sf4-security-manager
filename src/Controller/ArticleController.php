<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleType;
use App\Messenger\Message\SlackMessage;
use App\Repository\ArticleRepository;
use App\Service\SlackBotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{

    /**
     * @Route("/", name="article_index", methods={"GET"})
     * @param ArticleRepository $furnitureRepository
     *
     * @return Response
     */
    public function index(ArticleRepository $furnitureRepository): Response
    {
        return $this->render(
            'article/index.html.twig',
            [
                'articles' => $furnitureRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     * @param Request         $request
     *
     * @param SlackBotService $slackBot
     *
     * @return Response
     * @throws \Http\Client\Exception
     */
    public function new(Request $request, SlackBotService $slackBot): Response
    {

        /** @var User $user */
        $user = $this->getUser();

        $article = new Article();
        $form    = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', 'Le article a bien été créé !');


            $slackBot->sendMessageSlack('Clement', 'Je suis Clement', ':heart:');

            return $this->redirectToRoute('article_index');
        }

        $this->addFlash('error', 'Une erreur est servenue !!');

        return $this->render(
            'article/new.html.twig',
            [
                'article' => $article,
                'form'    => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     * @param Article $article
     *
     * @return Response
     */
    public function show(Article $article): Response
    {
        $message  = new SlackMessage('Create', 'Creation un nouveau article :poop:', ':poop:');
        $envelope = new Envelope(
            $message, [
            new DelayStamp(5000),
        ]
        );
        $this->dispatchMessage($envelope);
        return $this->render(
            'article/show.html.twig',
            [
                'article' => $article,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Article $article
     *
     * @return Response
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render(
            'article/edit.html.twig',
            [
                'article' => $article,
                'form'    => $form->createView(),
            ]
        );
    }
}
