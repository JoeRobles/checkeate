<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\DataFixtures\ORM\LoadAppData;
use AppBundle\Entity\File as File;

class LoadFileData extends LoadAppData implements OrderedFixtureInterface
{
    /**
     * Main load function.
     *
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $files = $this->getModelFixtures();

        // Now iterate thought all fixtures
        foreach ($files['File'] as $reference => $columns) {
            $file = new File();
            $file->setName($columns['name']);
            $file->setType($columns['type']);
            $file->setUri($columns['uri']);
            $file->setPath($columns['path']);
            $file->setOriginal($columns['original']);
            $file->setCreatedBy($manager->merge($this->getReference('User_' . $columns['created_by'])));

            $manager->persist($file);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('File_'. $reference, $file);
        }
        $manager->flush();
    }

    /**
     * The main fixtures file for this loader.
     */
    public function getModelFile()
    {
        return 'files';
    }

    /**
     * The order in which these fixtures will be loaded.
     */
    public function getOrder()
    {
        return 2;
    }
}
