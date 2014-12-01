<?php

/**
 * Eav Activation
 *
 * Activation class for Eav plugin.
 * This is optional, and is required only if you want to perform tasks when your plugin is activated/deactivated.
 *
 * @package  Croogo
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class EavActivation {

    /**
     * onActivate will be called if this returns true
     *
     * @param  object $controller Controller
     * @return boolean
     */
    public function beforeActivation(&$controller) {
        return true;
    }

    /**
     * Called after activating the plugin in ExtensionsPluginsController::admin_toggle()
     *
     * @param object $controller Controller
     * @return void
     */
    public function onActivation(&$controller) {
        // ACL: set ACOs with permissions
//		$controller->Croogo->addAco('Eav/Eav/admin_index'); // EavController::admin_index()
//		$controller->Croogo->addAco('Eav/Eav/index', array('registered', 'public')); // EavController::index()

        $this->Link = ClassRegistry::init('Menus.Link');

        // Main menu: add an Eav link
        $mainMenu = $this->Link->Menu->findByAlias('main');
        $this->Link->Behaviors->attach('Tree', array(
            'scope' => array(
                'Link.menu_id' => $mainMenu['Menu']['id'],
            ),
        ));
        $this->Link->save(array(
            'menu_id' => $mainMenu['Menu']['id'],
            'title' => 'Eav',
            'link' => 'plugin:eav/controller:eav/action:index',
            'status' => 1,
            'class' => 'eav',
        ));
    }

    /**
     * onDeactivate will be called if this returns true
     *
     * @param  object $controller Controller
     * @return boolean
     */
    public function beforeDeactivation(&$controller) {
        return true;
    }

    /**
     * Called after deactivating the plugin in ExtensionsPluginsController::admin_toggle()
     *
     * @param object $controller Controller
     * @return void
     */
    public function onDeactivation(&$controller) {
        // ACL: remove ACOs with permissions
//		$controller->Croogo->removeAco('Eav'); // EavController ACO and it's actions will be removed

        $this->Link = ClassRegistry::init('Menus.Link');

        // Main menu: delete Eav link
        $link = $this->Link->find('first', array(
            'joins' => array(
                array(
                    'table' => 'menus',
                    'alias' => 'JoinMenu',
                    'conditions' => array(
                        'JoinMenu.alias' => 'main',
                    ),
                ),
            ),
            'conditions' => array(
                'Link.link' => 'plugin:eav/controller:eav/action:index',
            ),
        ));
        if (empty($link)) {
            return;
        }
        $this->Link->Behaviors->attach('Tree', array(
            'scope' => array(
                'Link.menu_id' => $link['Link']['menu_id'],
            ),
        ));
        if (isset($link['Link']['id'])) {
            $this->Link->delete($link['Link']['id']);
        }
    }

}
