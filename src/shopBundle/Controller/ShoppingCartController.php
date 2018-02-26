<?php

namespace shopBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use shopBundle\Entity\Cart;
use shopBundle\Entity\Commande;
use shopBundle\Entity\Produit;
use shopBundle\Form\ProduitType;
use shopBundle\Form\quantiteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\SecurityBundle\Tests\Functional\Bundle\AclBundle\Entity\Car;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;


class ShoppingCartController extends Controller
{
    public function indexAction(Request $request)
    {
        if($this->isGranted('ROLE_PARENT')){
            $em = $this->getDoctrine()->getManager();
            $commandes =  $em->getRepository('shopBundle:Commande')->findBy(array('guardian'=>$this->getUser()->getId()));
            if ($request->isMethod('POST')) {

                $commande  = $em->getRepository('shopBundle:Commande')->find($request->get('id'));
                $commande-> setQuantite($request->get('quantite'));
                $em->persist($commande);
                $em->flush();
                return $this->redirectToRoute("shop_cart");
            }
            return $this->render('shopBundle:Default:cart.html.twig',array('commandes' => $commandes));
        }
        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }

    public function addToBasketAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("shopBundle:Produit")->find($id);
        $commande = $em->getRepository("shopBundle:Commande")
            ->findOneBy(array('guardian'=>$this->getUser()->getId(),'produit'=>$produit->getId()));
        $produit->setQuantiteStock($produit->getQuantiteStock()-1);
        if($commande){
            $commande->setQuantite($commande->getQuantite()+1);
            $em->persist($commande);
            $em->flush();
            return $this->redirect($this->generateUrl('shop_cart'));
        }
        $commande = new Commande();
        $commande->setProduit($produit);
        $commande->setGuardian($this->getUser()->getParent());
        $commande->setQuantite(1);
        $commande->setValide(0);
        $em->persist($commande);
        $em->flush();


        return $this->redirect($this->generateUrl('shop_cart'));
    }
    public function suppCmdAction($id){
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository("shopBundle:Commande")->find($id);
        $em->remove($commande);
        $em->flush();
        return $this->redirect($this->generateUrl('shop_cart'));
    }
}