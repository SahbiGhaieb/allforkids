<?php
namespace Allforkids\UserBundle\Controller;
use Allforkids\UserBundle\Entity\Enfant;
use Allforkids\UserBundle\Entity\Etablissement;
use Allforkids\UserBundle\Entity\Guardian;
use Allforkids\UserBundle\Form\EnfantRegistrationType;
use Allforkids\UserBundle\Form\EtablissementType;
use Allforkids\UserBundle\Form\ParentType;
use Allforkids\UserBundle\Form\RegistrationType;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

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
    public function parentRegistrationAction(Request $request){
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $parent = new Guardian();
        $form = $this->createForm(ParentType::class, $parent);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($parent);
            $user=$this->getUser()->setParent($parent);
            $user->addRole('ROLE_PARENT');
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("allforkids_user_homepage");
        }
        return $this->render('AllforkidsUserBundle::registerParent.html.twig',array('form'=>$form->createView()));
    }
    public function etablissementRegistrationAction(Request $request){
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $etab = new Etablissement();
        $form = $this->createForm(EtablissementType::class, $etab);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($etab);
            $user=$this->getUser()->setEtablissement($etab);
            $user->addRole('ROLE_ETABLISSEMENT');
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("allforkids_user_homepage");
        }
        return $this->render('AllforkidsUserBundle::registerEtablissement.html.twig',array('form'=>$form->createView()));
    }
    public function enfantRegistrationAction(Request $request){
        if($this->isGranted('ROLE_PARENT')){
            $em=$this->getDoctrine()->getManager();
            $form = $this->createForm(EnfantRegistrationType::class);
            $userManager = $this->container->get('fos_user.user_manager');
            $form->handleRequest($request);
            if($form->isSubmitted()){
                $user = $userManager->createUser();
                $user->addRole('ROLE_ENFANT');
                $user->setEmail($form->get('email')->getData());
                $user->setNom($form->get('nom')->getData());
                $user->setPrenom($form->get('prenom')->getData());
                $user->setUsername($form->get('username')->getData());
                $user->setPassword($form->get('password')->getData());
                $user->setEnabled(1);
                $enfant = new Enfant();
                $em->persist($enfant);
                $em->flush();
                $enfant->setGuardian($this->getUser()->getParent());
                $user->setEnfant($enfant);
                $this->get('fos_user.user_manager')->updateUser($user, false);

                $em->flush();

                return $this->redirectToRoute('allforkids_user_homepage');
            }
            return $this->render('AllforkidsUserBundle::register_enfant.html.twig',array('form'=>$form->createView()));
        }
        return $this->redirectToRoute('fos_user_security_login ');
    }
}