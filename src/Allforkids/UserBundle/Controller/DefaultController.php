<?php

namespace Allforkids\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('layout.html.twig');
    }
    public function adminAction()
    {
        if ($this->isGranted('ROLE_ADMIN')){
            return $this->render('back.html.twig');
        }
        else return $this->redirectToRoute('allforkids_user_homepage');

    }
}
