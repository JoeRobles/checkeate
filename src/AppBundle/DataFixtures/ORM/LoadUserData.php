<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\DataFixtures\ORM\LoadAppData;
use AppBundle\Entity\User as User;

class LoadUserData extends LoadAppData implements OrderedFixtureInterface
{
    /**
     * Main load function.
     *
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $users = $this->getModelFixtures();

        // Now iterate thought all fixtures
        foreach ($users['User'] as $reference => $columns) {
            $user = new User();
            $user->setFirstname($columns['firstname']);
            $user->setLastname($columns['lastname']);
            $user->setPath($columns['path']);
            $user->setOriginal($columns['original']);
            $user->setUsername($columns['username']);
            $user->setUsernameCanonical($columns['username_canonical']);
            $user->setEmail($columns['email']);
            $user->setEmailCanonical($columns['email_canonical']);
            $user->setEnabled($columns['enabled']);
            $user->setPlainPassword($columns['plain_password']);
            $user->addRole($columns['role']);

            $manager->persist($user);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('User_'. $reference, $user);
        }
        $manager->flush();
    }

    /**
     * The main fixtures file for this loader.
     */
    public function getModelFile()
    {
        return 'users';
    }

    /**
     * The order in which these fixtures will be loaded.
     */
    public function getOrder()
    {
        return 1;
    }
}
