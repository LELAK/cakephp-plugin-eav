<?php

$this->extend('/Common/admin_edit');

$this->Html
        ->addCrumb('', '/admin', array('icon' => 'home'));

if ($this->request->params['action'] == 'admin_edit') {
    $this->Html
            ->addCrumb(__d("eav", "Tipo de Entidade"), array('admin' => true, 'plugin' => 'eav', 'controller' => 'entity_types', 'action' => 'index'))
            ->addCrumb($this->request->data['EavEntityType']['name'], '#');
}

if ($this->request->params['action'] == 'admin_add') {
    $this->Html
            ->addCrumb(__d("eav", "Tipo de Entidade"), array('admin' => true, 'plugin' => 'eav', 'controller' => 'entity_types', 'action' => 'index'))
            ->addCrumb(__d("eav", 'Criar'), '/' . $this->request->url);
}

$this->Form->create('EavEntityType', array('url' => '/' . $this->request->url,));
$inputDefaults = $this->Form->inputDefaults();
$inputClass = isset($inputDefaults['class']) ? $inputDefaults['class'] : null;

$this->append('tab-heading');
echo $this->Croogo->adminTab(__d("eav", "Tipo de Entidade"), '#entity-type-basic');
echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('entity-type-basic');

if ($this->request->params['action'] == 'admin_edit') {
    echo $this->Form->hidden('id');
};
echo $this->Form->input('name', array(
    'label' => __d("eav", 'Título'),
));
echo $this->Html->tabEnd();

echo $this->Croogo->adminTabs();

$this->end();

$this->start('panels');
echo $this->Html->beginBox(__d("eav", 'Publicação')) .
 $this->Form->button(__d("eav", 'Aplicar'), array('name' => 'apply')) .
 $this->Form->button(__d("eav", 'Salvar'), array('button' => 'success')) .
 $this->Html->link(
        __d("eav", 'Cancelar'), array('action' => 'index'), array('button' => 'danger')
) .
 $this->Html->endBox();

echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());
