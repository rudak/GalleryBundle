<?php

namespace Rudak\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RenderController extends Controller
{
    public function randImageAction()
    {
        $picture = $this->getDoctrine()->getManager()
            ->getRepository('RudakGalleryBundle:Picture')->getRandImage();

        $content = $this->renderView('RudakGalleryBundle:Render:randImage.html.twig', array(
            'picture' => $picture
        ));

        return new Response($content);
    }

    public function lastImageAction()
    {
        $picture = $this->getDoctrine()->getManager()
            ->getRepository('RudakGalleryBundle:Picture')->getLastImage();

        return $this->render('RudakGalleryBundle:Render:lastImage.html.twig', array(
            'picture' => $picture
        ));
    }

    public function carouselAction()
    {
        return $this->render('RudakGalleryBundle:Render:carousel.html.twig', array(// ...
        ));
    }

}
