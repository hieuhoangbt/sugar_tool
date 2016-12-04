<?php

/**
 * Entity Competition
 */
class Competition {

    /**
     * ID number
     * @var string
     */
    public $ID;

    /**
     * Construct
     * @param type $responseXml
     */
    public function __construct($responseXml)
    {
        $this->ID = $responseXml->ID;
    }

    /**
     * Get Competition Id
     *
     * @return int
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * Set Competition Id
     *
     * @param int $ID
     * @return \Competition
     */
    public function setID($ID)
    {
        $this->ID = $ID;
        return $this;
    }

}
