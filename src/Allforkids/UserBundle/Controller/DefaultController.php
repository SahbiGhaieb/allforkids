<?php

namespace Allforkids\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AllforkidsUserBundle::layout.html.twig');
    }
    public function adminAction()
    {
        return $this->render('AllforkidsUserBundle::back.html.twig');
    }
}
