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
 * @category Kairos_Api_Document
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Library
 *
 * This class is used to represent a mongodb library document
 *
 * @category Kairos_Api_Document
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 * @MongoDB\Document
 */
class Library
{
    /**
     * Id
     *
     * The document id
     *
     * @var string
     * @MongoDB\Id
     */
    private $id;

    /**
     * Name
     *
     * The library name
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * Latest version
     *
     * The library latest version
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $latestVersion;

    /**
     * Get Id
     *
     * Return the document id
     *
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * Return the library name
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get latest version
     *
     * Return the latest library version
     *
     * @return string
     */
    public function getLatestVersion() : string
    {
        return $this->latestVersion;
    }

    /**
     * Set name
     *
     * Set the library name
     *
     * @param string $name The library name
     *
     * @return $this
     */
    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set latest version
     *
     * Set the library latest version
     *
     * @param string $latestVersion The library latest Version
     *
     * @return $this
     */
    public function setLatestVersion(string $latestVersion) : self
    {
        $this->latestVersion = $latestVersion;

        return $this;
    }

}

