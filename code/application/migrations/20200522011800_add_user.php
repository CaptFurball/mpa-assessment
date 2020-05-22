<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_user extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field([
                        'id' => [
                            'type' => 'INT',
                            'unsigned' => TRUE,
                            'auto_increment' => TRUE
                        ],
                        'username' => [
                            'type' => 'VARCHAR',
                            'constraint' => '100',
                            'unique' => true
                        ],
                        'email' => [
                            'type' => 'VARCHAR',
                            'constraint' => '100',
                            'unique' => true
                        ],
                        'password' => [
                            'type' => 'VARCHAR',
                            'constraint' => '256',
                        ],
                        'active' => [
                            'type' => 'BOOLEAN',
                            'default' => false
                        ],
                        'retry' => [
                            'type' => 'INT',
                            'default' => 0
                        ]
                    ]
                );
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('user');
        }

        public function down()
        {
                $this->dbforge->drop_table('user');
        }
}