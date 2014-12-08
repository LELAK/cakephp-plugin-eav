<?php

/**
 * Admin menu (navigation)
 */
CroogoNav::add('sidebar', 'content.children.eav', array(
    'title' => 'EAV',
    'url' => '#',
    'children' => array(
        'attributes' => array(
            'title' => __d("eav", "Atributos"),
            'url' => array(
                'admin' => true,
                'plugin' => 'eav',
                'controller' => 'attributes',
                'action' => 'index'
            ),
        ),
        'entity_types' => array(
            'title' => __d("eav", "Tipos de Entidade"),
            'url' => array(
                'admin' => true,
                'plugin' => 'eav',
                'controller' => 'entity_types',
                'action' => 'index'
            ),
        ),
        'data_types' => array(
            'title' => __d("eav", "Tipos de Dados"),
            'url' => array(
                'admin' => true,
                'plugin' => 'eav',
                'controller' => 'data_types',
                'action' => 'index'
            ),
        )
    )
));

CakeSession::write('EAV.inputTypes', json_encode(
                array(
                    'text' => __d('eav', 'Texto simples'),
                    'textarea' => __d('eav', 'Texto longo'),
                    'number' => __d('eav', 'Numérico'),
                    'datepicker' => __d('eav', 'Calendário'),
                    'select' => __d('eav', 'Lista selecionável'),
                    'checkbox' => __d('eav', 'Checkbox'),
                )
        )
);
