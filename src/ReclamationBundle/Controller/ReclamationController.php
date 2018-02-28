<?php

namespace ReclamationBundle\Controller;

use Allforkids\UserBundle\Entity\User;
use AppBundle\Form\RegistrationType;
use ReclamationBundle\Entity\Cours;
use ReclamationBundle\Entity\message;
use ReclamationBundle\Entity\Reclamation;
use ReclamationBundle\Form\msgutilisateur;
use ReclamationBundle\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            $reclamation->setMail($this->getUser()->getEmail());
            $reclamation->setShortDescr($request->get('short'));
            $reclamation->setPhone($request->get('phone'));
            $reclamation->setSujet($request->get('sujet'));
            $reclamation->setDescription($request->get('desc'));
            $reclamation->setDate(new \DateTime('now'));
            $reclamation->setEtat("en attente");
            $reclamation->setUser($this->getUser());
            $em->persist($reclamation);
            $em->flush();
            $message = \Swift_Message::newInstance()
                ->setSubject('Response')
                ->setFrom('mariem.marthi@esprit.tn')
                ->setTo($this->getUser()->getEmail())
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody('votre Reclamation a etait envoyer en succée');
            $this->get('mailer')->send($message);

            return $this->redirectToRoute("ajoutR");
        }
        return $this->render('@Reclamation/Default/ajout.html.Twig', array());
    }

    # public function showAction()
    #
    #{

    #   $em = $this->getDoctrine()->getManager();
    #  $reclamation = $em->getRepository("ReclamationBundle:Reclamation")->findBy(['etat' => "en attente"]);
    # $reclamationEnCours = $em->getRepository("ReclamationBundle:Reclamation")->findBy(['etat' => "en cours"]);
    #$reclamationTraiter = $em->getRepository("ReclamationBundle:Reclamation")->findBy(['etat' => "traité"]);
    #return $this->render("ReclamationBundle:Default:List.html.twig", array("reclamtions" => $reclamation, "reclamationEnCours" => $reclamationEnCours, "reclamationtraiters" => $reclamationTraiter));

    #}
    public function showAction()
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $messages=$em->getRepository('ReclamationBundle:message')->findBy(array('user'=>$user));
        $reclamation = $em->getRepository("ReclamationBundle:Reclamation")->findBy(array('etat' => "en attente", 'user' => $user));
        $reclamationEnCours = $em->getRepository("ReclamationBundle:Reclamation")->findBy(array('etat' => "en cours", 'user' => $user));
        $reclamationTraiter = $em->getRepository("ReclamationBundle:Reclamation")->findBy(array('etat' => "traité", 'user' => $user));
        return $this->render("ReclamationBundle:Default:List.html.twig", array("reclamtions" => $reclamation, "reclamationEnCours" => $reclamationEnCours, "reclamationtraiters" => $reclamationTraiter,"message"=>$messages));

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


    public function UpdateetatAction($id, $name, Request $request)
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
        }
            $em->persist($reclamation);
            $em->flush();
            return $this->render('ReclamationBundle:Default:Motif.html.twig', array('form' => $Form->createView()));
        }

    public function annulerAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $reclamations= new Reclamation();
        $content= $request->get('message');
         $ids=$request->get('idreca');
        if ($request->isMethod('POST')) {

            $rec = $em->getRepository('ReclamationBundle:Reclamation')->find($ids);
            $message = new message();
            $message->setMessage($content);
            $reclamations->setEtat("annuler");
            $message->setReclamation($rec);
            $em->persist($message);
            $em->flush();

        }
        return $this->redirectToRoute('ListRadmin');
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
        $em = $this->getDoctrine()->getManager();
           $array=array();
            foreach ($reclamation as $r) {

            $now = date_format(new \DateTime('now'), 'Y-m-d');
            $recdate = date_format($r->getDate(), 'Y-m-d');
            $datetime1 = strtotime($now);
            $datetime2 = strtotime($recdate);
            $secs = $datetime1 - $datetime2;// == return sec in difference
            $days = $secs / 86400;
            if ($days >= 30 && $r->getEtat()=="traité"){
                $r->setEtat("archiver");
                 $array[]=$r;
                   $em->flush();
            }
            }

        #return $this->render("@Reclamation/Default/archive.html.twig", array("reclamtions" => $r, "message" => $message));
        return $this->render("@Reclamation/Default/archive.html.twig", array('reclamations' => $array));
    }

    public function rechercheAction(Request $request)
    {
        $reclamation = new Reclamation();
        $em = $this->getDoctrine()->getManager();
        $Form = $this->createForm(ReclamationType::class, $reclamation);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $reclamation = $em->getRepository("Reclamation")->findBy(array('sujet' => $reclamation->getSujet()));
        } else {
            $reclamation = $em->getRepository("ReclamationBundle:Reclamation")->findAll();
        }
        return $this->render("@Reclamation/Default/show.html.twig", array('Form' => $Form->createView(), 'reclamations' => $reclamation));

    }

    public function AjoutMessageAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $message = new message();
        $Form = $this->createForm(\ReclamationBundle\Form\Message::class, $message);
        $Form->handleRequest($request);
        if ($Form->isValid()) {

            $mail = $em->getRepository('AllforkidsUserBundle:User')->findOneBy(['id' => $id]);
            $message->setMail($mail);


            $em->persist($message);
            $em->flush();


            return $this->redirectToRoute("ListMesg");
        }
        return $this->render('ReclamationBundle:Default:LisetMessage.html.twig', array('form' => $Form->createView()));
    }

    public function showMessageAction()
    {

        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository("ReclamationBundle:message")->findAll();

        return $this->render("ReclamationBundle:Default:LisetMessage.html.twig", array("messages" => $message));

    }

    public function DeletemsgAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository("ReclamationBundle:message")->find($id);
        $em->remove($message);
        $em->flush();
        return $this->redirectToRoute('ListMesg');
    }

    public function EnvoyerMessage(Request $request, $mail)
    {
        $em = $this->getDoctrine()->getManager();
        $message = new message();
        $Form = $this->createForm(msgutilisateur::class, $message);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $em->persist($message);
            $em->flush();
        }
    }


    public function rechercheAjaxAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {
            $search = $request->get('search');
            dump($search);
            $event = new Reclamation();
            $repo = $em->getRepository('ReclamationBundle:Reclamation');
            $event = $repo->findAjax($search);
            return $this->render('@Reclamation/Default/search.html.twig', array('events' => $event));
        }


    }

    public function AjoutCoursAction(Request $request)
    {
        $cours = new Cours();
        $form = $this->createFormBuilder($cours)
            ->add('categorie')
            ->add('niveaux')
            ->add('temps')
            ->add('cible')
            ->add('titre')
            ->add('description')
            ->add('text')
            ->add('image', FileType::class)
            ->add('Ajouter', submittype::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $file = $form['image']->getData();
            $cours = $form->getData();
            $file->move('uploads/images/', $file->getClientOriginalName());
            $cours->setImage("uploads/images/", $file->getClientOriginalName());

            $em = $this->getDoctrine()->getManager();
            $em->persist($cours);
            $em->flush();
            return $this->redirectToRoute('ajoutC');
        }

        return $this->render('ReclamationBundle:Default:AjoutCour.html.twig', array('form' => $form->createView()));


    }

    public function affichemessageAction()
    {

          $em = $this->getDoctrine()->getManager();
          $user=$this->getUser();
          $messages=$em->getRepository('ReclamationBundle:message')->findBy(array('user'=>$user));
          return $this->render('ReclamationBundle:Default:message.html.twig',array('messages'=>$messages));

    }

    public function affichecoursAction()
    {


        $em = $this->getDoctrine()->getManager();
        $cours = $em->getRepository(cours::class)->findAll();


        return $this->render('ReclamationBundle:Default:affichagecours.html.twig', array('cou' => $cours));

    }

    public function AffichagecdetailsAction($id)
    {


        $em = $this->getDoctrine()->getManager();
        $cours = $em->getRepository(cours::class)->find($id);


        return $this->render('ReclamationBundle:Default:detailscours.html.twig', array('cour' => $cours));

    }

    public function toPdfAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cours = $em->getRepository(cours::class)->find($id);
        $now = (new \DateTime)->format('d-m-Y_H-i');
        $html = $this->renderView('@Reclamation/Default/print.html.twig', array('cours' => $cours,));
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="utilisateurs' . $now . '.pdf"'
            )
        );


    }

    public function serchAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $titre = $request->get('titre');
        if ($titre == null)
            $cours = $em->getRepository(cours::class)->findAll();
        else
            $cours = $em->getRepository(cours::class)->findby(array('titre' => $titre));
        return $this->render('ReclamationBundle:Default:affichagecours.html.twig', array('cou' => $cours));
    }
    public function multisearchAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $searchPara=$request->get('searchPara');
        $cours = $em->getRepository(cours::class)->search($searchPara);
        return $this->render('ReclamationBundle:Default:affichagecours.html.twig', array('cou' => $cours));
    }



}