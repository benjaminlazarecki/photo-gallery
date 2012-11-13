<?php

namespace Album\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager;

use Album\Entity\Album;

/**
 * Load some album.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class LoadAlbum extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $album1 = new Album();
        $album1->artist = "album1";
        $album1->title = "title1";

        $album2 = new Album();
        $album2->artist = "album2";
        $album2->title = "title2";

        $manager->persist($album1);
        $manager->persist($album2);

        $manager->flush();
    }
}
