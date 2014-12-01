<?php

$this->extend('/Common/admin_index');

$this->Html
        ->addCrumb('', '/admin', array('icon' => 'home'))
        ->addCrumb("Tipo de Entidade", array('admin' => true, 'plugin' => 'eav', 'controller' => 'entity_types', 'action' => 'index'));

$this->append('actions');
echo $this->Croogo->adminAction(
        __d('eav', 'Cadastrar Tipo de Entidade'), array('action' => 'add')
);
$this->end();

if (isset($this->request->params['named'])) {
    foreach ($this->request->params['named'] as $nn => $nv) {
        $this->Paginator->options['url'][] = $nn . ':' . $nv;
    }
}
$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders(array(
    '',
    __d('eav', 'Id'),
    __d('eav', 'Título'),
    __d('eav', 'Ações'),
        ));
echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
$rows = array();

foreach ($entityTypes as $entityType):
    $actions = array();
    $actions[] = $this->Croogo->adminRowActions($entityType['EavEntityType']['id']);
    $actions[] = $this->Croogo->adminRowAction('', array('action' => 'edit', $entityType['EavEntityType']['id']), array('icon' => 'pencil', 'tooltip' => __d('eav', 'Editar este ítem')));
    $actions[] = $this->Croogo->adminRowAction('', array('action' => 'delete', $entityType['EavEntityType']['id']), array('icon' => 'trash', 'tooltip' => __d('eav', 'Remover este ítem')), __d('eav', 'Você tem certeza?'));
    $actions = $this->Html->div('item-actions', implode(' ', $actions));

    // Title Column
    $titleCol = $entityType['EavEntityType']['name'];

    $rows[] = array(
        '',
        $entityType['EavEntityType']['id'],
        $titleCol,
        $actions,
    );
endforeach;
echo $this->Html->tableCells($rows);
$this->end();
