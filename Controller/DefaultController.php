<?php

namespace Rudak\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function IndexAction()
    {
        return $this->render('RudakGalleryBundle:Default:Index.html.twig', array(
                // ...
            ));    }

}
