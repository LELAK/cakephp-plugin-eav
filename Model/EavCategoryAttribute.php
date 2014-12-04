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
class EavCategoryAttribute extends EavAppModel {

    public $useTable = 'eav_category_attributes';
    public $name = 'EavCategoryAttribute';
    protected $allowedConditions = ['attribute_id', 'category_id'];

    /**
     * hasMany associations
     *
     * @var array
     */
    public $belongsTo = array(
        'EavAttribute' => array(
            'className' => 'Eav.EavAttribute',
            'foreignKey' => 'attribute_id',
            'order' => 'EavAttribute.title'
        ),
        'EavCategory' => array(
            'className' => 'Eav.EavCategory',
            'foreignKey' => 'category_id'
        )
    );

    /**
     * Get all childrens of specified category and remove (if exists) the relation
     * with specified attribute_id
     * 
     * @param type $category_id
     * @param type $attribute_id
     */
    public function clearChildDuplicateAttributes($category_id = null, $attribute_id = null) {
        if ($category_id && $attribute_id):
            $childs = $this->EavCategory->children($category_id);
            if ($childs):
                foreach ($childs as $key => $value):
                    $this->deleteAll(array("category_id" => $value["EavCategory"]["id"], "attribute_id" => $attribute_id));
                endforeach;
            endif;
        endif;
    }

    public function beforeSave($options = array()) {
        // Prevent the childrens of current category don't keep
        // any attributes existing in his parent
        $this->clearChildDuplicateAttributes($this->data['EavAttributes']['category_id'], $this->data['EavAttributes']['attribute_id']);

        return true;
    }

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

        foreach ($this->find('all', array('group' => 'attribute_id', 'conditions' => $conditions)) as $attributeData):
            $output[] = array("EavAttribute" => array_merge($attributeData["EavAttribute"], array('filtered' => $attributeData["EavCategoryAttribute"]["filtered"])));
        endforeach;

        return $output;
    }

    /**
     * Get attributes by a given category id
     * 
     * @param integer $categoryId
     * @param array $options Array of params to configure the request
     * 
     * Options
     * inheritance - If should retrieve the chain of attributes inherited from the category tree (Default: true)
     * inheritedOnly - If should retrieve ONLY the chain of attributes from parents categories and not itself (Default: false)
     * inverted - If should retrieve the attributes that this category chain doesn't have yet (Default: false)
     *
     * @return array The array of attributes available for the category tree.
     */
    public function getAttributesByCategoryId($categoryId, $options = array()) {

        $defaultOptions = array(
            'inheritance' => true,
            'inheritedOnly' => false,
            'inverted' => false
        );

        $options = array_merge($defaultOptions, $options);

        $output = array();
        $idPath = array();

        $this->EavCategory->id = $categoryId;
        if ($this->EavCategory->exists()):

            if ($options["inheritance"]):
                foreach ($this->EavCategory->getPath($categoryId, array('id')) as $key => $value):
                    if ($options["inheritedOnly"] && $categoryId == $value["EavCategory"]["id"]):
                        continue;
                    endif;
                    array_push($idPath, $value['EavCategory']['id']);
                endforeach;
            else:
                array_push($idPath, $categoryId);
            endif;

            if ($options["inverted"]):
                $idExceptions = array();
                foreach ($this->getAttributesByCategoryId($categoryId) as $attributeData):
                    array_push($idExceptions, $attributeData["EavAttribute"]["id"]);
                endforeach;

                foreach ($this->EavAttribute->find('all', array('contain' => array('EavCategories'), 'conditions' => array('EavAttribute.id NOT' => $idExceptions))) as $attributeData):
                    $output[] = array('EavAttribute' => $attributeData["EavAttribute"]);
                endforeach;
            else:
                foreach ($this->find('all', array('group' => 'attribute_id', 'contain' => array('EavAttribute'), 'conditions' => array('EavCategoryAttribute.category_id' => $idPath))) as $attributeData):
                    $output[] = array('EavAttribute' => array_merge($attributeData["EavAttribute"], array('filtered' => $attributeData["EavCategoryAttribute"]["filtered"])));
                endforeach;
            endif;

        endif;

        return $output;
    }

}
