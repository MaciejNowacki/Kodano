<?php

declare(strict_types=1);

namespace App\Application\DataFixtures;

use App\Domain\Entity\Category;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductCategoriesFixtures extends Fixture
{
    private array $categories = [
        "Wmn_Cloth",
        "Phn_Accss",
        "Fant_Book",
        "SmHldApp",
        "Edu_Toys",
        "OffcSupp",
        "MkupCosm",
        "HndTools",
        "Dry_Food",
        "BrdGames",
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->categories as $category) {
            $category = new Category($category);

            $manager->persist($category);
        }


        $manager->flush();
    }
}
