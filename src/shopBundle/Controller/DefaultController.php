<?php

namespace shopBundle\Controller;

use shopBundle\Entity\Produit;
use shopBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("shopBundle:Produit")->findAll();
        return $this->render('shopBundle:Default:listProduits.html.twig',array("produits" => $produit));
    }
    public function adminProdAction(){
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("shopBundle:Produit")->findAll();
        return $this->render('shopBundle:Default:listAdmin.html.twig',array("produits" => $produit));
    }

    public function addProduitAction(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($request->isMethod('POST')) {
            /**
             * @var UploadedFile $file
             */
            $file=$produit->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
              $this->getParameter('image_directory'),$fileName
            );
            $produit->setImage($fileName);

            $em=$this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute("shop_homepage");
        }
        return $this->render('shopBundle:Default:ajouterProduit.html.twig',array('form'=>$form->createview()));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("shopBundle:Produit")->find($id);
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute('shop_homepage');
    }

    public function updateAction (Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository("shopBundle:Produit")->find($id);
        $Form = $this->createForm(ProduitType::class,$produit);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('shop_homepage');
        }
        return $this->render("shopBundle:Default:updateProduit.html.twig",array('form'=>$Form->createView()));
    }

}