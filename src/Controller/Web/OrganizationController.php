<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class OrganizationController extends AbstractController {


    /**
     * renders the create organization page
     * @Route("/createOrg")
     * @param Request $request
     */
    public function organization(Request $request) {

        return $this->render('organization/createOrg.html.twig');
    }

}

?>