<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\ProductRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: ProductRepositoryInterface::class)]
#[ORM\Table(name: 'products')]
class Product
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'categories')]
    #[JoinTable(name: 'products_categories')]
    private Collection $categories;

    public function __construct(
        #[ORM\Column(name: 'name', type: Types::STRING)]
        private ?string $name = null,
        #[ORM\Column(name: 'price', type: Types::FLOAT)]
        private ?float $price = null, // TODO: VO?
    )
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): Product
    {
        $this->price = $price;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Product
    {
        $this->name = $name;
        return $this;
    }
}
