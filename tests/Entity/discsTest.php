<?php

namespace App\Tests\Entity;

use App\Entity\Disc;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DiscTest extends KernelTestCase
{
    public function getEntity(): Disc {
        return $disc = (new Disc())
        ->setTitle('Zick Zack')
        ->setYear('2020')
        ->setGenre('Metal')
        ->setLabel('Universal')
        ->setPrice('2200');
    }

    public function assertHasError(Disc $disc, $number = 0) {
        self::bootKernel();
        $container = static::getContainer();
        $error = $container->get('validator')->validate($disc);
        $this->assertCount($number, $error);
    }

    public function testValid() {
        $this->assertHasError($this->getEntity(), 0);
    }

    public function testDigitInvalid() {
        $this->assertHasError($this->getEntity()->setTitle('@@@'), 0);
    }

    public function testBlankInvalid() {
        $this->assertHasError($this->getEntity()->setTitle(('')), 1);
    }
}