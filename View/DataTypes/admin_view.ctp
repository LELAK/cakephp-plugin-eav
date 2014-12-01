<div class="dataTypes view">
    <h2><?php echo __d('eav', 'Tipo de dado'); ?></h2>
    <dl>
        <dt><?php echo __d('eav', 'Id'); ?></dt>
        <dd>
            <?php echo h($dataType['EavDataType']['id']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('eav', 'Nome'); ?></dt>
        <dd>
            <?php echo h($dataType['EavDataType']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('eav', 'Criado'); ?></dt>
        <dd>
            <?php echo h($dataType['EavDataType']['created']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('eav', 'Modificado'); ?></dt>
        <dd>
            <?php echo h($dataType['EavDataType']['modified']); ?>
            &nbsp;
        </dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __d('eav', 'Ações'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__d('eav', 'Editar tipo de dado'), array('action' => 'edit', $dataType['EavDataType']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__d('eav', 'Deletar tipo de dado'), array('action' => 'delete', $dataType['EavDataType']['id']), null, __d('eav', 'Tem certeza que deseja excluír "%s"?', $dataType['EavDataType']['name'])); ?> </li>
        <li><?php echo $this->Html->link(__d('eav', 'Listar tipos de dado'), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__d('eav', 'Novo tipo de dado'), array('action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__d('eav', 'Listar atributos'), array('controller' => 'attributes', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__d('eav', 'Novo atributo'), array('controller' => 'attributes', 'action' => 'add')); ?> </li>
    </ul>
</div>
<div class="related">
    <h3><?php echo __d('eav', 'Atributos relacionados'); ?></h3>
    <?php if (!empty($dataType['EavAttribute'])): ?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __d('eav', 'Id'); ?></th>
                <th><?php echo __d('eav', 'Título'); ?></th>
                <th><?php echo __d('eav', 'Atalho'); ?></th>
                <th><?php echo __d('eav', 'Descrição'); ?></th>
                <th><?php echo __d('eav', 'Tipo de entidade'); ?></th>
                <th><?php echo __d('eav', 'Tipo de dado'); ?></th>
                <th><?php echo __d('eav', 'Criado'); ?></th>
                <th><?php echo __d('eav', 'Modificado'); ?></th>
                <th class="actions"><?php echo __d('eav', 'Ações'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($dataType['EavAttribute'] as $attribute):
                ?>
                <tr>
                    <td><?php echo $attribute['id']; ?></td>
                    <td><?php echo $attribute['title']; ?></td>
                    <td><?php echo $attribute['slug']; ?></td>
                    <td><?php echo $attribute['description']; ?></td>
                    <td><?php echo $attribute['entity_type_id']; ?></td>
                    <td><?php echo $attribute['data_type_id']; ?></td>
                    <td><?php echo $attribute['created']; ?></td>
                    <td><?php echo $attribute['modified']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__d('eav', 'Visualizar'), array('controller' => 'attributes', 'action' => 'view', $attribute['id'])); ?>
                        <?php echo $this->Html->link(__d('eav', 'Editar'), array('controller' => 'attributes', 'action' => 'edit', $attribute['id'])); ?>
                        <?php echo $this->Form->postLink(__d('eav', 'Deletar'), array('controller' => 'attributes', 'action' => 'delete', $attribute['id']), null, __d('eav', 'Tem certeza que deseja excluír "%s"?', $attribute['title'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__d('eav', 'Novo Atributo'), array('controller' => 'attributes', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>
