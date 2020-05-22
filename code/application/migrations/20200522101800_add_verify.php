<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_verify extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field([
                        'id' => [
                            'type' => 'INT',
                            'unsigned' => TRUE,
                            'auto_increment' => TRUE
                        ],
                        'email' => [
                            'type' => 'VARCHAR',
                            'constraint' => '100',
                        ],
                        'code' => [
                            'type' => 'VARCHAR',
                            'constraint' => '256',
                        ],
                        'callback' => [
                            'type' => 'VARCHAR',
                            'constraint' => '100',
                        ],
                        'active' => [
                            'type' => 'BOOLEAN',
                            'default' => true
                        ],
                        'expire' => [
                            'type' => 'DATETIME',
                        ]
                    ]
                );
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('verify');
        }

        public function down()
        {
                $this->dbforge->drop_table('verify');
        }
}