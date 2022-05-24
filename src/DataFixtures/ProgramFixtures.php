<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    const PROGRAMS = [
        'program1' => [
            'Title' => 'The Walking Dead',
            'category' => 'Category_Horreur',
            'synopsis' => 'A group of survivors find themselves in the midst of a zombie apocalypse.',
             ],
        'program2' => [
            'Title' => 'Game of Thrones',
            'synopsis' => 'Nine noble families fight for control over the mythical lands of Westeros, while an ancient enemy returns after being dormant for thousands of years.',
            ],  
        'program3' => [
            'Title' => 'Petit Ours Brun',
            'synopsis' => 'A bear family is forced to flee their home after being attacked by a group of racoons.',
            ],
          'program4' => [      
            'Title' => 'Lost',
            'synopsis' => 'Survivors from flight 815 found themselves on a deserted magical island.',
            ],
            'program5' => [
            'Title' => 'The hundred',
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

