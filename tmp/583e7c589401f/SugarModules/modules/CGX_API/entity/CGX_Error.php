<?php

class CGX_Error {

    /**
     * CODE number
     * @var string
     */
    public $CODE;

    /**
     * MSG error message
     * @var string
     */
    public $MSG;

    public function __construct($code, $msg)
    {
        $this->CODE = $code;
        $this->MSG = $msg;
    }

    /**
     * Get Code
     * @return String
     */
    public function getCode()
    {
        return $this->CODE;
    }

    /**
     * Get MSG
     * @return String
     */
    public function getMsg()
    {
        return $this->MSG;
    }

    /**
     * Set Code
     * @param String $CODE
     * @return Entity\CGX_Error
     */
    public function setCode($CODE)
    {
        $this->CODE = $CODE;
        return $this;
    }

    /**
     * Set MSG
     * @param String $MSG
     * @return Entity\CGX_Error
     */
    public function setMsg($MSG)
    {
        $this->MSG = $MSG;
        return $this;
    }

}
