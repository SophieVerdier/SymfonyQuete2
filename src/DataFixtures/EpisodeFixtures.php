<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {        $episodeCount = 0;

        $faker = Factory::create();

        for ($i = 1; $i <= 500; $i++) {

            $episode = new Episode();
            $episode->setSeason($this->getReference('season_' . $faker->unique()->numberBetween(0, 500)));
            $episode->setTitle($faker->words(rand(2, 6), true));
            $episode->setNumber($episodeCount += 1);
            $episode->setSynopsis($faker->paragraph(3));
            $manager->persist($episode);
            
        }
        
        $manager->flush();
    }


   public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            SeasonFixtures::class,
               
        ];
    }
}