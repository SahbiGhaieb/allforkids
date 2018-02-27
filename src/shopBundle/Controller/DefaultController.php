<?php

namespace shopBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use shopBundle\Entity\Produit;
use shopBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function wishlistParentAction(){
        $em = $this->getDoctrine()->getManager();
        $enfants = $em->getRepository('AllforkidsUserBundle:Guardian')
            ->findby(array('guardian'=>$this->getUser()->getParent()->getEnfants()));
        $wishlists = new ArrayCollection();
        foreach ($enfants as $enfant){
            $wishlists->add($em->getRepository("shopBundle:Wishlist")->findby(array('enfant'=>$enfant->getId())));
        }
        $this->render('shopBundle:Default:wishlist.html.twig',array('wishlists' => $wishlists));
    }
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("shopBundle:Produit")->findAll();
        return $this->render('shopBundle:Default:listProduits.html.twig',array("produits" => $produit));
    }

    public function viewProdAction($id){
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("shopBundle:Produit")->find($id);

        return $this->render('shopBundle:Default:viewSingle.html.twig',array('produit'=>$produit));
    }
}