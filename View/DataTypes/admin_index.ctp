<?php

$this->extend('/Common/admin_index');

$this->Html
        ->addCrumb('', '/admin', array('icon' => 'home'))
        ->addCrumb("Tipo de Dado", array('admin' => true, 'plugin' => 'eav', 'controller' => 'data_types', 'action' => 'index'));

$this->append('actions');
echo $this->Croogo->adminAction(
        __d('eav', 'Cadastrar Tipo de Dado'), array('action' => 'add')
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

foreach ($dataTypes as $dataType):
    $actions = array();
    $actions[] = $this->Croogo->adminRowActions($dataType['EavDataType']['id']);
    $actions[] = $this->Croogo->adminRowAction('', array('action' => 'edit', $dataType['EavDataType']['id']), array('icon' => 'pencil', 'tooltip' => __d('eav', 'Editar este ítem')));
    $actions[] = $this->Croogo->adminRowAction('', array('action' => 'delete', $dataType['EavDataType']['id']), array('icon' => 'trash', 'tooltip' => __d('eav', 'Remover este ítem')), __d('eav', 'Você tem certeza?'));
    $actions = $this->Html->div('item-actions', implode(' ', $actions));

    // Title Column
    $titleCol = $dataType['EavDataType']['name'];

    $rows[] = array(
        '',
        $dataType['EavDataType']['id'],
        $titleCol,
        $actions,
    );
endforeach;
echo $this->Html->tableCells($rows);
$this->end();
