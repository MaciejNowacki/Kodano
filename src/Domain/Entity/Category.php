<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\CategoryRepositoryInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepositoryInterface::class)]
#[ORM\Table(name: 'categories')]
#[ORM\HasLifecycleCallbacks]
class Category
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /** @phpstan-ignore property.unusedType */
    private ?int $id = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'categories')]
    /** @phpstan-ignore property.onlyRead */
    private Collection $products;

    public function __construct(
        #[ORM\Column(name: 'code', type: Types::STRING, length: 10, unique: true)]
        private ?string $code = null,
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): Category
    {
        $this->code = $code;
        return $this;
    }
}
