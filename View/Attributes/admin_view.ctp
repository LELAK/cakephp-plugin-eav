<div class="attributes view">
    <h2><?php echo __d('eav', 'Atributo'); ?></h2>
    <dl>
        <dt><?php echo __d('eav', 'Id'); ?></dt>
        <dd>
            <?php echo h($attribute['EavAttribute']['id']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('eav', 'Nome'); ?></dt>
        <dd>
            <?php echo h($attribute['EavAttribute']['title']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('eav', 'Atalho'); ?></dt>
        <dd>
            <?php echo h($attribute['EavAttribute']['slug']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('eav', 'Descrição'); ?></dt>
        <dd>
            <?php echo h($attribute['EavAttribute']['description']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('eav', 'Tipo de entidade'); ?></dt>
        <dd>
            <?php echo $this->Html->link($attribute['EavEntityType']['name'], array('controller' => 'entity_types', 'action' => 'view', $attribute['EavEntityType']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('eav', 'Tipo de dado'); ?></dt>
        <dd>
            <?php echo $this->Html->link($attribute['EavDataType']['name'], array('controller' => 'data_types', 'action' => 'view', $attribute['EavDataType']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('eav', 'Criado'); ?></dt>
        <dd>
            <?php echo h($attribute['EavAttribute']['created']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('eav', 'Modificado'); ?></dt>
        <dd>
            <?php echo h($attribute['EavAttribute']['modified']); ?>
            &nbsp;
        </dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __d('eav', 'Ações'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__d('eav', 'Editar atributo'), array('action' => 'edit', $attribute['EavAttribute']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__d('eav', 'Deletar atributo'), array('action' => 'delete', $attribute['EavAttribute']['id']), null, __d('eav', 'Tem certeza que deseja excluír "%s"?', $attribute['EavAttribute']['title'])); ?> </li>
        <li><?php echo $this->Html->link(__d('eav', 'Listar atributos'), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__d('eav', 'Novo atributo'), array('action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__d('eav', 'Listar tipos de entidade'), array('controller' => 'entity_types', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__d('eav', 'Novo tipo de entidade'), array('controller' => 'entity_types', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__d('eav', 'Listar tipos de dado'), array('controller' => 'data_types', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__d('eav', 'Novo tipo de dado'), array('controller' => 'data_types', 'action' => 'add')); ?> </li>
    </ul>
</div>
