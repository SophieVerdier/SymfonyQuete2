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

        for ($i = 1; $i <= 5000; $i++) {

            $episode = new Episode();
            $episode->setSeason($this->getReference('season_'.rand(0,49)));
            $episode->setTitle('title_'.$i);
            $episode->setNumber($episodeCount += 1);
            $episode->setSynopsis('synopsis_'.$i);
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