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

}
