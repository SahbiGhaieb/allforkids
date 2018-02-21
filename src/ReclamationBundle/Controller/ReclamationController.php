<?php

namespace ReclamationBundle\Controller;

use Allforkids\UserBundle\Entity\User;
use AppBundle\Form\RegistrationType;
use ReclamationBundle\Entity\Reclamation;
use ReclamationBundle\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\ReclamationBundle\Form\rechercheReclamationForm;

class ReclamationController extends Controller
{
    public function AjoutAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $reclamation = new Reclamation();
        if ($request->isMethod('POST')) {

            $reclamation->setMail($request->get('mail'));
            $reclamation->setPhone($request->get('Phone'));
            $reclamation->setSujet($request->get('sujet'));
            $reclamation->setDescription($request->get('desc'));
            $reclamation->setDate(new \DateTime('now'));
            $reclamation->setEtat("en attente");
            $reclamation->setUser($this->getUser());

            $em->persist($reclamation);
            $em->flush();


            return $this->redirectToRoute("ajoutR");
        }
        return $this->render('@Reclamation/Default/ajout.html.Twig', array());
    }

    public function showAction()
    {

        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository("ReclamationBundle:Reclamation")->findBy(['etat' => "en attente"]);
        $reclamationEnCours = $em->getRepository("ReclamationBundle:Reclamation")->findBy(['etat' => "en cours"]);
        $reclamationTraiter = $em->getRepository("ReclamationBundle:Reclamation")->findBy(['etat' => "traité"]);
        return $this->render("ReclamationBundle:Default:List.html.twig", array("reclamtions" => $reclamation, "reclamationEnCours" => $reclamationEnCours, "reclamationtraiters" => $reclamationTraiter));

    }

    public function DeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository("ReclamationBundle:Reclamation")->find($id);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute('ListR');
    }

    public function UpdateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamtion = $em->getRepository("ReclamationBundle:Reclamation")->find($id);
        $Form = $this->createForm(ReclamationType::class, $reclamtion);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamtion);
            $em->flush();
            return $this->redirectToRoute('ListR');
        }
        return $this->render("@Reclamation/Default/Update.html.twig", array('form' => $Form->createView()));
    }

    public function showAdminAction()
    {

        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository("ReclamationBundle:Reclamation")->findAll();

        return $this->render("@Reclamation/Default/show.html.twig", array("reclamtions" => $reclamation));

    }

    public function UpdateetatAction($id, $name)
    {

        $em = $this->getDoctrine()->getManager();

        $reclamation = $em->getRepository("ReclamationBundle:Reclamation")->find($id);
        if
        ($name == 'en cours') {
            $reclamation->setEtat("en cours");
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('ListRadmin');
            //return new Response($id);
        } elseif
        ($name == 'traité') {
            $reclamation->setEtat("traité");
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('ListRadmin');
        } elseif
        ($name == 'annuler') {
            $reclamation->setEtat("annuler");
            $em->persist($reclamation);
            $em->flush();
            return $this->render('ReclamationBundle:Default:Motif.html.twig');
        }
    }
    public function afficheEAction($id)
    {


        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);



        return $this->render('ReclamationBundle:Default:consulterR.html.twig', array('reclamtions' => $reclamation));

    }





    public function archiverAction()
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository("ReclamationBundle:Reclamation")->findAll();
        foreach ($reclamation as $r) {

            $now = date_format(new \DateTime('now'), 'Y-m-d H:i:s');
            $recdate = date_format($r->getDate(), 'Y-m-d H:i:s');
            $datetime1 = strtotime($now);
            $datetime2 = strtotime($recdate);
            $secs = $datetime1 - $datetime2;// == return sec in difference
            $days = $secs / 86400;
            if ($days > 30 && $r->getEtat() == "traité") {
                $r->setEtat("archivé");
            }
            return $this->render("@Reclamation/Default/archive.html.twig", array("reclamtions" => $r));

        }
    }
    public function filterAction(Request $request){
        $reclamation=new Reclamation();
        $em=$this->getDoctrine()->getManager();
        $Form=$this->createForm(ReclamationType::class,$reclamation);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $reclamation = $em->getRepository("Reclamation")->findBy(array('sujet' => $reclamation->getSujet()));
        }
        else {
            $reclamation = $em->getRepository("ReclamationBundle:Reclamation")->findAll();
        }
        return $this->render("@Reclamation/Default/show.html.twig",array('Form'=>$Form->createView(),'reclamations'=>$reclamation));

        }


}
