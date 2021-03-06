<?php

namespace App\Controller;

use App\Messenger\Message\SlackMessage;
use App\Service\SlackBotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     * @param AuthenticationUtils $authenticationUtils
     *
     * @param SlackBotService     $slackBot
     *
     * @return Response
     * @throws \Http\Client\Exception
     */
    public function login(AuthenticationUtils $authenticationUtils, SlackBotService $slackBot): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        $this->dispatchMessage(new SlackMessage('Khan', 'Super sa marche :smile:', ':100:'));


        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]
        );
    }

    /**
     * @Route("/logout", name="account_logout")
     */
    public function logout()
    {
        throw new \RuntimeException('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
