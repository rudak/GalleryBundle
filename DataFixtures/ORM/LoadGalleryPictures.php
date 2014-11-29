<?php
namespace Rudak\PartnerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rudak\GalleryBundle\Entity\Picture;

class LoadGalleryPictures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $entities = array();
        for ($i = 0; $i < 850; $i++) {
            $entities[$i] = New Picture();
            $entities[$i]->setPath('no-image.jpg');
            $entities[$i]->setGallery($this->getReference('gallery_' . rand(0, 48)));
            $manager->persist($entities[$i]);
            echo '.';
        }
        echo "\n";
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 155;
    }
}