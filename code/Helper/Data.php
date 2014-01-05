<?php

class Rubic_HiphopIndexer_Helper_Data
    extends Mage_Core_Helper_Data 
{
    
    /**
     * Determines if current request is coming from hiphop.
     * 
     * @return bool
     */
    public function isRunningHiphop()
    {
        return isset($_SERVER['SERVER_SOFTWARE']) && $_SERVER['SERVER_SOFTWARE'] == 'HPHP';
    }
    
}