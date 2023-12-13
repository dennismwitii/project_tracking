<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_update extends CI_Migration {

	public function __construct() {
		parent::__construct();
		$this->load->dbforge();
	}

	public function up() {  
		// editing data for table 'users' adding profile field
		$fields = array(
        'profile' => array('type' => 'VARCHAR', 'constraint' => '256', 'null' => TRUE, 'after' => 'chat_theme')
		);
		$this->dbforge->add_column('users', $fields);

		// Table structure for table 'groups'
		$this->dbforge->add_field([
			'id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],
			'version' => [
				'type'       => 'FLOAT'
			]
		]);
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('updates');

		// Dumping data for table 'groups'
		$data = [
			[
				'version'        => '1.0'
			],
			[
				'version'        => '1.1'
			]
		];
		$this->db->insert_batch('updates', $data);
	}

	public function down() {
		$this->dbforge->drop_column('users', 'profile');
		$this->dbforge->drop_table('updates', TRUE);

	}
}
