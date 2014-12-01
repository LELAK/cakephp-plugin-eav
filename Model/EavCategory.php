<?php

App::uses('EavAppModel', 'Eav.Model');
/**
 * Eav Category Model
 *
 * This file is contains the Category Model class
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
 * Category Model
 *
 *
 * @package       plugins.Eav.Model
 *
 */
class EavCategory extends EavAppModel {

    public $useTable = 'eav_categories';
    public $name = 'EavCategory';
    public $actAs = array('Tree');
    protected $allowedConditions = ['EavCategory.public', 'slug', 'title', 'id'];

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
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'EavAttributes' => array(
            'className' => 'Eav.EavCategoryAttributes',
            'foreignKey' => 'category_id',
            'dependent' => true
        )
    );

    public function beforeSave($options = array()) {
        // If there is an ID on the request, is an edit request, so we
        // should clear the category attributes table to populate it again.
        if ($this->id && !empty($this->data[$this->alias][$this->primaryKey])) {
            if (!$this->clear_category_attributes_by_id($this->id)) {
                return false;
            }
        }

        return parent::beforeSave();
    }

    /**
     * Clear the category attribute relations by category id
     * 
     * @param integer $id
     */
    public function clear_category_attributes_by_id($id) {
        return $this->EavAttributes->deleteAll(array('category_id' => $id), false);
    }

    /**
     * Get list of categories by array of conditions
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
    public function getCategoriesByConditions($conditions) {

        // Prevent users to search for attributes that are not public if is not
        // in admin prefix routing
        $securedConditions = array(
            "EavCategory.public" => 1
        );

        // If user is not admin, should not retrieve all fields from database
        $fields = !(bool) Configure::read("Routing.admin") ? array(
            'id',
            'parent_id',
            'title',
            'slug'
                ) : '';

        $conditions = !(bool) Configure::read("Routing.admin") ? array_merge($conditions, $securedConditions) : $conditions;

        if ((bool) Configure::read("Routing.admin") || $this->_is_conditions_allowed($this->allowedConditions, $conditions)):

            $categories = $this->find('all', array('fields' => $fields, 'conditions' => $conditions));
            return $categories ? $categories : array();

        endif;

        return array();
    }

    /**
     * Get a category with respective attributes by category id
     * 
     * @param integer id
     * @return array The category returned
     */
    public function getCategoryAndAttributesById($id) {
        $output = $this->find('first', array('conditions' => array('id' => $id), 'contain' => array('EavAttributes' => array('EavAttribute'))));
        return $output ? $output : array();
    }

    /**
     * Get a category with respective attributes by category slug
     * 
     * @param string $slug
     * @return array The category returned
     */
    public function getCategoryAndAttributesBySlug($slug) {
        $output = $this->find('first', array('conditions' => array('slug' => $slug), 'contain' => array('EavAttributes' => array('EavAttribute'))));
        return $output ? $output : array();
    }

}
