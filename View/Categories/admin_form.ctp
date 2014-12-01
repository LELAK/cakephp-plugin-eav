<?php
$this->extend('/Common/admin_edit');


echo $this->Html->script(array(
    'Eav.../vendors/requirejs/require',
    'Eav.app/category/main.js'
        ), array(
    'inline' => false
));

$this->Html
        ->addCrumb('', '/admin', array('icon' => 'home'));

if ($this->request->params['action'] == 'admin_edit') {
    $this->Html
            ->addCrumb(__d("eav", "Categoria"), array('admin' => true, 'plugin' => 'eav', 'controller' => 'categories', 'action' => 'index'))
            ->addCrumb($this->request->data['EavCategory']['title'], '#');
}

if ($this->request->params['action'] == 'admin_add') {
    $this->Html
            ->addCrumb(__d("eav", "Categoria"), array('admin' => true, 'plugin' => 'eav', 'controller' => 'categories', 'action' => 'index'))
            ->addCrumb(__d("eav", 'Criar'), '/' . $this->request->url);
}

$this->Form->create('EavCategory', array('url' => '/' . $this->request->url,));
$inputDefaults = $this->Form->inputDefaults();
$inputClass = isset($inputDefaults['class']) ? $inputDefaults['class'] : null;

$this->append('tab-heading');
echo $this->Croogo->adminTab(__d("eav", "Categoria"), '#category-basic');
echo $this->Croogo->adminTab(__d("eav", "Atributos de Categoria"), '#category-attributes');
echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('category-basic');

if ($this->request->params['action'] == 'admin_edit') {
    echo $this->Form->hidden('id');
};

echo $this->Form->input('parent_id', array(
    'label' => __d("eav", 'Categoria pai'),
    'options' => $categories,
    'empty' => array('0' => 'Selecione uma categoria pai')
));

echo $this->Form->input('title', array(
    'label' => __d("eav", 'Título'),
));

echo $this->Form->input('slug', array(
    'label' => __d("eav", 'Atalho'),
));
echo $this->Form->input('public', array(
    'type' => 'checkbox',
    'label' => __d("eav", 'Pública'),
));
echo $this->Html->tabEnd();

echo $this->Html->tabStart('category-attributes');
echo $this->Html->css(array('Eav.style-admin'));
echo $this->Html->css(array('Eav.../vendors/angularui-select/select.min'));
echo $this->Html->css(array('http://cdnjs.cloudflare.com/ajax/libs/select2/3.4.5/select2.css'));
echo $this->Html->css(array('http://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css'));
?>
<div id="category-form-app" ng-controller="CategoryFormController as categoryCtrl" ng-cloak>
    <div class="load-override" ng-show="is_load"></div>
    <fieldset <?= $this->request->params['action'] == 'admin_edit' ? 'ng-init="categoryCtrl.syncAttributes(' . $this->request->data["EavCategory"]["id"] . ')"' : '' ?>>
        <legend><h3><?= __d("eav", "Atributos da categoria") ?></h3></legend>
        <fieldset>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span7">
                        <ui-select ng-model="attribute.selected" theme="select2" style="min-width: 300px;">
                            <ui-select-match placeholder="<?= __d("eav", "Selecione um atributo") ?>">{{$select.selected.EavAttribute.title}}</ui-select-match>
                            <ui-select-choices repeat="attribute in categoryCtrl.globalAttributes | filter: $select.search">
                                <div ng-bind-html-unsafe="attribute.EavAttribute.title | highlight: $select.search"></div>
                                <span>{{attribute.EavAttribute.title}}</span>
                            </ui-select-choices>
                        </ui-select>
                        <button type="button" class="btn btn-success" ng-click="categoryCtrl.add(attribute.selected)"><i class="icon-plus"></i></button>
                    </div>
                    <div class="span5">
                        <input type="text" ng-model="attributeSearch" class="form-control" placeholder="Pesquisa">
                    </div>
                </div>
            </div>
        </fieldset>
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>Atributo</th>
                    <th>Filtrável</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="attribute in categoryCtrl.categoryAttributes| filter: attributeSearch">
                    <td>
                        <input type="hidden" name="data[EavAttributes][{{$index}}][attribute_id]" value="{{attribute.id}}">
                        {{attribute.title}}
                    </td>
                    <td>
                        <input type="hidden" name="data[EavAttributes][{{$index}}][filtered]" id="EavAttributes{{$index}}Filtered_" value="0">
                        <input type="checkbox" name="data[EavAttributes][{{$index}}][filtered]" value="1" id="EavAttributes{{$index}}Filtered" ng-checked="attribute.filtered == 1">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" ng-click="categoryCtrl.remove($index)"><i class="icon-remove"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </fieldset>
</div>
<?php
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
