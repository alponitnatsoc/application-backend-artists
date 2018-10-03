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
}
