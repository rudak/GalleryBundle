<?php
namespace Rudak\PartnerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rudak\GalleryBundle\Entity\Picture;
use Rudak\PictureGrabber\Model\PictureGrabber;

class LoadGalleryPictures extends AbstractFixture implements OrderedFixtureInterface
{

    const NOMBRE_IMAGES = 465;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $entities = array();
        $url      = "http://lorempixel.com/%s/%s/";

        echo "Image de la galerie  :\n";
        for ($i = 0; $i < self::NOMBRE_IMAGES; $i++) {

            $url          = sprintf($url, rand(700, 840), rand(500, 610));
            $entities[$i] = New Picture();

            $pc    = new PictureGrabber($url, $entities[$i]->getDir(), 'rg_', 6);
            $image = $pc->getImage() ? $pc->getFileName() : $entities[$i]->getDefaultImagePath();

            $entities[$i]->setPath($image);

            $entities[$i]->setGallery($this->getReference('gallery_' . rand(0, 8)));
            $manager->persist($entities[$i]);

            echo 'Image [' . $i . '/' . self::NOMBRE_IMAGES . ']: ' . $image
                . ' - code http : ' . $pc->getHttp()
                . ' - Poids : ' . $pc->getContentLength()
                . "\n";
        }
        echo "\n";
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 382;
    }
}