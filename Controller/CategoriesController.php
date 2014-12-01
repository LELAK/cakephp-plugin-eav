<?php

App::uses('EavAppController', 'Eav.Controller');
/**
 * Eav Attributes Controller
 *
 * This file is contains the AttributesController class
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
 * @package       plugins.Eav.Controller
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Attributes Controller
 *
 * Methods to manage Attributes. Attributes are the dynamic fields added to an Entity
 *
 * @package       plugins.Eav.Controller
 */
class CategoriesController extends EavAppController {

    public $uses = array('Eav.EavCategory', 'Eav.EavAttribute', 'Eav.EavCategoryAttributes');

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

        $categories = $this->EavCategory->find('list');
        $attributes = $this->EavAttribute->find('list');

        $this->set(compact('attributes', 'categories'));

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

        $categories = $this->EavCategory->find('list', array('conditions' => array('EavCategory.id NOT' => $id)));
        $attributes = $this->EavAttribute->find('list');
        $this->set(compact('attributes', 'categories'));

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
    public function admin_attributes() {
        $this->_attributes();
    }

    public function attributes() {
        $this->_attributes();
    }

    public function admin_get() {
        $this->_get();
    }

    public function get() {
        $this->_get();
    }

    /**
     * Get information about category by condition
     */
    protected function _get() {
        $this->EavCategory->recursive = -1;

        $output = $this->EavCategory->getCategoriesByConditions($this->request->query);

        $this->set(array(
            'data' => $output,
            '_serialize' => array('data')
        ));
    }

    protected function _attributes() {
        $this->EavCategoryAttributes->recursive = 1;

        $output = $this->EavCategoryAttributes->getAttributesByConditions($this->request->query);

        $this->set(array(
            'data' => $output,
            '_serialize' => array('data')
        ));
    }

}
