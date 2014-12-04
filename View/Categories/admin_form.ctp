<?php
$this->extend('/Common/admin_edit');

$this->append('container-identifier', 'category-form-app');

echo $this->Html->script(array('Eav.../vendors/toastr/toastr.min'), array('inline' => false));
echo $this->Html->scriptBlock('Croogo.pass = ' . json_encode($this->request->params['pass']) . ';', array('inline' => false));
echo $this->Html->script(array(
    'Eav.../vendors/requirejs/require',
    'Eav.app/category/main.js'
        ), array(
    'inline' => false
));

echo $this->Html->css(
        array(
    'Eav.style',
    'Eav.../vendors/toastr/toastr.min',
    'Eav.../vendors/angularui-select/select2',
    'Eav.../vendors/angularui-select/select.min',
    'Eav.../vendors/angularui-select/selectize.default'
        ), array(
    'inline' => false
        )
);

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
?>
<div ng-controller="CategoryFormController as categoryCtrl" ng-cloak>
    <div class="load-override" ng-show="is_load"></div>
    <fieldset>
        <legend><h3><?= __d("eav", "Propriedades da Categoria"); ?></h3></legend>
        <?php
        echo $this->Form->hidden('id', array(
            'ng-model' => 'categoryCtrl.current.id'
        ));
        ?>
        <div class="input text">
            <label><?= __d("eav", "Categoria Pai"); ?></label>
            <select ng-change="categoryCtrl.changeSelected()" ng-model="categoryCtrl.current.parent_id" ng-options="category.id as category.title for category in categoryCtrl.possibleParentCategories">
                <option value=""><?= __d("eav", "Selecione"); ?></option>
            </select>
        </div>

        <input name="data[EavCategory][parent_id]" type="hidden" value="{{categoryCtrl.current.parent_id}}">

        <?php
        echo $this->Form->input('title', array(
            'label' => __d("eav", 'Título'),
            'ng-model' => 'categoryCtrl.current.title'
        ));

        echo $this->Form->input('slug', array(
            'label' => __d("eav", 'Atalho'),
            'ng-model' => 'categoryCtrl.current.slug'
        ));
        echo $this->Form->input('public', array(
            'type' => 'checkbox',
            'label' => __d("eav", 'Pública'),
            'ng-model' => 'categoryCtrl.current.public',
            'ng-checked' => 'categoryCtrl.current.public'
        ));
        ?>
    </fieldset>
</div>
<?php
echo $this->Html->tabEnd();

echo $this->Html->tabStart('category-attributes');
?>
<div ng-controller="CategoryAttributesFormController as categoryAttributeCtrl" ng-cloak>
    <div class="load-override" ng-show="is_load"></div>
    <fieldset>
        <legend><h3><?= __d("eav", "Atributos da categoria") ?></h3></legend>
        <fieldset>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span7">
                        <ui-select ng-model="attribute.selected" theme="select2" style="min-width: 300px;">
                            <ui-select-match placeholder="<?= __d("eav", "Selecione um atributo") ?>">{{$select.selected.EavAttribute.title}}</ui-select-match>
                            <ui-select-choices repeat="attribute in categoryAttributeCtrl.globalAttributes | filter: $select.search">
                                <div ng-bind-html-unsafe="attribute.EavAttribute.title | highlight: $select.search"></div>
                                <span>{{attribute.EavAttribute.title}}</span><br/>
                                <small>
                                    {{attribute.EavAttribute.description}}
                                </small>
                            </ui-select-choices>
                        </ui-select>
                        <button type="button" class="btn btn-success" ng-click="categoryAttributeCtrl.add(attribute.selected)"><i class="icon-plus"></i></button>
                    </div>
                    <div class="span5">
                        <input type="text" ng-model="attributeSearch" class="form-control" placeholder="Pesquisa">
                    </div>
                </div>
            </div>
        </fieldset>
        <div class="inheritance-table" ng-show="categoryAttributeCtrl.categoryInheritedAttributes.length">
            <p><?= __d("eav", "Esta categoria herda os seguintes atributos de seus superiores") ?></p>
            <ul>
                <li ng-repeat="inherited in categoryAttributeCtrl.categoryInheritedAttributes">
                    <span>{{inherited.EavAttribute.title}}</span><br/>
                    <small>{{inherited.EavAttribute.description}}</small>
                </li>
            </ul>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Atributo</th>
                    <th>Filtrável</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="attribute in categoryAttributeCtrl.categoryAttributes| filter: attributeSearch">
                    <td>
                        <input type="hidden" name="data[EavAttributes][{{$index}}][attribute_id]" value="{{attribute.EavAttribute.id}}">
                        {{attribute.EavAttribute.title}}
                    </td>
                    <td>
                        <input type="hidden" name="data[EavAttributes][{{$index}}][filtered]" id="EavAttributes{{$index}}Filtered_" value="0">
                        <input type="checkbox" name="data[EavAttributes][{{$index}}][filtered]" value="1" id="EavAttributes{{$index}}Filtered" ng-checked="attribute.EavAttribute.filtered == 1">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" ng-click="categoryAttributeCtrl.remove(attribute)"><i class="icon-remove"></i></button>
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
