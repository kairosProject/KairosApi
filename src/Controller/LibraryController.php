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
 * @category Kairos_Api_Controller
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use KairosProject\ApiController\Controller\ApiController;
use KairosProject\ApiDoctrineMongoDBODMLoader\Loader\Loader;
use App\Document\Library;
use KairosProject\ApiNormalizer\Normalizer\Normalizer;
use KairosProject\ApiFormatter\ApiFormatter;
use KairosProject\ApiFormatter\PSR7\Response\FormatterResponseFactory;
use KairosProject\ApiFormatter\PSR7\Header\JsonHeaderFormatter;
use KairosProject\ApiFormatter\PSR7\Body\JsonBodyFormatter;
use Symfony\Component\EventDispatcher\EventDispatcher;
use KairosProject\ApiController\Listener\ResponseHydratorListener;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Psr\Log\LoggerInterface;

/**
 * Library controller
 *
 * This class is used to answer the libraries request
 *
 * @category Kairos_Api_Controller
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class LibraryController extends Controller
{
    /**
     * Get collection
     *
     * Return a collection of library
     *
     * @param Request $request The application request
     * @param LoggerInterface $logger The application logger
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCollection(Request $request, LoggerInterface $logger)
    {
        $processEventName = 'process_gets';
        $responseEventName = 'response_gets';

        $eventDispatcher = new EventDispatcher();

        $loader = new Loader(
            $this->get('doctrine_mongodb.odm.document_manager'),
            Library::class,
            'id',
            Loader::REQUEST_QUERY,
            'id',
            $logger
        );
        $eventDispatcher->addListener($processEventName, [$loader, 'loadCollection'], 8);

        $normalizer = new Normalizer(
            $logger,
            $this->get('serializer')
        );
        $eventDispatcher->addListener($processEventName, [$normalizer, 'normalize'], 4);
        $eventDispatcher->addListener($processEventName, [new ResponseHydratorListener(), 'hydrateResponse'], 0);

        $bodyFormatter = new JsonBodyFormatter();
        $headerFormatter = new JsonHeaderFormatter();
        $responseFactory = new FormatterResponseFactory();
        $formatter = new ApiFormatter();
        $eventDispatcher->addListener($responseEventName, [$formatter, 'format'], 0);
        $eventDispatcher->addListener(ApiFormatter::EVENT_RESPONSE_CREATION, [$responseFactory, 'createResponse'], 0);
        $eventDispatcher->addListener(ApiFormatter::EVENT_PROCESS_HEADER, [$headerFormatter, 'createResponse'], 0);
        $eventDispatcher->addListener(ApiFormatter::EVENT_FORMAT_BODY, [$bodyFormatter, 'createResponse'], 0);

        $controller = new ApiController($logger, $eventDispatcher);

        $psr7Factory = new DiactorosFactory();
        $psrRequest = $psr7Factory->createRequest($request);

        $psrResponse = $controller->execute($psrRequest, 'gets');

        $httpFoundationFactory = new HttpFoundationFactory();
        $response = $httpFoundationFactory->createResponse($psrResponse);
        return $response;
    }

    /**
     * Get item
     *
     * Return a specific item
     *
     * @param Request $request The application request
     * @param LoggerInterface $logger The application logger
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getItem(Request $request, LoggerInterface $logger)
    {
        $processEventName = 'process_get';
        $responseEventName = 'response_get';

        $eventDispatcher = new EventDispatcher();

        $loader = new Loader(
            $this->get('doctrine_mongodb.odm.document_manager'),
            Library::class,
            'id',
            Loader::REQUEST_ATTRIBUTE,
            'id',
            $logger
        );
        $eventDispatcher->addListener($processEventName, [$loader, 'loadItem'], 8);

        $normalizer = new Normalizer(
            $logger,
            $this->get('serializer')
        );
        $eventDispatcher->addListener($processEventName, [$normalizer, 'normalize'], 4);
        $eventDispatcher->addListener($processEventName, [new ResponseHydratorListener(), 'hydrateResponse'], 0);

        $bodyFormatter = new JsonBodyFormatter();
        $headerFormatter = new JsonHeaderFormatter();
        $responseFactory = new FormatterResponseFactory();
        $formatter = new ApiFormatter();
        $eventDispatcher->addListener($responseEventName, [$formatter, 'format'], 0);
        $eventDispatcher->addListener(ApiFormatter::EVENT_RESPONSE_CREATION, [$responseFactory, 'createResponse'], 0);
        $eventDispatcher->addListener(ApiFormatter::EVENT_PROCESS_HEADER, [$headerFormatter, 'createResponse'], 0);
        $eventDispatcher->addListener(ApiFormatter::EVENT_FORMAT_BODY, [$bodyFormatter, 'createResponse'], 0);

        $controller = new ApiController($logger, $eventDispatcher);

        $psr7Factory = new DiactorosFactory();
        $psrRequest = $psr7Factory->createRequest($request);

        $psrResponse = $controller->execute($psrRequest, 'get');

        $httpFoundationFactory = new HttpFoundationFactory();
        $response = $httpFoundationFactory->createResponse($psrResponse);
        return $response;
    }
}
