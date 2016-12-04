<?php

require_once(__DIR__ . '/../CGX_IO.php');

/**
 * CGX Kit
 */
class CGX_Kit_Base
{

    protected static $inOut;

    /**
     * Construct
     *
     * @return api/CGX_Kit
     */
    public function __construct()
    {
        if (empty(self::$inOut)) {
            $inOut = new CGX_IO();
            $this->setInOut($inOut);
        }

        return $this;
    }

    /**
     * get IO
     *
     * @return type
     */
    public static function getInOut()
    {
        return self::$inOut;
    }

    /**
     * set IO
     *
     * @param mix $inOut
     *
     * @return mix
     */
    public static function setInOut($inOut)
    {
        self::$inOut = $inOut;
    }
}
