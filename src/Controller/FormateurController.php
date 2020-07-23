<?php

namespace App\Controller;

use App\Entity\Qcm;
use App\Entity\Resultat;
use App\Entity\User;
use App\Form\AjoutUtilisateurType;
use App\Repository\PropositionRepository;
use App\Repository\QcmRepository;
use App\Repository\QuestionRepository;
use App\Repository\ResultatRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/formateur", name="formateur_")
 */
class FormateurController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('formateur/index.html.twig', [
            'controller_name' => 'FormateurController',
        ]);
    }
    /**
     * @Route("/utilisateurs", name="listUti")
     */
    public function utilisateurs(UserRepository $user)
    {

    	$utilisateurs = $user->findall();

        return $this->render('formateur/utilisateurs.html.twig',[
			'controller_name' => 'BlogController',
			'utilisateurs' => $utilisateurs
		]);
    }

    /**
     * @Route("/resultat", name="resueleve")
     */
    public function resultat(ResultatRepository $result, UserRepository $user, EntityManagerInterface $em)
    {

    	$resultatseleve = $user->findAllResultat();

    	dump($resultatseleve);
        return $this->render('formateur/resultat.html.twig',[
			'controller_name' => 'BlogController',
			'resultats' => $resultatseleve
		]);
    }

    /**
     * @Route("/afectation", name="afecttUti")
     */
    public function afectation( Request $request, EntityManagerInterface $em, UserRepository $user, QcmRepository $qcm)
    {

    	$eleves = $user->findBy(
				    ['type' => 'Eleve'],
				);
    	$qcms = $qcm->findall();


    	if (isset($_POST['affecter'])) {
	    	if (isset($_POST['utili'])) {

		    	dump($_POST['qcm']);
		    	foreach($_POST['utili'] as $valeur){
			        
			        $time = new \DateTime($_POST['date']);
			        $id = $_POST['utili'] ;
			        dump($valeur);
			        $eleve = $user->find($valeur);
			        dump($eleve);
			        $newQcm = $qcm->find($_POST['qcm']);
			        dump($newQcm);
		    		dump($_POST['date']);
			        $enseignant = $this->getUser();
			        dump($enseignant);
		    		$resultat = new Resultat();

		    		$resultat->setAffecttedAt($time)
		    					->setEnseignant($enseignant)
		    					->setEleve($eleve)
		    					->setQcm($newQcm)
		    					;
		    		dump($resultat);

		    		$em->Persist($resultat);
		    	}

				$em->flush();
	    	}
    	}

        return $this->render('formateur/afectation.html.twig',[
			'controller_name' => 'BlogController',
			'eleves' => $eleves,
			'qcms' => $qcms
		]);
    }

    /**
     * @Route("/utilisateurs/new", name="ajoutUti")
	 * @Route("/utilisateurs/{id}/edit", name="editUti")
     */
    public function create(User $user = null, Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {

    	if(!$user){

			$user = new user();

		}

    	
    	$form = $this->createForm(AjoutUtilisateurType::class, $user);

    	$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()){

			// if(!$user->getId()){

			// 	$article->setCreatedAt(new \DateTime());

			// }

			$hash = $encoder->encodePassword($user,$user->getPassword());
   			
   			$user->setPassword($hash);

   			if($user->getType()=='Formateur'){

   				$user->setRoles(array('ROLE_ADMIN'));
   			}
   			elseif ($user->getType()=='Eleve') {
   				
   				$user->setRoles(array('ROLE_USER'));
   			}
			

			$em->Persist($user);
			$em->flush();

			return $this->redirectToRoute('formateur_listUti');
		}

        return $this->render('formateur/create.html.twig',[
			'formUser' => $form->createView(),
			'editMode' => $user->getId() !== null
		]);
    }



    /**
     * @Route("/gestionqcm", name="gestionqcm")
     */
    public function gestionqcm()
    {

    	
        return $this->render('formateur/gestionqcm.html.twig',[
			'controller_name' => 'BlogController',
		]);
    }

    /**
     * @Route("/affichageqcm", name="afficheqcm")
     */
    public function affichageqcm(QcmRepository $qcm, QuestionRepository $question, PropositionRepository $propo)
    {

    	
    	$qcms = $qcm->findall();

    	if (isset($_POST['affiche'])) {

	       
	       $nbquestion = $qcm->nbquestiondispo($_POST['qcm']);
	       $qcmafficheentete  = $qcm->find($_POST['qcm']);
	       $questionaffiche = $question->findBy(
				    ['qcm' => $qcmafficheentete],
				);
	       $propoaffiche = $propo->findBy(
				    ['question' => $questionaffiche],
				);
	       $qcmaffiche = $qcm->qcmaffiche($_POST['qcm']);
	       dump($qcmaffiche);

	       return $this->render('formateur/affichageqcm.html.twig',[
			'controller_name' => 'BlogController',
			'type' => 'reaffiche',
			'qcms' => $qcms,
			'nbques' => $nbquestion[0]['nbquestion'],
			'qcmsafficheentete' => $qcmafficheentete,
			'qcmsaffiche' => $questionaffiche,
			]);
	    	
		}

        return $this->render('formateur/affichageqcm.html.twig',[
			'controller_name' => 'BlogController',
			'type' => 'entete',
			'qcms' => $qcms
		]);
    }

    /**
     * @Route("/supprimerqcm", name="supprqcm")
     */
    public function supprimerqcm(QcmRepository $qcm, EntityManagerInterface $em)
    {

    	
    	$qcms = $qcm->findall();

		if (isset($_POST['suppr'])) {

	        $entityManager = $this->getDoctrine()->getManager();
        	$delqcm = $entityManager->getRepository(QCM::class)->find($_POST['idsuppr']);
        	$nbassigneqcm = $qcm->findnbassigne($_POST['idsuppr']);
        	dump($nbassigneqcm[0]['nbassigne']);

   //      	$entityManager->remove($qcm);
			// $entityManager->flush();

			// return $this->redirectToRoute('formateur_supprqcm');
	    	
		}

        return $this->render('formateur/supprimerqcm.html.twig',[
			'controller_name' => 'BlogController',
			'qcms' => $qcms
		]);
    }


}
