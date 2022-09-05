<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Disc;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Jeu1 extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $artist1 = new Artist();
        $artist1->setName("Queens Of The Stone Age");
        $artist1->setUrl("https://qotsa.com/");
        $manager->persist($artist1);

        $artist2 = new Artist();
        $artist2->setName("Rammstein");
        $artist2->setUrl("https://rammsteinworld.com/");
        $manager->persist($artist2);

        $artist3 = new Artist();
        $artist3->setName("ARTIST_1");
        $artist3->setUrl("SITE");
        $manager->persist($artist3);


        $disc1= new Disc();
        $disc1->setTitle("Songs for the Dead");
        $disc1->setPicture("https://upload.wikimedia.org/wikipedia/en/thumb/0/01/Queens_of_the_Stone_Age_-_Songs_for_the_Deaf.png/220px-Queens_of_the_Stone_Age_-_Songs_for_the_Deaf.png");
        $disc1->setLabel("interscope Records");
        $disc1->setYear("2002");
        $disc1->setGenre('GENRE_1');
        $disc1->setPrice('12');
        $manager->persist($disc1);
        $disc1->setArtist($artist1);

        $disc2 = new Disc();
        $disc2->setTitle("Fugazi");
        $disc2->setPicture("https://upload.wikimedia.org/wikipedia/en/thumb/1/19/Marillion_-_Fugazi.jpg/220px-Marillion_-_Fugazi.jpg");
        $disc2->setLabel("EMI");
        $disc2->setYear("1984");
        $disc2->setGenre('GENRE_2');
        $disc2->setPrice('1.0');
        $manager->persist($disc2);
        $disc2->setArtist($artist1);

        $disc3 = new Disc();
        $disc3->setTitle("Zick Zack");
        $disc3->setPicture("https://upload.wikimedia.org/wikipedia/en/thumb/9/93/ZickZacksingle.jpg/220px-ZickZacksingle.jpg");
        $disc3->setLabel("Universal");
        $disc3->setYear("2022");
        $disc3->setGenre('Metal Industriel');
        $disc3->setPrice('999');
        $manager->persist($disc3);
        $disc3->setArtist($artist2);

        $manager->flush();
    }
}
