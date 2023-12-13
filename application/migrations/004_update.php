<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_update extends CI_Migration {

	public function __construct() {
		parent::__construct();
		$this->load->dbforge();
	}

	public function up() {  

		$this->dbforge->add_field([
			'id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'auto_increment' => TRUE
			],
			'workspace_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'user_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'user_name' => [
				'type'           => 'VARCHAR',
				'constraint'     => '512'
			],
			'type' => [
                'type'           => 'VARCHAR',
                'constraint'     => '128'
			],
			'project_id' => [
				'type'           => 'INT',
				'null' => TRUE,
				'constraint'     => '11'
            ],
            'project_title' => [
				'type'           => 'VARCHAR',
				'null' => TRUE,
				'constraint'     => '1024'
            ],
            'task_id' => [
                'type'           => 'INT',
                'null' => TRUE,
				'constraint'     => '11'
            ],
            'task_title' => [
                'type'           => 'VARCHAR',
                'null' => TRUE,
				'constraint'     => '1024'
            ],
            'comment_id' => [
                'type'           => 'INT',
                'null' => TRUE,
				'constraint'     => '11'
            ],
            'comment' => [
                'type'           => 'TEXT',
                'null' => TRUE
            ],
            'file_id' => [
                'type'           => 'INT',
                'null' => TRUE,
				'constraint'     => '11'
            ],
            'file_name' => [
                'type'           => 'VARCHAR',
                'null' => TRUE,
				'constraint'     => '1024'
            ],
            'milestone_id' => [
                'type'           => 'INT',
                'null' => TRUE,
				'constraint'     => '11'
            ],
            'milestone' => [
                'type'           => 'VARCHAR',
                'null' => TRUE,
				'constraint'     => '1024'
            ],
            'activity' => [
				'type'           => 'VARCHAR',
				'constraint'     => '28'
            ],
            'message' => [
				'type'           => 'VARCHAR',
				'null' => TRUE,
				'constraint'     => '1024'
            ],
    		'date_created TIMESTAMP default CURRENT_TIMESTAMP'
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('activity_log');

		$this->dbforge->add_field([
			'id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'auto_increment' => TRUE
			],
			'workspace_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
            'user_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'title' => [
				'type'           => 'VARCHAR',
				'null' => TRUE,
				'constraint'     => '256'
			],
			'description' => [
				'type'           => 'TEXT',
				'null' => TRUE,
            ],
            'pinned' => [
                'type'           => 'TINYINT',
                'constraint'     => '4',
                'default' => 0
			],
    		'date_created TIMESTAMP default CURRENT_TIMESTAMP'
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('announcements');

		$this->dbforge->add_field([
			'id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'auto_increment' => TRUE
			],
			'workspace_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
            'user_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'title' => [
				'type'           => 'VARCHAR',
				'constraint'     => '256'
            ],
            'text_color' => [
				'type'           => 'VARCHAR',
				'constraint'     => '128'
            ],
            'bg_color' => [
				'type'           => 'VARCHAR',
				'constraint'     => '128'
            ],
            'from_date' => [
                'type'           => 'TIMESTAMP',
                'null' => TRUE
            ],
            'to_date' => [
                'type'           => 'TIMESTAMP',
                'null' => TRUE
            ],
            'is_public' => [
				'type'           => 'TINYINT',
				'constraint'     => '4'
			],
    		'date_created TIMESTAMP default CURRENT_TIMESTAMP'
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('events');

		$this->dbforge->add_field([
			'id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'auto_increment' => TRUE
			],
			'workspace_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'user_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'user_ids' => [
				'type'           => 'VARCHAR',
				'constraint'     => '1024'
			],
			'type' => [
				'type'           => 'VARCHAR',
				'constraint'     => '128'
            ],
            'type_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'title' => [
				'type'           => 'VARCHAR',
				'null' => TRUE,
				'constraint'     => '512'
			],
			'notification' => [
				'type'           => 'TEXT',
				'null' => TRUE,
			],
			'read_by' => [
				'type'           => 'VARCHAR',
				'null' => TRUE,
                'constraint'     => '512',
                'default' => 0
			],
    		'date_created TIMESTAMP default CURRENT_TIMESTAMP'
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('notifications');
	}

	public function down() {
		$this->dbforge->drop_table('activity_log', TRUE);
		$this->dbforge->drop_table('announcements', TRUE);
		$this->dbforge->drop_table('events', TRUE);
		$this->dbforge->drop_table('notifications', TRUE);
	}
}
