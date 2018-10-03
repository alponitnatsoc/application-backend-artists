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
}
