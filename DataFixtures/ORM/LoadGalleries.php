<?php
namespace Rudak\GalleryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Rudak\BlogBundle\Utils\Syllabeur;
use Rudak\GalleryBundle\Entity\Gallery;

class LoadGalleries extends AbstractFixture implements OrderedFixtureInterface
{

    const NOMBRE_GALERIES = 27;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $galleries = array();
        for ($i = 0; $i < self::NOMBRE_GALERIES; $i++) {
            $galleries[$i] = New Gallery();
            $galleries[$i]->setName(Syllabeur::getMots(rand(1, 2)));
            $galleries[$i]->setDescription(Syllabeur::getMots(rand(5, 60)));
            $galleries[$i]->setDate(new \DateTime('-' . rand(150, 900) . 'hour'));
            $galleries[$i]->setPublic(rand(0, 1));
            $manager->persist($galleries[$i]);
            $this->addReference('gallery_' . $i, $galleries[$i]);
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
        return 381;
    }
}