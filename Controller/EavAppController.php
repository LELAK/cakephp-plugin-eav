<?php

/**
 * Eav Application level Controller
 *
 * This file is plugin-wide controller file. You can put all
 * plugin-wide controller-related methods here.
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
App::uses('AppController', 'Controller');

/**
 * Eav App Controller
 *
 * Add your plugin-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       plugins.Eav.Controller
 */
class EavAppController extends AppController {

    public function beforeFilter() {

        parent::beforeFilter();

        // Define if request are in /admin/
        if ($this->request->prefix !== 'api'):
            CakeSession::write('Routing.admin', !empty($this->request->params['admin']));
        elseif (!CakeSession::check("Routing.admin")):
            CakeSession::write('Routing.admin', false);
        endif;

        // As our form is dynamic. We need to disable form security component
        $this->Security->validatePost = false;

        // Check if API version exists for current controller
        $this->checkApíVersion();
    }

    protected function checkApíVersion() {
        if ($this->isApi() && !in_array($this->request->params['apiVersion'], $this->apiVersions)):
            throw new Exception(__d("eav", "Versão de API inválida"));
        endif;
    }

    protected function isApi() {
        return $this->request->prefix === "api";
    }

    protected function smartFlash($message, $format) {
        $this->Session->setFlash($message, 'flash', array('alert' => $format));
    }

}
