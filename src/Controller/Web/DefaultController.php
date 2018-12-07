<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SignUpFormType;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;

class DefaultController extends AbstractController
{
    public function index(Request $request) {

        return $this->render('user/home.html.twig');      
    }

    //
}
