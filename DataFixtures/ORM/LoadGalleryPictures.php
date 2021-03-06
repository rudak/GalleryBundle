<?php
namespace Rudak\PartnerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rudak\GalleryBundle\DataFixtures\ORM\LoadGalleries;
use Rudak\GalleryBundle\Entity\Picture;
use Rudak\PictureGrabber\Model\PictureGrabber;

class LoadGalleryPictures extends AbstractFixture implements OrderedFixtureInterface
{

    const NOMBRE_IMAGES = 150;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $entities = array();
        $url      = "http://lorempixel.com/%s/%s/";

        echo "Images de la galerie  :\n";
        for ($i = 0; $i < self::NOMBRE_IMAGES; $i++) {

            $url          = sprintf($url, rand(700, 840), rand(500, 610));
            $entities[$i] = New Picture();

            $pc    = new PictureGrabber($url, $entities[$i]->getDir(), 'rg_', 6);
            $image = $pc->getImage() ? $pc->getFileName() : $entities[$i]->getDefaultImagePath();

            $entities[$i]->setPath($image);

            $entities[$i]->setGallery($this->getReference('gallery_' . rand(1, LoadGalleries::getGalleriesNumber())));
            $manager->persist($entities[$i]);

            echo 'Image [' . ($i + 1) . '/' . self::NOMBRE_IMAGES . ']: ' . $image . "\n";
        }
        echo "\n";
        $manager->flush();
        echo "TERMINE\n -------------------- \n";
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1382;
    }
}