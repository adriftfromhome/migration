<?php

namespace App\Controller\API;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use FOS\RestBundle\View\View;
use App\Entity\UserInvite;
use App\Entity\User;
use App\Entity\Organization;

class InviteAPIController extends FOSRestController {

    // TODO: resend Invite, send mail, access controll, add csrf where needed

    /**
     * Creates a User resource
     * @Rest\Post("/invite")
     * @param Request $request
     * @return View
     */
    public function postInvites(Request $request, \Swift_Mailer $mailer) : View
    {

        $user = $this->getUser();
        $orgId = $user->getOrganization()->getId();

        $submittedToken = $request->get('_csrf_token');

        if ($this->isCsrfTokenValid('invite', $submittedToken)) {

            $user = $this->getUser();
            $organization = $user->getOrganization();

            $data = $request->get('email');
            
            // splits data because of csv insertion
            $invitesAll = explode(",", $data);
            $invites = array_unique($invitesAll);

            $invites_error = [];

            // init repos
            $repo = $this->getDoctrine()->getManager();
            $urepo = $repo->getRepository(User::class);
            $irepo = $repo->getRepository(UserInvite::class);

            // TODO: send mail
            foreach ($invites as $key => $value) {

                if (!$urepo->findOneByEmail($value) && !$irepo->findOneByEmail($value)) {

                    $invite = new UserInvite();
                    $invite->setEmail($value);
                    $invite->setToken(md5(uniqid()));
                    $invite->setOrganization($organization);

                    $repo->persist($invite);
                    $repo->flush();
                    $this->sendInviteMail($mailer, $invite->getEmail(), $invite->getToken());

                } else {
                    array_push($invites_error, $value . ' : email already in database');
                }
            }
            if(empty($invites_error)) {
                array_push($invites_error, "no errors occured. All invitations have been send!");
            }
            return View::create($invites_error, Response::HTTP_CREATED);
        }
        return View::create(['error' => 'invalid Token'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Creates a User resource
     * @Rest\Get("/invite/get/organization")
     * @Rest\View(serializerGroups={"public"})
     * @param Request $request
     * @return View
     */
    public function getInvites(Request $request)
    {

        $user = $this->getUser();
        $organization = $user->getOrganization();
        $invites = $organization->getUserInvites();

        return View::create($invites, Response::HTTP_CREATED);
    }

    /**
     * Creates a User resource
     * @Rest\Get("/invite/delete/{token}")
     * @param Request $request
     * @return View
     */
    public function deleteInvite(Request $request, $token)
    {

        $user = $this->getUser();
        $repo = $this->getDoctrine()->getManager();

        $invite = $repo->getRepository(UserInvite::class)->findOneByToken($token);
        if($invite) {
            $repo->remove($invite);
            $repo->flush();
            return View::create(['status' => 'ok'], Response::HTTP_OK);
        } else {
            return View::create(['status' => 'invite not found'], Response::HTTP_BAD_REQUEST);
        }

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