<?php

App::uses('EavAppModel', 'Eav.Model');
/**
 * Eav CategoryAttribute Model
 *
 * This file is contains the Category Attributes Model class
 *
 * PHP 5
 *
 * Protelligence (http://cakephp.org)
 * Copyright 2014, LELAK Hipermídia (http://www.lelak.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2014, LELAK Hipermídia (http://www.lelak.com.br)
 * @link          http://www.lelak.com.br LELAK hipermídia
 * @package       plugins.Eav.Model
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * CategoryAttributes Model
 *
 *
 * @package       plugins.Eav.Model
 *
 */
class EavCategoryAttributes extends EavAppModel {

    public $useTable = 'eav_category_attributes';
    public $name = 'EavCategoryAttributes';
    protected $allowedConditions = ['attribute_id', 'category_id'];

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $belongsTo = array(
        'EavAttribute' => array(
            'className' => 'Eav.EavAttribute',
            'foreignKey' => 'attribute_id',
            'fields' => array('id', 'title', 'slug', 'multiple', 'optional', 'public'),
            'order' => 'EavAttribute.title'
        ),
        'EavCategory' => array(
            'className' => 'Eav.EavCategory',
            'foreignKey' => 'category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * Get list of attributes from categories by array of conditions
     * 
     * Eg.:
     * 
     * For attributes with slug 'type' and 'variation':
     * array('EavAttribute.slug' => array('type','variation'))
     * 
     * For attributes with id 1, 6 and 9:
     * array('EavAttribute.id' => array(1,6,9))
     * 
     * For attributes from category with id 13
     * array('EavAttribute.category_id' => 13)
     * 
     * @param array $conditions
     * @return array Match attributes
     */
    public function getAttributesByConditions($conditions) {

        $output = array();

        if (empty($conditions))
            return array();

        // Prevent users to search for attributes that are not public if is not
        // in admin prefix routing
        $securedConditions = array(
            "EavAttribute.public" => 1
        );

        $conditions = !(bool) Configure::read("Routing.admin") ? array_merge($conditions, $securedConditions) : $conditions;

        if ((bool) Configure::read("Routing.admin") || $this->_is_conditions_allowed($this->allowedConditions, $conditions)):

            foreach ($this->find('all', array('group' => 'attribute_id', 'conditions' => $conditions)) as $attributeData):
                $output[] = array_merge($attributeData["EavAttribute"], array('filtered' => $attributeData["EavCategoryAttributes"]["filtered"]));
            endforeach;

        endif;

        return $output;
    }

}
