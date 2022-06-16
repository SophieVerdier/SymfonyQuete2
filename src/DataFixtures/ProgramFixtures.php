<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    public const PROGRAMS = [
         [
            'Title' => 'The Walking Dead',
            'category' => 'Horreur',
            'synopsis' => 'A group of survivors find themselves in the midst of a zombie apocalypse.',
             ],
         [
            'Title' => 'Game of Thrones',
            'category' => 'Fantastique',
            'synopsis' => 'Nine noble families fight for control over the mythical lands of Westeros, while an ancient enemy returns after being dormant for thousands of years.',
         ],
         [
            'Title' => 'Petit Ours Brun',
            'category' => 'Animation',
            'synopsis' => 'A bear family is forced to flee their home after being attacked by a group of racoons.',
            ],
           [      
            'Title' => 'Lost',
            'category' => 'Action',
            'synopsis' => 'Survivors from flight 815 found themselves on a deserted magical island.',
            ],
            [
            'Title' => 'The hundred',
            'category' => 'Aventure',
            'synopsis' => 'A group of survivors from the earth is forced to face a deadly virus that has been unleashed on the planet.',
            ],
        ];

    
    public function load(ObjectManager $manager) 
    {
        foreach (self::PROGRAMS as $key => $programData) {
            $program = new Program();
            $program->setTitle($programData['Title']);
            $program->setSynopsis($programData['synopsis']);
            $program->setCategory($this->getReference('category_'.$programData['category']));
            $manager->persist($program);
            $this->addReference('program_'. $key, $program);

        }
       
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          CategoryFixtures::class,
        ];
    }


}

