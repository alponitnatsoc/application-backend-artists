<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Teapot\StatusCode;

class ArtistController extends AbstractController
{
    /**
     * @Route("/artists", methods={"GET"})
     */
    public function showArtists(){
        $response = new Response();
        $em = $this->getDoctrine()->getManager();
        $artistsRepo = $em->getRepository("App:Artist");
        $artists = $artistsRepo->findAll();
        $data = [];
        $data['Artists'] = [];
        foreach ($artists as $key => $artist){
            $albumArr = [];
            foreach ($artist->getAlbums() as $akey => $album){
                $albumArr[$akey] = ['title' => $album->getName(), 'token' => $album->getToken(), 'cover' => $album->getCover(), 'description' => $album->getDescription()];
            }
            $data['Artists'][$key] = ['name' => $artist->getName(), 'token' => $artist->getToken(), 'albums' => $albumArr];
        }
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type','application/json');
        $response->setStatusCode(StatusCode::OK);
        return $response;
    }

    /**
     * @Route("/artists/{token}", methods={"GET"})
     */
    public function showArtist($token){
        $response = new Response();
        $em = $this->getDoctrine()->getManager();
        $artistsRepo = $em->getRepository("App:Artist");
        $artist = $artistsRepo->find($token);
        if(empty($artist)){
            $response->setContent(json_encode(['error' => 'There\'s not an artist with token'.$token]));
            $response->headers->set('Content-Type','application/json');
            $response->setStatusCode(StatusCode::NOT_FOUND);
            return $response;
        }
        $albumArr = [];
        foreach ($artist->getAlbums() as $akey => $album){
            $albumArr[$akey] = ['title' => $album->getName(), 'token' => $album->getToken(), 'cover' => $album->getCover(), 'description' => $album->getDescription()];
        }
        $data = ['name' => $artist->getName(), 'token' => $artist->getToken(), 'albums' => $albumArr];
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type','application/json');
        $response->setStatusCode(StatusCode::OK);
        return $response;
    }
}