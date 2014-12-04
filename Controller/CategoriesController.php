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

    public function beforeFilter() {
        parent::beforeFilter();

        $this->Security->validatePost = false;
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
     * JSON REQUESTS
     */
    public function admin_get($path = false, $identifier = null) {
        $this->_get($path, $identifier);
    }

    public function get($path = false, $identifier = null) {
        $this->_get($path, $identifier);
    }

    protected function _get($path = false, $identifier = null) {

        $output = array();

        $this->EavCategory->recursive = -1;
        $this->EavCategoryAttribute->recursive = 1;

        switch (true):
            // Map all the attributes set to this category
            case ($path == 'attributes'):
                $output = $this->EavCategoryAttribute->getAttributesByCategoryId($identifier);
                break;
            // Map ONLY the attributes inherited from the category tree and not itself
            case ($path == 'attributes_inherited'):
                $output = $this->EavCategoryAttribute->getAttributesByCategoryId($identifier, array(
                    'inheritedOnly' => true
                ));
                break;
            // Map the attributes set for this category only (without inheritance)
            case ($path == 'attributes_own'):
                $output = $this->EavCategoryAttribute->getAttributesByCategoryId($identifier, array(
                    'inheritance' => false,
                ));
                break;
            // Map the attributes available for this category
            case ($path == 'attributes_available'):
                $output = $this->EavCategoryAttribute->getAttributesByCategoryId($identifier, array(
                    'inverted' => true
                ));
                break;
            // Find an category by slug
            case ($path == 'slug'):
                $output = $this->EavCategory->findBySlug($identifier);
                break;
            // Find an category by id
            case ($path == 'id'):
                $output = $this->EavCategory->findById($identifier);
                break;
            // Get all categories non related (that hasn't the specific category ID as parent)
            case ($path == 'non_child'):
                $output = $this->EavCategory->getCategoriesNonChildOf($identifier);
                break;
            // Map the category list
            default:
                $output = $this->EavCategory->getCategoriesByConditions($this->request->query);
        endswitch;

        $this->set(array(
            'data' => $output,
            '_serialize' => array('data')
        ));
    }

}
