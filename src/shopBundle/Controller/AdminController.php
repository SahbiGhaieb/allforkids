<?php

namespace shopBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use shopBundle\Entity\Produit;
use shopBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    //afficher le nom de department et le manager_id des villes dont le nom commance par l
    public function statstiqueAction(){
        $pieChart = new PieChart();
        $em = $this->getDoctrine();
        $produits = $em->getRepository("shopBundle:Produit")->findAll();
        $totalProduit = 0;
        foreach ($produits as $produit) {
            $totalProduit = $totalProduit+1;
        }
        $data = array();
        $stat = ['produit','totalProduit'];
        $nb = 0;
        array_push($data,$stat);
        foreach ($produits as $produit){
            $stat = array();
            array_push($stat, $produit->getQuantiteStock(),($totalProduit*100)/$totalProduit);
            $nb = ($totalProduit*100)/$totalProduit;
            $stat = [$produit->getNom(),$nb];
            array_push($data,$stat);
        }
        $pieChart->getData()->setArrayToDataTable($data);
        $pieChart->getOptions()->setTitle('Pourcentage des produits');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('shopBundle:Default:StatProduits.html.twig',array('pieChart'=>$pieChart));
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
            return $this->redirectToRoute("admin_shop_homepage");
        }
        return $this->render('shopBundle:Default:ajouterProduit.html.twig',array('form'=>$form->createview()));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("shopBundle:Produit")->find($id);
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute('admin_shop_homepage');
    }

    public function updateAction (Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository("shopBundle:Produit")->find($id);
        $Form = $this->createForm(ProduitType::class,$produit);
        $Form->handleRequest($request);
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
            return $this->redirectToRoute("admin_shop_homepage");
        }
        return $this->render("shopBundle:Default:updateProduit.html.twig",array('form'=>$Form->createView()));
    }

}