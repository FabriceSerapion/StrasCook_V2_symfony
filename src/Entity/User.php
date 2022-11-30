<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(
        type: 'string',
        length: 255)]
    #[Assert\NotBlank(
        message: 'Le nom d\'utilisateur est nécessaire !')]
    #[Assert\Length(
        max: 255,
        maxMessage: '{{ value }} est trop long, veuillez entrer maximum {{ limit }} caractères.')]
    private ?string $username = null;

    #[ORM\Column(
        type: 'string',
        length: 255)]
    #[Assert\NotBlank(
        message: 'Le mot de passe est nécessaire !')]
    #[Assert\Length(
        max: 255,
        maxMessage: '{{ value }} est trop long, veuillez entrer maximum {{ limit }} caractères.')]
    private ?string $password = null;

    #[ORM\Column(
        type: Types::BOOLEAN,
        nullable: true)]
    private ?bool $isAdmin = null;

    #[ORM\OneToMany(
        mappedBy: 'customer',
        targetEntity: Booking::class)]
    // this side of the relation will probably be useful to get a history of past bookings
    private Collection $bookings;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: UserRating::class)]
    private Collection $ratings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->ratings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsAdmin(): ?int
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(?int $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setCustomer($this);
        }

        return $this;
    }

    // TODO Will this feature be used ?
    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getCustomer() === $this) {
                $booking->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserRating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(UserRating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings->add($rating);
            $rating->setCustomer($this);
        }

        return $this;
    }

    public function removeRating(UserRating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getCustomer() === $this) {
                $rating->setCustomer(null);
            }
        }

        return $this;
    }
}
