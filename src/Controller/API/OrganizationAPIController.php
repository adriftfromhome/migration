<?php

namespace App\Controller\API;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use FOS\RestBundle\View\View;
use App\Entity\Organization;
use App\Entity\UserInvite;
use App\Entity\User;


class OrganizationAPIController extends FOSRestController {

    // TODO: modfiy/delete Organization
    /**
     * Gets a Organization resource
     * @Rest\Post("/organization/get/{orgName}")
     * @Rest\View(serializerGroups={"public"})
     * @param Request $request
     * @return View
     */
    public function getOrganization(Request $request, $orgName): View {

        if ($this->isCsrfTokenValid('create-org', $submittedToken)) {

            $file = $request->files->get('image');
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('logos_directory'), $fileName);
            $organization->setName($request->get('name'));
            $organization->setLogo($fileName);
            $organization->setLanguage('en');

            $repo = $this->getDoctrine()->getManager();
            $repo->persist($organization);
            $repo->flush();

            return View::create($organization, Response::HTTP_CREATED);
        }
        return View::create(['error' => 'invalid token'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Creates a Organization resource
     * @Rest\Post("/organization/create")
     * @Rest\View(serializerGroups={"public"})
     * @param Request $request
     * @return View
     */
    public function postOrganization(Request $request, \Swift_Mailer $mailer): View {

        //TODO: add User invite, insert orgId into token, add email
        $organization = new Organization();
        $invite = new UserInvite();

        $submittedToken = $request->get('_csrf_token');

        if ($this->isCsrfTokenValid('create-org', $submittedToken)) {

            // get and save File
            $file = $request->files->get('image');
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('logos_directory'), $fileName);

            // set Organization variables
            $organization->setName($request->get('name'));
            $organization->setLogo($fileName);
            $organization->setLanguage('en');

            // Invite Admin
            $email = $request->get('email');
            $invite->setEmail($email);
            $invite->setOrganization($organization);
            $token = md5(uniqid());
            $invite->setToken($token);

            $repo = $this->getDoctrine()->getManager();
            $repo->persist($organization);
            $repo->persist($invite);
            $repo->flush();

            $this->sendInviteMail($mailer, $email, $token);

            return View::create($organization, Response::HTTP_CREATED);
        }
        return View::create(['error' => 'invalid token'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Modifies a Organization resource
     * @Rest\Post("/organization/edit/{orgName}")
     * @param Request $request
     * @return View
     */
    public function putOrganization(Request $request, $orgName): View {

        $submittedToken = $request->get('_csrf_token');

        if ($this->isCsrfTokenValid('delete-org', $submittedToken)) {
            $repo = $this->getDoctrine()->getManager();
            $oRepo = $repo->getRepository(Organization::class);
            $organization = $oRepo->findOneByName($orgName);
            if (!empty($organization)) {
                if(!empty($request->files->get('image'))) {
                    $file = $request->files->get('image');
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    $file->move($this->getParameter('logos_directory'), $fileName);
                    $organization->setLogo($fileName);
                }
                $organization->setName($request->get('name'));
                $organization->setLanguage($request->get('language'));

                return View::create($organization, Response::HTTP_CREATED);
            }
        }
        return View::create(['error' => 'invalid token'], Response::HTTP_UNAUTHORIZED);           
    }

    /**
     * Deletes a Organization resource
     * @Rest\Post("/organization/delete/{orgName}")
     * @param Request $request
     * @return View
     */
    public function deleteOrganization(Request $request, $orgName): View {

        $submittedToken = $request->get('_csrf_token');
        
        if ($this->isCsrfTokenValid('delete-org', $submittedToken)) {
            $repo = $this->getDoctrine()->getManager();
            $oRepo = $repo->getRepository(Organization::class);
            $organization = $oRepo->findOneByName($orgName);
            if(!empty($organization)) {
                $repo->remove($organization);
                $repo->flush();

                return View::create($organization, Response::HTTP_CREATED);
            }
        }
        return View::create(['error' => 'invalid token'], Response::HTTP_UNAUTHORIZED);            
    }

    public function sendInviteMail(\Swift_Mailer $mailer, $userEmail, $token)
    {

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom("no-reply@serpicoapp.com")
            ->setTo($userEmail)
            ->setBody(
                $this->renderView(
                    'mail/invite_mail.html.twig',
                    ["tokenValue" => $token]
                ),
                'text/html'
            )
            /* ->addPart(
                $this->renderView(
                    'Email/invite.txt.twig',
                    ["invite" => $invite]
                ),
                'text/plain'
            ) */;
        $mailer->send($message);
    }
}

?>