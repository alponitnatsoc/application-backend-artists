<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtistRepository")
 */
class Artist
{
    /**
     * @ORM\ID()
     * @ORM\Column(unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Utils\TokenGenerator")
     * @ORM\Column(type="string", length=6, unique=true)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Album", mappedBy="artists")
     */
    private $albums;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    public function getToken(): ?string
    {
        return $this->token;
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

    /**
     * @return Collection|Album[]
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->addArtist($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->contains($album)) {
            $this->albums->removeElement($album);
            $album->removeArtist($this);
        }

        return $this;
    }
}
