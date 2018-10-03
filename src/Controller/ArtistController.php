<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtistController extends AbstractController
{
    /**
     * @Route("/artists", methods={"GET"})
     */
    public function showArtists(){
        $response = new Response();
        $response->setContent(json_encode());
        $response->headers->set('Content-Type','application/json');
        $response->setStatusCode(StatusCode::OK);
        return $response;
    }

    /**
     * @Route("/artists/{token}", methods={"GET"})
     */
    public function showArtist($token){
        $response = new Response();

        $response->setContent(json_encode());
        $response->headers->set('Content-Type','application/json');
        $response->setStatusCode(StatusCode::OK);
        return $response;
    }
}