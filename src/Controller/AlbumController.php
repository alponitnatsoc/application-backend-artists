<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Teapot\StatusCode;

class AlbumController extends AbstractController
{
    /**
     * @Route("/albums/{token}", methods={"GET"})
     */
    public function showAlbum($token) {
        $response = new Response();
        $em = $this->getDoctrine()->getManager();
        $albumsRepo = $em->getRepository("App:Album");
        $album = $albumsRepo->find($token);
        $artistArr =[];
        $songArr = [];
        foreach ($album->getArtists() as $akey => $artist){
            $artistArr[$akey] = ['name' => $artist->getName(), 'token' => $artist->getToken()];
        }
        foreach ($album->getSongs() as $skey => $song){
            $songArr[$skey] = ['title' => $song->getTitle(), 'length' => $song->getLengthinSeconds()];
        }
        $data['album'] = ['title' => $album->getName(), 'token' => $album->getToken(),'cover' => $album->getCover(), 'description' => $album->getDescription(), 'artists' => $artistArr, 'songs' => $songArr];
        $response->setContent(json_encode($data));
        $response->setContent(json_encode());
        $response->headers->set('Content-Type','application/json');
        $response->setStatusCode(StatusCode::OK);
        return $response;
    }
}
