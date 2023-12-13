<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
Database Tables to Manipulate, 

- taxes   			DONE
- Unit    			DONE
- items   			DONE
- payment_mode 		DONE
- expenses
- expense_types		DONE
- estimates
- estimate_items
- invoices
- invoice_items
- payments
-------------------
Finance Modules
-------------------
1. expenses
2. estimates
3. invoices
4. payments
5. reports

*/

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
			'title' => [
				'type'           => 'VARCHAR',
				'constraint'     => '256'
			],
			'description' => [
				'type'           => 'TEXT'
			],
			'percentage' => [
				'type'           => 'DOUBLE'
			],
    		'created_on TIMESTAMP default CURRENT_TIMESTAMP',
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('taxes');


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
			'title' => [
				'type'           => 'VARCHAR',
				'constraint'     => '256'
			],
    		'created_on TIMESTAMP default CURRENT_TIMESTAMP',
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('payment_mode');

		$this->dbforge->add_field([
			'id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'auto_increment' => TRUE
			],
			'title' => [
				'type'           => 'VARCHAR',
				'constraint'     => '256'
			],
			'workspace_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'description' => [
				'type'           => 'TEXT'
			],
    		'created_on TIMESTAMP default CURRENT_TIMESTAMP',
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('expense_types');

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
			'unit_id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'NULL'     => TRUE,
				
			],
			'title' => [
				'type'           => 'VARCHAR',
				'constraint'     => '256'
			],
			'description' => [
				'type'           => 'TEXT'
			],
			'price' => [
				'type'           => 'DOUBLE'
			],
    		'created_on TIMESTAMP default CURRENT_TIMESTAMP',
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('items');

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
			'client_id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'NULL'     => TRUE,
				
			],
			'name' => [
				'type'           => 'VARCHAR',
				'constraint'     => '64',
				'NULL'     => TRUE,
				
			],
			'address' => [
				'type'           => 'VARCHAR',
				'constraint'     => '1024',
				'NULL'     => TRUE,
				
			],
			'city' => [
				'type'           => 'VARCHAR',
				'constraint'     => '128',
				'NULL'     => TRUE,
				
			],
			'state' => [
				'type'           => 'VARCHAR',
				'constraint'     => '128',
				'NULL'     => TRUE,
				
			],
			'country' => [
				'type'           => 'VARCHAR',
				'constraint'     => '128',
				'NULL'     => TRUE,
				
			],
			'zip_code' => [
				'type'           => 'VARCHAR',
				'constraint'     => '28',
				'NULL'     => TRUE,
				
			],
			'contact' => [
				'type'           => 'VARCHAR',
				'constraint'     => '28',
				'NULL'     => TRUE,
				
			],
			'estimate_items_ids' => [
				'type'           => 'TEXT',
				'NULL'     => TRUE
			],
			'note' => [
				'type'           => 'TEXT',
				'NULL'     => TRUE
			],
			'personal_note' => [
				'type'           => 'TEXT',
				'NULL'     => TRUE
			],
			'amount' => [
				'type'           => 'DOUBLE'
			],
			'status' => [
				'type'			=> 'INT',
				'default'		=> '0'
			],
			'estimate_date DATETIME default NULL',
			'valid_upto_date DATETIME default NULL',
    		'created_on TIMESTAMP default CURRENT_TIMESTAMP',
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('estimates');
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
			'estimate_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'item_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'description' => [
				'type'           => 'TEXT',
				'NULL'     => TRUE
			],
			'qty' => [
				'type'           => 'DOUBLE',
				'NULL'     => TRUE
			],
			'unit_id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'default'		 => '0',
			],
			'rate' => [
				'type'           => 'DOUBLE'
			],
			'tax_id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'NULL' 			 => TRUE
			],
    		'created_on TIMESTAMP default CURRENT_TIMESTAMP',
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('estimate_items');

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
			'client_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'project_id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'NULL'     => TRUE
			],
			'name' => [
				'type'           => 'VARCHAR',
				'constraint'     => '64',
				'NULL'     => TRUE,
				
			],
			'address' => [
				'type'           => 'VARCHAR',
				'constraint'     => '1024',
				'NULL'     => TRUE,
				
			],
			'city' => [
				'type'           => 'VARCHAR',
				'constraint'     => '128',
				'NULL'     => TRUE,
				
			],
			'state' => [
				'type'           => 'VARCHAR',
				'constraint'     => '128',
				'NULL'     => TRUE,
				
			],
			'country' => [
				'type'           => 'VARCHAR',
				'constraint'     => '128',
				'NULL'     => TRUE,
				
			],
			'zip_code' => [
				'type'           => 'VARCHAR',
				'constraint'     => '28',
				'NULL'     => TRUE,
				
			],
			'contact' => [
				'type'           => 'VARCHAR',
				'constraint'     => '28',
				'NULL'     => TRUE,
				
			],
			'invoice_items_ids' => [
				'type'           => 'VARCHAR',
				'constraint'     => '256'
			],

			'note' => [
				'type'           => 'TEXT',
				'NULL'     => TRUE
			],
			'personal_note' => [
				'type'           => 'TEXT',
				'NULL'     => TRUE
			],
			'status' => [
				'type'			=> 'INT',
				'default'		=> '0'
			],

			'amount' => [
				'type'           => 'DOUBLE'
			],
			'invoice_date TIMESTAMP default CURRENT_TIMESTAMP',
			'due_date TIMESTAMP default CURRENT_TIMESTAMP',
    		'created_on TIMESTAMP default CURRENT_TIMESTAMP',
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('invoices');

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
			'invoice_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'item_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'description' => [
				'type'           => 'TEXT'
			],
			'qty' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],

			'unit_id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'default'		 => '0',
			],
			'rate' => [
				'type'           => 'DOUBLE'
			],
			'tax_id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'NULL' 			 => TRUE
			],
    		'created_on TIMESTAMP default CURRENT_TIMESTAMP',
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('invoice_items');
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
			'invoice_id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'NULL' 			 => TRUE
			],
			'user_id' => [
				'type'           => 'INT',
				'constraint'     => '11',
				'NULL' 			 => TRUE
			],
			'note' => [
				'type'           => 'TEXT',
				'NULL'			 => true
			],
			'payment_mode_id' => [
				'type' 			 => 'INT',
				'constraint'	 => '11'
			],
			'amount' => [
				'type'           => 'DOUBLE'
			],
			'payment_date TIMESTAMP default CURRENT_TIMESTAMP',
    		'created_on TIMESTAMP default CURRENT_TIMESTAMP',
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('payments');
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
			'expense_type_id' => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'title' => [
				'type'           => 'TEXT'
			],
			'note' => [
				'type'           => 'TEXT',
				'NULL'     => TRUE
			],
			'amount' => [
				'type'           => 'DOUBLE'
			],
			'expense_date TIMESTAMP default CURRENT_TIMESTAMP',
    		'created_on TIMESTAMP default CURRENT_TIMESTAMP',
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('expenses');

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
			'title' => [
				'type'           => 'VARCHAR',
				'constraint'     => '256'
			],
			'description' => [
				'type'           => 'TEXT'
			],
    		'created_on TIMESTAMP default CURRENT_TIMESTAMP',
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('unit');

		$fields = array(
			'address' => array('type' => 'TEXT','after' => 'last_name','NULL' => TRUE),
			'city' => array('type' => 'VARCHAR', 'constraint' => '256', 'after' => 'address','NULL' => TRUE),
			'state' => array('type' => 'VARCHAR', 'constraint' => '256', 'after' => 'city','NULL' => TRUE),
			'zip_code' => array('type' => 'VARCHAR', 'constraint' => '56', 'after' => 'state','NULL' => TRUE),
			'country' => array('type' => 'VARCHAR', 'constraint' => '256', 'after' => 'zip_code','NULL' => TRUE
			)
			
			);
		$this->dbforge->add_column('users', $fields);

	}

	public function down(){
		$this->dbforge->drop_table('taxes', TRUE);
		$this->dbforge->drop_table('expense_types', TRUE);
		$this->dbforge->drop_table('items', TRUE);
		$this->dbforge->drop_table('estimates', TRUE);
		$this->dbforge->drop_table('estimate_items', TRUE);
		$this->dbforge->drop_table('invoices', TRUE);
		$this->dbforge->drop_table('invoice_items', TRUE);
		$this->dbforge->drop_table('payments', TRUE);
		$this->dbforge->drop_table('expenses', TRUE);
		$this->dbforge->drop_table('unit', TRUE);
		$this->dbforge->drop_table('payment_mode', TRUE);
	}
}
