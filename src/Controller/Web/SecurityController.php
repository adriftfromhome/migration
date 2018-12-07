<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\creationForms\SignUpFormType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Security\Csrf\CsrfToken;
use App\Entity\UserInvite;

class SecurityController extends AbstractController
{
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * renders the signup page
     * @Route("/signup/{token}")
     * @param Request $request
     */
    public function signUp(Request $request, UserPasswordEncoderInterface $passwordEncoder, $token)
    {
        
        $repo = $this->getDoctrine()->getManager();
        $iRepo = $repo->getRepository(UserInvite::class);
        $token = $iRepo->findOneByToken($token);
        if($token)
        {
            return $this->render('security/signup.html.twig', ['token' => $token]);
        }
    }
}
