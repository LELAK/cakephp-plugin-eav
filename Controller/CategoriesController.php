<?php

App::uses('EavAppController', 'Eav.Controller');
/**
 * Eav Category Model
 *
 * This file is contains the CategoriesController class
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
 * @package       plugins.Eav.Controller
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Categories Controller
 *
 * Methods to manage Categories
 *
 * @package       plugins.Eav.Controller
 */
class CategoriesController extends EavAppController {

    public $uses = array('Eav.EavCategory', 'Eav.EavAttribute', 'Eav.EavCategoryAttribute');
    public $components = array('Paginator');
    public $paginate = array(
        'order' => array('EavCategory.lft asc')
    );
    protected $apiVersions = ['1.0'];

    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    /**
     * List the attributes
     *
     * @return void
     */
    public function admin_index() {
        $this->EavCategory->recursive = 0;

        $this->set('categories', $this->paginate());
    }

    /**
     * View an Attribute
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->EavCategory->id = $id;
        if (!$this->EavCategory->exists()) {
            throw new NotFoundException(__d('eav', 'Categoria inválida'));
        }
        $this->set('category', $this->EavCategory->read(null, $id));
    }

    /**
     * Add a new Attribute
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->EavCategory->create();
            if ($this->EavCategory->saveAll($this->request->data, array('deep' => true))) {
                $this->Session->setFlash(__d('eav', 'Categoria salva'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('eav', 'A categoria não pode ser salva, tente novamente'));
            }
        }

        $categories = $this->EavCategory->generateTreeList(null, null, null, '-');

        $this->set(compact('categories'));

        $this->render('admin_form');
    }

    /**
     * Edit an Attribute
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->EavCategory->id = $id;
        if (!$this->EavCategory->exists()) {
            throw new NotFoundException(__d('eav', 'Categoria inválida'));
        }
        if ($this->request->isPost() || $this->request->isPut()) {

            if ($this->EavCategory->saveAll($this->request->data, array('deep' => true))) {
                $this->Session->setFlash(__d('eav', 'A categoria foi salva'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('eav', 'A categoria não pode ser salva, tente novamente'));
            }
        } else {
            $this->request->data = $this->EavCategory->getCategoryAndAttributesById($id);
        }

        $this->render('admin_form');
    }

    /**
     * Delete an attribute
     *
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->EavCategory->id = $id;
        if (!$this->EavCategory->exists()) {
            throw new NotFoundException(__d('eav', 'Categoria inválida'));
        }
        if ($this->EavCategory->delete()) {
            $this->Session->setFlash(__d('eav', 'Categoria excluída'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('eav', 'A categoria não pode ser excluída. Tente novamente'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * Get all categories by GET conditions
     * 
     * @param string $identifier
     */
    public function api_get() {
        $this->EavCategory->recursive = -1;

        $data = $this->EavCategory->getCategoriesByConditions($this->request->query);

        $this->set(array(
            'data' => $data,
            '_serialize' => array('data')
        ));
    }

    /**
     * Get category attributes by category id
     * 
     * @param string $identifier
     */
    public function api_get_attributes($identifier = null) {
        $this->EavCategoryAttribute->recursive = 1;

        $data = $this->EavCategoryAttribute->getAttributesByCategoryId($identifier);

        $this->set(array(
            'data' => $data,
            '_serialize' => array('data')
        ));
    }

    /**
     * Get category attributes inherited by category id
     * 
     * @param string $identifier
     */
    public function api_get_attributes_inherited($identifier = null) {
        $this->EavCategoryAttribute->recursive = 1;

        $data = $this->EavCategoryAttribute->getAttributesByCategoryId($identifier, array(
            'inheritedOnly' => true
        ));

        $this->set(array(
            'data' => $data,
            '_serialize' => array('data')
        ));
    }

    /**
     * Get category own attributes by category id
     * 
     * @param string $identifier
     */
    public function api_get_attributes_own($identifier = null) {
        $this->EavCategoryAttribute->recursive = 1;

        $data = $this->EavCategoryAttribute->getAttributesByCategoryId($identifier, array(
            'inheritance' => false,
        ));

        $this->set(array(
            'data' => $data,
            '_serialize' => array('data')
        ));
    }

    /**
     * Get category available attributes by category id
     * 
     * @param string $identifier
     */
    public function api_get_attributes_available($identifier = null) {
        $this->EavCategoryAttribute->recursive = 1;

        $data = $this->EavCategoryAttribute->getAttributesByCategoryId($identifier, array(
            'inverted' => true
        ));

        $this->set(array(
            'data' => $data,
            '_serialize' => array('data')
        ));
    }

    /**
     * Get category by slug
     * 
     * @param string $identifier
     */
    public function api_get_by_slug($identifier = null) {
        $this->EavCategory->recursive = -1;

        $data = $this->EavCategory->findBySlug($identifier);

        $this->set(array(
            'data' => $data,
            '_serialize' => array('data')
        ));
    }

    /**
     * Get category by id
     * 
     * @param string $identifier
     */
    public function api_get_by_id($identifier = null) {
        $this->EavCategory->recursive = -1;

        $data = $this->EavCategory->findById($identifier);

        $this->set(array(
            'data' => $data,
            '_serialize' => array('data')
        ));
    }

    /**
     * Get non child categories from specified category id
     * 
     * @param string $identifier
     */
    public function api_get_non_child($identifier = null) {
        $this->EavCategory->recursive = -1;

        $data = $this->EavCategory->getCategoriesNonChildOf($identifier);

        $this->set(array(
            'data' => $data,
            '_serialize' => array('data')
        ));
    }

}
