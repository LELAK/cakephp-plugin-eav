<?php

$this->extend('/Common/admin_edit');

$this->Html
        ->addCrumb('', '/admin', array('icon' => 'home'));

if ($this->request->params['action'] == 'admin_edit') {
    $this->Html
            ->addCrumb(__d("eav", "Atributo"), array('admin' => true, 'plugin' => 'eav', 'controller' => 'attributes', 'action' => 'index'))
            ->addCrumb($this->request->data['EavAttribute']['title'], '#');
}

if ($this->request->params['action'] == 'admin_add') {
    $this->Html
            ->addCrumb(__d("eav", "Atributo"), array('admin' => true, 'plugin' => 'eav', 'controller' => 'attributes', 'action' => 'index'))
            ->addCrumb(__d("eav", 'Criar'), '/' . $this->request->url);
}

$this->Form->create('EavAttribute', array('url' => '/' . $this->request->url,));
$inputDefaults = $this->Form->inputDefaults();
$inputClass = isset($inputDefaults['class']) ? $inputDefaults['class'] : null;

$this->append('tab-heading');
echo $this->Croogo->adminTab(__d("eav", "Atributo"), '#attribute-basic');
echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('attribute-basic');

if ($this->request->params['action'] == 'admin_edit') {
    echo $this->Form->hidden('id');
};

echo $this->Form->input('title', array(
    'label' => __d("eav", 'Título'),
));
echo $this->Form->input('slug', array(
    'label' => __d("eav", 'Atalho'),
    'class' => trim($inputClass . ' slug'),
));
echo $this->Form->input('description', array(
    'label' => __d("eav", 'Descrição'),
));
echo $this->Form->input('entity_type_id', array(
    'label' => __d("eav", "Tipo de Entidade")
));
echo $this->Form->input('input_type', array(
    'options' => $inputTypes, 'label' => __d("eav", "Tipo de input (apenas para visualização)")
));
echo $this->Form->input('data_type_id', array(
    'label' => __d("eav", "Tipo de Dado")
));

echo $this->Form->input('multiple', array('type' => 'checkbox', 'label' => __d("eav", "Múltiplo"), 'class' => false));
echo $this->Form->input('optional', array('type' => 'checkbox', 'label' => __d("eav", "Opcional"), 'class' => false));
echo $this->Form->input('public', array('type' => 'checkbox', 'label' => __d("eav", "Público"), 'class' => false));

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
