<?php

namespace App\Entity;

use App\Repository\RestaurantPictureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestaurantPictureRepository::class)
 */
class RestaurantPicture
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
    private $filename;

    /**
     * @ORM\ManyToOne(targetEntity=restaurant::class, inversedBy="restaurantPictures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurantId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getRestaurantId(): ?restaurant
    {
        return $this->restaurantId;
    }

    public function setRestaurantId(?restaurant $restaurantId): self
    {
        $this->restaurantId = $restaurantId;

        return $this;
    }
}
