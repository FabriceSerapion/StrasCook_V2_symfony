<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    // We probably have to keep this singular $rating as well as the plural $ratings (from the ManyToOne on line 50)
    // plural $ratings = get ratings from users, make an average of it and declare it as singular $rating
    #[ORM\Column(nullable: true)]
    private ?float $rating = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_appetizer = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_starter = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_meal = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_dessert = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_cheese = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_cuteness = null;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'menus')]
    private Collection $tags;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: UserRating::class, orphanRemoval: true)]
    private Collection $ratings;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->ratings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        // TODO : get ratings from UserRating and make an average of them
        $this->rating = $rating;

        return $this;
    }

    public function getDescrAppetizer(): ?string
    {
        return $this->descr_appetizer;
    }

    public function setDescrAppetizer(?string $descr_appetizer): self
    {
        $this->descr_appetizer = $descr_appetizer;

        return $this;
    }

    public function getDescrStarter(): ?string
    {
        return $this->descr_starter;
    }

    public function setDescrStarter(?string $descr_starter): self
    {
        $this->descr_starter = $descr_starter;

        return $this;
    }

    public function getDescrMeal(): ?string
    {
        return $this->descr_meal;
    }

    public function setDescrMeal(?string $descr_meal): self
    {
        $this->descr_meal = $descr_meal;

        return $this;
    }

    public function getDescrDessert(): ?string
    {
        return $this->descr_dessert;
    }

    public function setDescrDessert(?string $descr_dessert): self
    {
        $this->descr_dessert = $descr_dessert;

        return $this;
    }

    public function getDescrCheese(): ?string
    {
        return $this->descr_cheese;
    }

    public function setDescrCheese(?string $descr_cheese): self
    {
        $this->descr_cheese = $descr_cheese;

        return $this;
    }

    public function getDescrCuteness(): ?string
    {
        return $this->descr_cuteness;
    }

    public function setDescrCuteness(?string $descr_cuteness): self
    {
        $this->descr_cuteness = $descr_cuteness;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection<int, UserRating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }
}
