<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SongRepository")
 */
class Song
{
    static $TIME_REGEX = '/^((([0-1][0-9])|([2][0-4])|([0-9])){1}:)?(([0-5][0-9]|[0-9]):)?([0-5][0-9]|[0-9])$/';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $length;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Album", mappedBy="songs")
     */
    private $albums;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLengthinSeconds(): string
    {
        return $this->length;
    }

    public function getLength():string {
        return sprintf('%02d:%02d:%02d',floor($this->length/3600),floor($this->length%3600/60),$this->length%3600%60);
    }

    public function setLength(string $length): self
    {
        if (!preg_match(self::$TIME_REGEX,$length)){
            throw new \Exception("Invalid length format, must be HH:mm:ss,mm:ss or ss");
        }
        $values = explode(':',$length);
        switch (sizeof($values)){
            case 1:
                $this->length = $values[0];
                break;
            case 2:
                $this->length = $values[0]*60 + $values[1];
                break;
            case 3:
                $this->length = $values[0]*60*60 + $values[1]*60 + $values[2];
                break;
        }
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
            $album->addSong($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->contains($album)) {
            $this->albums->removeElement($album);
            $album->removeSong($this);
        }

        return $this;
    }
}
