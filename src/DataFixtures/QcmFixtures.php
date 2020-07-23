<?php

namespace App\DataFixtures;

use App\Entity\Proposition;
use App\Entity\Qcm;
use App\Entity\Question;
use App\Entity\Theme;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;

class QcmFixtures extends Fixture
{
    public function load(ObjectManager $manager )
    {
        // $product = new Product();
        // $manager->persist($product);


		$faker = \Faker\Factory::create('fr_FR');
        // Creer  3 theme fakees
        for($i = 1; $i<=3; $i++){

            $theme = new Theme();
            $theme->setDescription($faker->sentence($nbWords = 5, $variableNbWords = true));

            $manager->persist($theme);

            //creer entre 4 et 6 qcm
             for ($j=1; $j <=3 ; $j++) {
            
                $qcm = new Qcm();

                $qcm->setLibelleQcm($faker->sentence($nbWords = 2, $variableNbWords = true))
                        ->setTheme($theme);

                $manager->persist($qcm);

                //on donne des question
                for($k = 1; $k<=4; $k++){


                    $time = new \DateTime("00:03:00");
                    $question = new Question();

                    $question->setLibelleQuestion($faker->sentence($nbWords = 6, $variableNbWords = true))
                            ->setTimeQuestion($time)
                            ->setQcm($qcm);

                    $manager->persist($question);


                     //on donne des proposition
                	for($l = 1; $l<=4; $l++){


	                    $proposition = new Proposition();

	                    $proposition->setLibelleProposition($faker->sentence($nbWords = 7, $variableNbWords = true))
	                            ->setResultatVraiFaux($faker->numberBetween($min = 0, $max = 1))
	                            ->setQuestion($question);

	                    $manager->persist($proposition);

                	}

                }
            }
        }

        $manager->flush();
    }
}
