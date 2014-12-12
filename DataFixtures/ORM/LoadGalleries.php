<?php
namespace Rudak\GalleryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Rudak\UtilsBundle\FakeContentGenerator;
use Rudak\UtilsBundle\Syllabeur;
use Rudak\GalleryBundle\Entity\Gallery;

class LoadGalleries extends AbstractFixture implements OrderedFixtureInterface
{

    const NOMBRE_GALERIES = 12;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $galleries = array();
        $fcg       = new FakeContentGenerator();
        for ($i = 0; $i < self::NOMBRE_GALERIES; $i++) {
            $galleries[$i] = New Gallery();
            $galleries[$i]->setName($fcg->getRandSentence(false, rand(1, 3)));
            $galleries[$i]->setDescription($fcg->getRandSentence(false, rand(15, 35)));
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