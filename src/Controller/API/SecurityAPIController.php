<?php

namespace App\Controller\API;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\UserInvite;

class SecurityAPIController extends FOSRestController {

    // TODO: modify and delete user, templates + form
    // TODO2: access control, add csrf where needed
    // TODO3: add functions for forgot password, new table(resetPasswordtoken)

    /**
     * Creates a User resource
     * @Rest\Post("/user/create")
     * @param Request $request
     * @return View
     */
    public function postUser(Request $request, UserPasswordEncoderInterface $passwordEncoder): View {
        
        $submittedToken = $request->get('_csrf_token');
        
        // TODO: check for invite token, set OrgId,
        // send invite with generated token, check if token exists with the email

        if($this->isCsrfTokenValid('create-user', $submittedToken)) {
            
            $repo = $this->getDoctrine()->getManager();
            $alreadyExists = $repo->getRepository(User::class)->findOneByEmail($request->get('email'));
            if(!$alreadyExists) {

                $user = new User();
                $password = $request->get('password');
                $encoded_password = $passwordEncoder->encodePassword($user, $password);
                
                $user->setEmail($request->get('email'));
                $user->setFirstname($request->get('firstname'));
                $user->setLastname($request->get('lastname'));
                $user->setPassword($encoded_password);
                
                $invite = $repo->getRepository(UserInvite::class)->findOneByToken($request->get('inviteToken'));
                $organization = $invite->getOrganization();
                // add role check/ add functionality to edit the department on invite creation
                $user->setOrganization($organization);
                $repo->persist($user);
                $repo->remove($invite);
                $repo->flush();
                
                
                return View::create($user->getUsername(), Response::HTTP_CREATED);
            }
            return View::create(['status' => "email already exists"]);
        }
        return View::create(['error' =>'invalid Token'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Modifies a User resource
     * @Rest\Post("/user/edit/{userId}")
     * @param Request $request
     * @return View
     */
    public function putUser(Request $request, $userId): View {

    }

    /**
     * Deletes a User resource
     * @Rest\Post("/user/delete/{userId}")
     * @param Request $request
     * @return View
     */
    public function deleteUser(Request $request, $userId): View {

    }


}


?>