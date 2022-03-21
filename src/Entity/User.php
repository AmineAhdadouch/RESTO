<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=city::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cityId;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="userId", orphanRemoval=true)
     */
    private $yes;

    public function __construct()
    {
        $this->yes = new ArrayCollection();
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

    public function getCityId(): ?city
    {
        return $this->cityId;
    }

    public function setCityId(?city $cityId): self
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getYes(): Collection
    {
        return $this->yes;
    }

    public function addYe(Review $ye): self
    {
        if (!$this->yes->contains($ye)) {
            $this->yes[] = $ye;
            $ye->setUserId($this);
        }

        return $this;
    }

    public function removeYe(Review $ye): self
    {
        if ($this->yes->removeElement($ye)) {
            // set the owning side to null (unless already changed)
            if ($ye->getUserId() === $this) {
                $ye->setUserId(null);
            }
        }

        return $this;
    }
}
