<?php

namespace WPFP\Boot\System;

class Core
{
    protected $config;

    /**
     * Set Config Data
     *
     * @param	array  $configData
     * @return	void
     */
    public function __construct($configData = null)
    {
        $this->config = $configData;
    }

    /**
     * Convert Array to Object
     *
     * @param	array   $arr
     * @return	object
     */
    protected function __toObject(array $arr)
    {
        $obj = new \stdClass();
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $val = $this->__toObject($val);
            }
            $obj->$key = $val;
        }
        return $obj;
    }

    /**
     * Get Config Item
     *
     * @param	string  $configItemSelector
     * @return	string	Return String
     * @return  array   Return Array
     */
    public function configItem($configItemSelector = null)
    {
        if ($configItemSelector !== null) {

            $getResults = $this->config[$configItemSelector];
            return $getResults;
        } else {
            return false;
        }
    }
}
