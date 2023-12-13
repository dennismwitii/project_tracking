<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_update extends CI_Migration {

	public function __construct() {
		parent::__construct();
		$this->load->dbforge();
	}

	public function up() {  
		$fields = array(
			'user_id' => array(
				'name' => 'user_id',
				'type' => 'VARCHAR',
				'constraint'     => '256'
		),
        'milestone_id' => array(
                'name' => 'milestone_id',
				'type' => 'INT',
				'null' => TRUE
        )
		);
		$this->dbforge->modify_column('tasks', $fields);

		$data = array(
			array('name' => "clients",
			'description' => "projects client")
		);
		$this->db->insert_batch('groups', $data);

		$fields = array(
			'client_id' => array('type' => 'VARCHAR', 'constraint' => '256', 'null' => TRUE, 'after' => 'user_id')
			);
		$this->dbforge->add_column('projects', $fields);

		$fields = array(
			'is_rtl' => array('type' => 'INT', 'constraint' => '11', 'DEFAULT' => '0', 'after' => 'code')
			);
		$this->dbforge->add_column('languages', $fields);

	}

	public function down() {
		$this->dbforge->drop_column('projects', 'client_id');
		$this->dbforge->drop_column('languages', 'is_rtl');
	}
}
