<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_Setup_RB_HC_Migration extends HC_Migration
{
	public function up()
	{
		if( $this->db->table_exists('resources') ){
			return;
		}

		$this->dbforge->add_field(
			array(
				'id' => array(
					'type' => 'INT',
					'null' => FALSE,
					'unsigned' => TRUE,
					'auto_increment' => TRUE
					),
				'name' => array(
					'type' => 'VARCHAR(100)',
					'null' => FALSE,
					),
				'show_order' => array(
					'type' => 'INT',
					'null' => FALSE,
					'default' => 0,
					),
				'description' => array(
					'type'		=> 'TEXT',
					'null'		=> TRUE,
					),
				)
			);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('resources');

	/* defaults */
		$insert = array(
			'name'		=> 'Joe Worker',
			);
		$this->db->insert('resources', $insert);
		$insert = array(
			'name'		=> 'Jane Plain',
			);
		$this->db->insert('resources', $insert);
		$insert = array(
			'name'		=> 'Meeting Room #1',
			);
		$this->db->insert('resources', $insert);
	}

	public function down()
	{
		if( $this->db->table_exists('resources') ){
			$this->dbforge->drop_table('resources');
		}
	}
}