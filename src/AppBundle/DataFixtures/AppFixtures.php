<?php
// Datafixtures src/AppBundle/DataFixtures/AppFixtures.php !
namespace AppBundle\DataFixtures;

use AppBundle\Entity\Article;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppFixtures extends Fixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEmail('admin@gmail.com');
        $user->setUsername('admin');
        $user->setname('admin');
        $user->setPlainPassword('admin');
        $user->setEnabled(true);
        $user->addRole('ROLE_ADMIN');
        $this->addReference('user-admin', $user);
        $userManager->updateUser($user);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * @var TYPE_NAME $userManager
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $userManager     = $this->container->get('fos_user.user_manager');
    }
}
