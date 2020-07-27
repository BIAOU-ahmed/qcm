<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Repository\PropositionRepository;
use App\Repository\QuestionRepository;
use App\Repository\ReponseRepository;
use App\Repository\ResultatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

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
    public function synthese( ResultatRepository $resultat)
    {
    	
        return $this->render('eleve/synthese.html.twig', [
            'controller_name' => 'EleveController',
        ]);
    }
    /**
     * @Route("/realisation", name="realisation")
     */
    public function realisationqcm(Request $request,ResultatRepository $resultat,PropositionRepository $propo, QuestionRepository $quest, EntityManagerInterface $em)
    {
       
       
        
    	$result = $resultat->find($_POST['idresult']);
    	$questPrec = 0 ;
        $numQuestion = 1;
        


        dd($result->CalculNoteQCM( $result));
    	if (isset($_POST['passer'])) {
	    	
	    	$questPrec = $_POST['idquestprece'];
            $numQuestion = (int)$_POST['num_question']+1;

    	}
        if (isset($_POST['valider'])) {
            $countidpropo =0;
            foreach($_POST['propoeleve'] as $valeur){
              
              
                $proposition = $propo->find($_POST['idproposition'][$countidpropo]);

                if($valeur=='on'){
              
                   $newrep = new Reponse();

                    $newrep->setIdResultat($result)
                    ->setIdProposition($proposition)
                    ->setReponseEleve(1)
                    ;

                    $em->Persist($newrep);
                    $em->flush();
                }elseif ($valeur=="") {

                    $newrep = new Reponse();

                    $newrep->setIdResultat($result)
                    ->setIdProposition($proposition)
                    ->setReponseEleve(0)
                    ;
                    $em->Persist($newrep);
                    $em->flush();

                }

               
                $countidpropo++;
            }
            
            dump('resu'.$_POST['num_question'],'to'.$_POST['idresult'],'ti'.$_POST['idquestprece']);
            $questPrec = $_POST['idquestprece'];
            $numQuestion = (int)$_POST['num_question']+1;

            dump($questPrec);
        }

        $question = $quest->findBy(
                ['idQuestionPrecedent' => $questPrec,
                 'qcm' => $result->getQcm()
                    ],
                );
        
    	if ($question==[]) {
            
            $result->setRealiseAt(new \DateTime())
            ->setNote($question[0]->ValiditéQuestion($question[0], $result, $propo))
            ;
            dd($result);
    		
			return $this->redirectToRoute('eleve_synthese');
    	}
    	return $this->render('eleve/realisationqcm.html.twig', [
            'controller_name' => 'EleveController',
            'resultatseleve' => $result,
            'question' => $question,
            'numQuestion' => $numQuestion
        ]);

    	
       
    }
}
