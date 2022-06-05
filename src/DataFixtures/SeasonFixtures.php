<?php

namespace App\DataFixtures;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 50; $i++) {
            $season = new Season();
            $season->setYear($i);
            $season->setNumber($i);
            $season->setDescription('BreakingBad_' .$i);
            $season->setProgram($this->getReference('program_'. ProgramFixtures::PROGRAMS[rand(0,4)]['category']));
            $manager->persist($season);
            $this->addReference('season_'.$i, $season);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
            ProgramFixtures::class
        ];
    }
}