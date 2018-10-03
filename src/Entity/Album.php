<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 */
class Album
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cover;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Artist",inversedBy="albums")
     * @ORM\JoinTable(name="album_artist",
     *      joinColumns={@ORM\JoinColumn(referencedColumnName="token",onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(referencedColumnName="token",onDelete="CASCADE")}
     * )
     */
    private $artists;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Song", inversedBy="albums")
     * @ORM\JoinTable(name="album_songs",
     *      joinColumns={@ORM\JoinColumn(referencedColumnName="token",onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $songs;

    public function __construct()
    {
        $this->artists = new ArrayCollection();
        $this->songs = new ArrayCollection();
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

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Artist[]
     */
    public function getArtists(): Collection
    {
        return $this->artists;
    }

    public function addArtist(Artist $artist): self
    {
        if (!$this->artists->contains($artist)) {
            $this->artists[] = $artist;
        }

        return $this;
    }

    public function removeArtist(Artist $artist): self
    {
        if ($this->artists->contains($artist)) {
            $this->artists->removeElement($artist);
        }

        return $this;
    }

    /**
     * @return Collection|Song[]
     */
    public function getSongs(): Collection
    {
        return $this->songs;
    }

    public function addSong(Song $song): self
    {
        if (!$this->songs->contains($song)) {
            $this->songs[] = $song;
        }

        return $this;
    }

    public function removeSong(Song $song): self
    {
        if ($this->songs->contains($song)) {
            $this->songs->removeElement($song);
        }

        return $this;
    }
}
