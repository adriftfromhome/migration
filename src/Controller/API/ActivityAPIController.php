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

class ActivityAPIController extends FOSRestController
{

}