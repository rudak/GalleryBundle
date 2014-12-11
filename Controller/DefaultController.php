<?php

namespace Rudak\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    const ACTIVE_ITEM = 'photos';

    public function IndexAction()
    {
        $galleries = $this->getDoctrine()
            ->getManager()
            ->getRepository('RudakGalleryBundle:Gallery')
            ->listOfGalleries();

        $this->get('MenuBundle.Handler')->setActiveItem(self::ACTIVE_ITEM);

        return $this->render('RudakGalleryBundle:Default:Index.html.twig', array(
            'galleries' => $galleries
        ));
    }

    public function galleryByIdAction($id)
    {
        $gallery = $this->getDoctrine()
            ->getManager()
            ->getRepository('RudakGalleryBundle:Gallery')
            ->getGalleryById($id);

        $this->get('MenuBundle.Handler')->setActiveItem(self::ACTIVE_ITEM);

        return $this->render('RudakGalleryBundle:Default:gallery.html.twig', array(
            'gallery' => $gallery
        ));
    }

}
