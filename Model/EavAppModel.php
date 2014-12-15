<?php

App::uses('MilkartAppModel', 'Milkart.Model');
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
class EavAppModel extends MilkartAppModel {

    protected $assocPublicConf = array(
        'EavAttributes' => array(
            "fields" => array('EavAttributes.title', 'EavAttributes.slug', 'EavAttributes.description', 'EavAttributes.input_type', 'EavAttributes.multiple', 'EavAttributes.optional'),
            "conditions" => array('EavAttributes.public' => 1)
        ),
        'EavAttribute' => array(
            "fields" => array('EavAttribute.title', 'EavAttribute.slug', 'EavAttribute.description', 'EavAttribute.input_type', 'EavAttribute.multiple', 'EavAttribute.optional'),
            "conditions" => array('EavAttribute.public' => 1)
        )
    );

    /**
     * To prevent public users to view private information using the RESTful
     * resources of EAV, this method creates conditions and specify fields
     * if the requests are not in the /admin/ prefix.
     */
    public function beforeFind($query = array()) {

        // If the request is not in admin prefix. Load only public fields.
        if (!(bool) CakeSession::read("Routing.admin")):
            if (isset($this->assocPublicConf[$this->alias])):
                // Prepare public conditions
                $query['conditions'] = isset($query['conditions']) && is_array($query['conditions']) ? array_unique(array_merge($query['conditions'], $this->assocPublicConf[$this->alias]["conditions"]), SORT_REGULAR) : $this->assocPublicConf[$this->alias]["conditions"];
                // Prepare public fields
                $query['fields'] = isset($query['fields']) && is_array($query['fields']) ? array_unique(array_merge($query['fields'], $this->assocPublicConf[$this->alias]["fields"]), SORT_REGULAR) : $this->assocPublicConf[$this->alias]["fields"];
            endif;
            // Prepare public associations
            $assocPossibilities = ['belongsTo', 'hasMany', 'hasOne', 'hasAndBelongsToMany'];
            foreach ($assocPossibilities as $assoc):
                foreach ($this->assocPublicConf as $assocKey => $assocConf):
                    if (isset($this->{$assoc}[$assocKey])):
                        $this->{$assoc}[$assocKey] = array_merge($this->{$assoc}[$assocKey], $assocConf);
                    endif;
                endforeach;
            endforeach;

        endif;

        return $query;
    }

}
