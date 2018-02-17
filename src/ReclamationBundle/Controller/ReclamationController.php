<?php

namespace ReclamationBundle\Controller;

use AppBundle\Form\RegistrationType;
use ReclamationBundle\Entity\Reclamation;
use ReclamationBundle\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\ReclamationBundle\Form\rechercheReclamationForm;

class ReclamationController extends Controller
{
    public function AjoutAction(Request $request)
    {
        $em =$this->getDoctrine()->getManager();
        $reclamation  = new Reclamation();
        if ($request->isMethod('POST')) {
            $reclamation-> setNom($request->get('name'));
            $reclamation-> setMail($request->get('mail'));
            $reclamation-> setPhone($request->get('Phone'));
            $reclamation-> setSujet($request->get('sujet'));
            $reclamation->setDescription($request->get('desc'));
            $reclamation->setDate( new \DateTime('now'));
            $reclamation->setEtat(0);

            $em->persist($reclamation);
            $em->flush();


            return $this->redirectToRoute("ajoutR");
        }
        return $this->render('@Reclamation/Default/ajout.html.Twig',array());
    }
    public function showAction (){
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository("ReclamationBundle:Reclamation")->findAll();
        $reclamationEnCours=$em->getRepository("ReclamationBundle:Reclamation")->findBy(['etat' => 0]);
        $reclamationTraiter=$em->getRepository("ReclamationBundle:Reclamation")->findBy(['etat' => 1]);
        return $this->render("ReclamationBundle:Default:List.html.twig",array("reclamtions"=>$reclamation,"reclamationEnCours"=>$reclamationEnCours,"reclamationtraiters"=>$reclamationTraiter));

    }
    public function DeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository("ReclamationBundle:Reclamation")->find($id);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute('ListR');
    }
    public function UpdateAction (Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamtion=$em->getRepository("ReclamationBundle:Reclamation")->find($id);
        $Form = $this->createForm(ReclamationType::class,$reclamtion);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamtion);
            $em->flush();
            return $this->redirectToRoute('ListR');
        }
        return $this->render("ReclamationBundle:Default:UpdateR.html.twig",array('form'=>$Form->createView()));
    }



}
