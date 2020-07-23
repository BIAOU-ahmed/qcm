<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use App\Repository\ResultatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/eleve", name="eleve_")
*/
class EleveController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(ResultatRepository $resultat)
    {
    	$resultateleve = $resultat->findBy(
				    ['Eleve' => $this->getUser()],
				);
        return $this->render('eleve/index.html.twig', [
            'controller_name' => 'EleveController',
            'resultatseleve' => $resultateleve
        ]);
    }
    /**
     * @Route("/synthese", name="synthese")
     */
    public function synthese(ResultatRepository $resultat)
    {
    	
        return $this->render('eleve/synthese.html.twig', [
            'controller_name' => 'EleveController',
        ]);
    }
    /**
     * @Route("/realisation", name="realisation")
     */
    public function realisationqcm(ResultatRepository $resultat,QuestionRepository $quest)
    {

    	$result = $resultat->find($_POST['idresult']);
    	$questPrec = 0 ;

    	if (isset($_POST['valider'])) {
	    	
	    	$questPrec = $_POST['idquestprece'];

			dump($questPrec);
    	}

    
    	dump($questPrec);
    	$question = $quest->findBy(
				    ['idQuestionPrecedent' => $questPrec,
					 'qcm' => $result->getQcm()
					],
				);

    	if ($question==[]) {
    		
			return $this->redirectToRoute('eleve_synthese');
    	}
    	dump($question);
    	return $this->render('eleve/realisationqcm.html.twig', [
            'controller_name' => 'EleveController',
            'resultatseleve' => $result,
            'question' => $question
        ]);

    	
       
    }
}
