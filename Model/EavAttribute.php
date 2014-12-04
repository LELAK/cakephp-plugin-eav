<?php

App::uses('EavAppModel', 'Eav.Model');
/**
 * Eav Data Type Model
 *
 * This file is contains the Attribute Model class
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
 * Attribute Model
 *
 * Validations, Associations, and Methods for Attributes. Attributes are the dynamc fields added to a model.
 *
 * @package       plugins.Eav.Model
 *
 */
class EavAttribute extends EavAppModel {

    public $useTable = 'eav_attributes';
    public $name = 'EavAttribute';
    protected $allowedConditions = ['EavAttribute.public', 'title', 'slug', 'id', 'description', 'input_type', 'multiple', 'optional'];

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';
    //public $actsAs = array('Containable');
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'ID incorreto',
                'allowEmpty' => false,
            ),
        ),
        'title' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'O título do atributo não pode ser nulo',
                'allowEmpty' => false,
            ),
        ),
        'slug' => array(
            'notempty' => array(
                'rule' => array('isUnique'),
                'message' => 'Atalho deve ser único',
                'allowEmpty' => false,
            ),
        ),
        'entity_type_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Tipo de entidade incorreto',
                'allowEmpty' => false,
            ),
        ),
        'data_type_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Tipo de dado incorreto',
                'allowEmpty' => false,
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'EavEntityType' => array(
            'className' => 'Eav.EavEntityType',
            'foreignKey' => 'entity_type_id'
        ),
        'EavDataType' => array(
            'className' => 'Eav.EavDataType',
            'foreignKey' => 'data_type_id'
        )
    );
    public $hasMany = array(
        'EavCategories' => array(
            'className' => 'Eav.EavCategoryAttribute',
            'foreignKey' => 'attribute_id',
            'dependent' => true
        )
    );

    /**
     * Get list of attributes by array of conditions
     * 
     * Eg.:
     * 
     * For category with slug starting with 'curs':
     * array('IN' => array('EavCategory.title' => array('curs')))
     * 
     * For categories with id 1, 6 and 9:
     * array('EavCategory.id' => array(1,6,9))
     * 
     * 
     * @param array $conditions
     * @return array Match categories
     */
    public function getAttributesByConditions($conditions) {

        // Prevent users to search for attributes that are not public if is not
        // in admin prefix routing
        $securedConditions = array(
            "EavAttribute.public" => 1
        );

        $conditions = !(bool) Configure::read("Routing.admin") ? array_merge($conditions, $securedConditions) : $conditions;

        if ((bool) Configure::read("Routing.admin") || $this->_is_conditions_allowed($this->allowedConditions, $conditions)):

            $attributes = $this->find('all', array('conditions' => $conditions));
            return $attributes ? $attributes : array();

        endif;

        return array();
    }

}
