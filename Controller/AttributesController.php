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
class AttributesController extends EavAppController {

    public $uses = array('Eav.EavAttribute', 'Eav.EavCategoryAttribute');
    public $components = array('RequestHandler');
    protected $apiVersions = ['1.0'];

    public function beforeFilter() {

        $this->input_types = json_decode(CakeSession::read("EAV.inputTypes"), TRUE);

        parent::beforeFilter();
    }

    /**
     * List the attributes
     *
     * @return void
     */
    public function admin_index() {
        $this->EavAttribute->recursive = 0;
        $this->set('attributes', $this->paginate());
    }

    /**
     * View an Attribute
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->EavAttribute->id = $id;
        if (!$this->EavAttribute->exists()) {
            throw new NotFoundException(__d('eav', 'Atributo inválido'));
        }
        $this->set('attribute', $this->EavAttribute->read(null, $id));
    }

    /**
     * Add a new Attribute
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->EavAttribute->create();
            if ($this->EavAttribute->save($this->request->data)) {
                $this->Session->setFlash(__d('eav', 'Atributo salvo'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('eav', 'O atributo não pode ser salvo, tente novamente'));
            }
        }

        $inputTypes = $this->input_types;
        $entityTypes = $this->EavAttribute->EavEntityType->find('list');
        $dataTypes = $this->EavAttribute->EavDataType->find('list');
        $this->set(compact('entityTypes', 'dataTypes', 'inputTypes'));

        $this->render('admin_form');
    }

    /**
     * Edit an Attribute
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->EavAttribute->id = $id;
        if (!$this->EavAttribute->exists()) {
            throw new NotFoundException(__d('eav', 'Atributo inválido'));
        }
        if ($this->request->isPost() || $this->request->isPut()) {
            if ($this->EavAttribute->save($this->request->data)) {
                $this->Session->setFlash(__d('eav', 'O atributo foi salvo'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('eav', 'O atributo não pode ser salvo, tente novamente'));
            }
        } else {
            $this->request->data = $this->EavAttribute->read(null, $id);
        }

        $inputTypes = $this->input_types;
        $entityTypes = $this->EavAttribute->EavEntityType->find('list');
        $dataTypes = $this->EavAttribute->EavDataType->find('list');
        $this->set(compact('entityTypes', 'dataTypes', 'inputTypes'));

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
        $this->EavAttribute->id = $id;
        if (!$this->EavAttribute->exists()) {
            throw new NotFoundException(__d('eav', 'Atributo inválido'));
        }
        if ($this->EavAttribute->delete()) {
            $this->Session->setFlash(__d('eav', 'Atributo excluído'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('eav', 'O atributo não pode ser excluído. Tente novamente'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * Get all attributes by GET conditions
     */
    public function api_get() {
        $this->EavAttribute->recursive = -1;

        $data = $this->EavAttribute->find('all', array('conditions' => $this->request->query));

        $this->set(array(
            'data' => $data,
            '_serialize' => array('data')
        ));
    }

    /**
     * Get attribute by slug
     * 
     * @param string $identifier
     */
    public function api_get_by_slug($identifier = null) {
        $this->EavAttribute->recursive = -1;

        $data = $this->EavAttribute->findBySlug($identifier);

        $this->set(array(
            'data' => $data,
            '_serialize' => array('data')
        ));
    }

    /**
     * Get attribute by id
     * 
     * @param string $identifier
     */
    public function api_get_by_id($identifier = null) {
        $this->EavAttribute->recursive = -1;

        $data = $this->EavAttribute->findById($identifier);

        $this->set(array(
            'data' => $data,
            '_serialize' => array('data')
        ));
    }

}
