<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Setup_RB_HC_Migration extends HC_Migration
{
	public function up()
	{
		if( $this->db->table_exists('bookings') ){
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
				'time_start' => array(
					'type' => 'INT',
					'unsigned' => TRUE,
					'null' => TRUE,
					),
				'duration' => array(
					'type' => 'VARCHAR(32)',
					'null' => FALSE,
					),
				'date' => array(
					'type' => 'INT',
					'unsigned' => TRUE,
					'null' => FALSE,
					),
				'ts_start' => array(
					'type'		=> 'INT',
					'unsigned' => TRUE,
					'null' => FALSE,
					),
				'ts_end' => array(
					'type'		=> 'INT',
					'unsigned' => TRUE,
					'null' => FALSE,
					),
				)
			);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('bookings');
	}

	public function down()
	{
		if( $this->db->table_exists('bookings') ){
			$this->dbforge->drop_table('bookings');
		}
	}
}