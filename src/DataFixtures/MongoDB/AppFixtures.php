<?php
declare(strict_types=1);
/**
 * This file is part of the kairos project.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.2
 *
 * @category Kairos_Api_Fixtures
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace App\DataFixtures\MongoDB;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Document\Library;

/**
 * AppFixtures
 *
 * This class is used to load the default application fixtures
 *
 * @category Kairos_Api_Fixtures
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class AppFixtures extends Fixture
{

    /**
     * Load
     *
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager The application manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $map = [
            'kairos-project/api-controller' => '1.0.x-dev',
            'kairos-project/api-doctrine-mongodb-odm-loader' => '1.0.x-dev',
            'kairos-project/api-formatter' => '1.0.x-dev',
            'kairos-project/api-loader' => '1.0.x-dev',
            'kairos-project/api-normalizer' => '1.0.x-dev',
            'kairos-project/api-pack' => '1.0.x-dev'
        ];

        foreach ($map as $name => $version) {
            $library = new Library();
            $library->setName($name)
                ->setLatestVersion($version);

            $manager->persist($library);
        }

        $manager->flush();
    }
}

