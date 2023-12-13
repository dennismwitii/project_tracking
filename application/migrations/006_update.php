<?php
class Migration_update extends CI_Migration {

	public function __construct() {
		parent::__construct();
		$this->load->dbforge();
    }
    public function up(){
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
			'subject' => [
				'type'           => 'TEXT'
			],
			'message' => [
				'type'           => 'TEXT'
			],
			'to' => [
				'type'           => 'TEXT'
            ],
            'attachments' => [
				'type'           => 'TEXT',
				'NULL' 			 => TRUE
            ],
            'status' => [
				'type'           => 'VARCHAR',
				'constraint'     => '28',
				'NULL' 			 => TRUE
				
			],
    		'date_sent TIMESTAMP default CURRENT_TIMESTAMP',
		]);
		$this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('emails');
        
        $fields = array(
			'status' => array('type' => 'INT', 'after' => 'created_by','default' => 1)
			);
		$this->dbforge->add_column('workspace', $fields);
    }
}
