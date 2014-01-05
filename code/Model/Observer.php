<?php
/*
 * Copyright 2014 Daniel Sloof
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
*/

class Rubic_HiphopIndexer_Model_Observer
{

    /**
     * XML path to node holding our allowed modules.
     */
    const XML_PATH_ALLOWED_MODULES = 'hiphop_indexer/allowed_modules';
    
    /**
     * XML path to node holding our allowed request paths.
     */
    const XML_PATH_ALLOWED_REQUEST_PATHS = 'hiphop_indexer/allowed_paths';
    
    /**
     * Gets allowed modules from config.
     * 
     * @return array
     */
    protected function _getAllowedModules()
    {
        return array_keys(Mage::getStoreConfig(self::XML_PATH_ALLOWED_MODULES));
    }
    
    /**
     * Gets allowed request paths from config.
     * 
     * @return array
     */
    protected function _getAllowedPaths()
    {
        return Mage::getStoreConfig(self::XML_PATH_ALLOWED_REQUEST_PATHS);
    }
   
    /**
     * Determines if the current path is allowed to update the config.
     * 
     * @param string $requestPath
     * @return bool
     */
    protected function _isPathAllowed($requestPath)
    {
        foreach ($this->_getAllowedPaths() as $allowedPath) {
            if (preg_match($allowedPath, $requestPath)) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Reinitializes the config for certain requests.
     * 
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function reinitializeConfig()
    {
        $app = Mage::app();
        if (Mage::helper('hiphop_indexer')->isRunningHiphop() &&
            $this->_isPathAllowed($app->getRequest()->getRequestString())) {
            // Disallow saving of config cache.
            $app->getCacheInstance()->banUse('config');
            
            // Update the cache.
            $config = $app->getConfig();
            $config->addAllowedModules($this->_getAllowedModules());
            $config->reinit();
        }
    }
    
}