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
 * @category Kairos_Api_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Library controller test
 *
 * This class is used to validate the LibraryController instance.
 *
 * @category Kairos_Api_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class LibraryControllerTest extends WebTestCase
{
    /**
     * Test getCollection.
     *
     * This method validate the App\Controller\LibraryController::getCollection method.
     *
     * @return array
     */
    public function testGetCollection()
    {
        $client = static::createClient();

        $client->request('GET', '/library');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $body = $response->getContent();

        $this->assertEquals(strlen($body), $response->headers->get('Content-Length'));
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->headers->get('Date'));

        $element = '"[0-9a-z]+":\{"id":"[0-9a-z]+","name":"[a-z\\\\\\/-]+","latestVersion":"[0-9.a-z-]+"\}';
        $this->assertRegExp(
            '/\{('.$element.',)+('.$element.')\}/',
            $body
        );

        return json_decode($body, true);
    }

    /**
     * Test getItem.
     *
     * This method validate the App\Controller\LibraryController::getItem method.
     *
     * @return void
     * @depends testGetCollection
     */
    public function testGetItem($collection)
    {
        $elements = array_keys($collection);

        foreach ($elements as $element) {
            $client = static::createClient();
            $client->request('GET', '/library/'.$element);

            $response = $client->getResponse();

            $this->assertEquals(200, $response->getStatusCode());

            $body = $response->getContent();

            $this->assertEquals(strlen($body), $response->headers->get('Content-Length'));
            $this->assertEquals('application/json', $response->headers->get('Content-Type'));
            $this->assertNotEmpty($response->headers->get('Date'));

            $this->assertSame($collection[$element], json_decode($body, true));
        }
    }
}

