<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\creationForms\CreateOrgFormType;
use App\Entity\Organization;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    public function createOrg(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $user = $this->user();

        

        return $this->render('admin/createOrg.html.twig', ['form' => $form->createView()]);
    }

    public function inviteUser(Request $request) {
        
    }
}
