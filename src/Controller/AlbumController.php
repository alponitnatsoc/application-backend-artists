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
        $response->setContent(json_encode());
        $response->headers->set('Content-Type','application/json');
        $response->setStatusCode(StatusCode::OK);
        return $response;
    }
}
