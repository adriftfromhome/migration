<?php

namespace App\Controller\WebController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\creationForms\SignUpFormType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

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

    public function signUp(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $form = $this->createForm(SignUpFormType::class, $user, ['standalone' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $user->getPassword();
            $encoded_password = $passwordEncoder->encodePassword($user, $password);
            $user->setPassword($encoded_password);

            $em->persist($user);
            $em->flush();
            
            return $this->redirectToRoute('login');
        }
        return $this->render('security/signup.html.twig', ['form' => $form->createView()]);
    }
}
