<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class InviteController extends AbstractController
{
    /**
     * renders the create invitation page
     * @Route("/invite")
     * @param Request $request
     */
    public function invite(Request $request) {
        return $this->render('invite/invite.html.twig');
    }
}

?>