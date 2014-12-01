<?php

App::uses('AppModel', 'Model');
/**
 * Eav App Model
 *
 * This file contains the EavAppModel class
 *
 * PHP 5
 *
 * Protelligence (http://cakephp.org)
 * Copyright 2009-2013, Protelligence (http://www.protelligence.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2013, Protelligence (http://www.protelligence.com)
 * @link          http://www.protelligence.com Protelligence
 * @package       plugins.Eav.Model
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Eav App Model
 *
 * Methods and properties to be used throughout the plugin. Eav Plugin models extend this model.
 *
 * @package       plugins.Eav.Model
 *
 */
class EavAppModel extends AppModel {

    /**
     * Grants security checking if condition sent by request is allowed
     * 
     * @param array $conditions
     * @return boolean If the request should be allowed
     */
    protected function _is_conditions_allowed($allowedConditions, $conditions) {

        foreach ($conditions as $key => $condition):
            if (!in_array($key, $allowedConditions)):
                return false;
            endif;
        endforeach;

        return true;
    }

}
