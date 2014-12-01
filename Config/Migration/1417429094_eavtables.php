<?php

class EavTablesMigration extends CakeMigration {

    /**
     * Migration description
     *
     * @var string
     * @access public
     */
    public $description = '';

    /**
     * Actions to be performed
     *
     * @var array $migration
     * @access public
     */
    public $migration = array(
        'up' => array(
            'create_table' => array(
                'eav_attributes' => array(
                    'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_bin'),
                    'title' => array('type' => 'string', 'null' => false, 'length' => 100),
                    'slug' => array('type' => 'string', 'null' => false, 'length' => 100, 'charset' => 'utf8', 'key' => 'unique'),
                    'description' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
                    'entity_type_id' => array('type' => 'integer', 'null' => false),
                    'data_type_id' => array('type' => 'integer', 'null' => false),
                    'input_type' => array('type' => 'string', 'null' => false, 'length' => 45),
                    'multiple' => array('type' => 'integer', 'default' => 0, 'length' => 1, 'null' => true),
                    'optional' => array('type' => 'integer', 'default' => 0, 'length' => 1, 'null' => true),
                    'public' => array('type' => 'integer', 'default' => 0, 'length' => 1, 'null' => true),
                    'created' => array('type' => 'datetime', 'null' => false),
                    'modified' => array('type' => 'datetime', 'null' => false),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
                ),
                'eav_data_types' => array(
                    'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
                    'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32),
                    'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
                    'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
                ),
                'eav_entity_types' => array(
                    'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
                    'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32),
                    'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
                    'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
                ),
                'eav_attribute_boolean' => array(
                    'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_bin'),
                    'entity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'value' => array('type' => 'integer', 'null' => false, 'default' => 0, 'length' => 1),
                    'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
                ),
                'eav_attribute_integer' => array(
                    'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_bin'),
                    'entity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'value' => array('type' => 'integer', 'null' => false, 'default' => 0),
                    'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
                ),
                'eav_attribute_key' => array(
                    'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_bin'),
                    'entity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'value' => array('type' => 'integer', 'null' => true, 'default' => 0, 'length' => 11),
                    'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
                ),
                'eav_attribute_uuid' => array(
                    'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_bin'),
                    'entity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'value' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
                ),
                'eav_attribute_string' => array(
                    'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_bin'),
                    'entity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'value' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 255, 'collate' => 'utf8_bin'),
                    'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
                ),
                'eav_attribute_text' => array(
                    'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_bin'),
                    'entity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'value' => array('type' => 'text', 'null' => true, 'default' => null, 'length' => 255, 'collate' => 'utf8_bin'),
                    'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
                ),
                'eav_attribute_timestamp' => array(
                    'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_bin'),
                    'entity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'value' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
                ),
                'eav_categories' => array(
                    'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
                    'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
                    'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 255, 'collate' => 'utf8_bin'),
                    'slug' => array('type' => 'string', 'null' => false, 'length' => 100, 'charset' => 'utf8', 'key' => 'unique'),
                    'public' => array('type' => 'integer', 'null' => false, 'default' => 0, 'length' => 1),
                    'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
                    'lft' => array('type' => 'integer', 'null' => true, 'default' => null),
                    'rght' => array('type' => 'integer', 'null' => true, 'default' => null),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1),
                        'UNIQUE' => array('column' => 'slug', 'unique' => 1)
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
                ),
                'eav_category_attributes' => array(
                    'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
                    'attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin'),
                    'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
                    'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
                ),
            )
        ),
        'down' => array(
            'drop_table' => array(
                'eav_attributes',
                'eav_attribute_boolean',
                'eav_attribute_integer',
                'eav_attribute_key',
                'eav_attribute_string',
                'eav_attribute_text',
                'eav_attribute_timestamp',
                'eav_attribute_uuid',
                'eav_categories',
                'eav_category_attributes',
                'eav_data_types',
                'eav_entity_types'
            )
        )
    );

    /**
     * Before migration callback
     *
     * @param string $direction, up or down direction of migration process
     * @return boolean Should process continue
     * @access public
     */
    public function before($direction) {
        if ($direction === 'down') {
            return false;
        }
        return true;
    }

    /**
     * After migration callback
     *
     * @param string $direction, up or down direction of migration process
     * @return boolean Should process continue
     * @access public
     */
    public function after($direction) {


        $dataType = ClassRegistry::init('EavDataType');
        if ($direction === 'up') {
            // add 2 records to statues table
            $data = array(
                array('name' => 'string'),
                array('name' => 'text'),
                array('name' => 'integer'),
                array('name' => 'timestamp'),
                array('name' => 'boolean'),
                array('name' => 'key'),
                array('name' => 'uuid'),
            );
            $dataType->create();
            $dataType->saveAll($data);
        } elseif ($direction === 'down') {
            // do more work here
        }
        return true;
    }

}
