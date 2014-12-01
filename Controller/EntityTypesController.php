<?php

App::uses('EavAppController', 'Eav.Controller');
/**
 * Eav Entity Types Controller
 *
 * This file is contains the EntityTypesController class
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
 * Entity Types Controller
 *
 * Methods to manage Entity Types. You need an entity type for each model/object.
 *
 * @package       plugins.Eav.Controller
 */
class EntityTypesController extends EavAppController {

    public $uses = array('Eav.EavEntityType');

    /**
     * List the Entity Types
     *
     * @return void
     */
    public function admin_index() {
        $this->EavEntityType->recursive = 0;
        $this->set('entityTypes', $this->paginate());
    }

    /**
     * View a single Entity Type
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->EavEntityType->id = $id;
        if (!$this->EavEntityType->exists()) {
            throw new NotFoundException(__d('eav','Tipo de entidade inválido'));
        }
        $this->set('entityType', $this->EavEntityType->read(null, $id));
    }

    /**
     * Add a new Entity Type
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->EavEntityType->create();
            if ($this->EavEntityType->save($this->request->data)) {
                $this->Session->setFlash(__d('eav','Tipo de entidade salvo com sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('eav','O tipo de entidade não pode ser salvo. Tente novamente'));
            }
        }
        $this->render('admin_form');
    }

    /**
     * Edit an Entity Type
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->EavEntityType->id = $id;
        if (!$this->EavEntityType->exists()) {
            throw new NotFoundException(__d('eav','Tipo de entidade inválido'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->EavEntityType->save($this->request->data)) {
                $this->Session->setFlash(__d('eav','Tipo de entidade salvo com sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('eav','Tipo de entidade não pode ser salvo. Tente novamente'));
            }
        } else {
            $this->request->data = $this->EavEntityType->read(null, $id);
        }
        $this->render('admin_form');
    }

    /**
     * admin_delete method
     *
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->EavEntityType->id = $id;
        if (!$this->EavEntityType->exists()) {
            throw new NotFoundException(__d('eav','Tipo de entidade inválido'));
        }
        if ($this->EavEntityType->delete()) {
            $this->Session->setFlash(__d('eav','Tipo de entidade deletado'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('eav','Tipo de entidade não pode ser deletado. Tente novamente'));
        $this->redirect(array('action' => 'index'));
    }

}
