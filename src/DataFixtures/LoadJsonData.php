<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadJsonData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $jsonStr = file_get_contents("https://gist.githubusercontent.com/fightbulc/9b8df4e22c2da963cf8ccf96422437fe/raw/8d61579f7d0b32ba128ffbf1481e03f4f6722e17/artist-albums.json");

        if($jsonStr === FALSE) {
            echo "Could not read the file.".PHP_EOL;
            return;
        }

        $jsonObj = json_decode($jsonStr, true);
        foreach ($jsonObj as $artist){
            $artistObj = new Artist();
            $hasName = ($artist['name'])? $artistObj->setName($artist['name']): '';

            if($artist['albums']){
                foreach($artist['albums'] as $album){
                    $albumObj = new Album();
                    $hasTitle = ($album['title'])? $albumObj->setName($album['title']) : '';
                    $hasDescription = ($album['description'])? $albumObj->setDescription($album['description']) : '';
                    $hasCover = ($album['cover'])? $albumObj->setCover($album['cover']): '';
                    if($album['songs']){
                        foreach($album['songs'] as $song){
                            $songObj = new Song();
                            $hasTitle = ($song['title'])? $songObj->setTitle($song['title']) : '';
                            $hasLength = ($song['length'])? $songObj->setLength($song['length']) : '';
                            $manager->persist($songObj);
                            $albumObj->addSong($songObj);
                        }
                    }
                    $manager->persist($albumObj);
                    $artistObj->addAlbum($albumObj);
                }
            }
            $manager->persist($artistObj);
        }
        $manager->flush();
    }
}
