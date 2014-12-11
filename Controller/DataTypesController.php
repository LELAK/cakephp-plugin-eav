<?php

App::uses('EavAppController', 'Eav.Controller');
/**
 * Eav Attributes Controller
 *
 * This file is contains the DataTypesController class
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
 * Data Types Controller
 *
 * Methods to manage Data Types. Data Types map to the CakePHP data types.
 *
 * @package       plugins.Eav.Controller
 *
 */
class DataTypesController extends EavAppController {

    public $uses = array('Eav.EavDataType');

    /**
     * View a list of Data Types
     *
     * @return void
     */
    public function admin_index() {
        $this->EavDataType->recursive = 0;
        $this->set('dataTypes', $this->paginate());
    }

    /**
     * View a single Data Type
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->EavDataType->id = $id;
        if (!$this->EavDataType->exists()) {
            throw new NotFoundException(__d('eav', 'Tipo de dado inválido'));
        }
        $this->set('dataType', $this->EavDataType->read(null, $id));
    }

    /**
     * Add a New Data Type
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->EavDataType->create();
            if ($this->EavDataType->save($this->request->data)) {
                $this->smartFlash(sprintf(__d("eav", "Tipo de dado %s"), __d("eav", "salvo")), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->smartFlash(sprintf(__d("eav", "O tipo de dado não pode ser %s. Tente novamente."), __d("eav", "salvo")), 'danger');
            }
        }

        $this->render('admin_form');
    }

    /**
     * Edit a Data Type
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->EavDataType->id = $id;
        if (!$this->EavDataType->exists()) {
            throw new NotFoundException(__d('eav', 'Tipo de dado inválido'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->EavDataType->save($this->request->data)) {
                $this->smartFlash(sprintf(__d("eav", "Tipo de dado %s"), __d("eav", "editado")), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->smartFlash(sprintf(__d("eav", "O tipo de dado não pode ser %s. Tente novamente."), __d("eav", "editado")), 'danger');
            }
        } else {
            $this->request->data = $this->EavDataType->read(null, $id);
        }

        $this->render('admin_form');
    }

    /**
     * Delete a Data Type
     *
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->EavDataType->id = $id;
        if (!$this->EavDataType->exists()) {
            throw new NotFoundException(__d('eav', 'Tipo de dado inválido'));
        }
        if ($this->EavDataType->delete()) {
            $this->smartFlash(sprintf(__d("eav", "Tipo de dado %s"), __d("eav", "excluído")), 'success');
            $this->redirect(array('action' => 'index'));
        }
        $this->smartFlash(sprintf(__d("eav", "O tipo de dado não pode ser %s. Tente novamente."), __d("eav", "excluído")), 'danger');
        $this->redirect(array('action' => 'index'));
    }

}
