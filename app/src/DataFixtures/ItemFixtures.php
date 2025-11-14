<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ItemFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i<10; ++$i) {
            $item = new Item();
            $item->setName('Item_' . $i);
            $manager->persist($item);
        }

        $manager->flush();
    }
}
