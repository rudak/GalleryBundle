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

    const NOMBRE_GALERIES = 6;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        echo "CREATION GALERIES : \n";
        $galleries = array();
        $fcg       = new FakeContentGenerator();
        for ($i = 1; $i <= self::NOMBRE_GALERIES; $i++) {
            $galleries[$i] = New Gallery();
            $galleries[$i]->setName($fcg
                ->setTags(false)
                ->setSentenceLength(rand(2, 3))
                ->setSentenceNumber(1)
                ->getRandSentence());
            $galleries[$i]->setDescription($fcg
                ->setTags(false)
                ->setSentenceLength(rand(15, 35))
                ->setSentenceNumber(1)
                ->getRandSentence());
            $galleries[$i]->setDate(new \DateTime('-' . rand(150, 900) . 'hour'));
            $galleries[$i]->setPublic(rand(0, 1));
            $manager->persist($galleries[$i]);
            $this->addReference('gallery_' . $i, $galleries[$i]);
            echo '[' . $i . '/' . self::NOMBRE_GALERIES . '] ' . $galleries[$i]->getName() . "\n";
        }
        echo "\n";
        $manager->flush();

    }

    public static function getGalleriesNumber()
    {
        return self::NOMBRE_GALERIES;
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 381;
    }
}