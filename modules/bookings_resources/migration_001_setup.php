<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Resources_Setup_RB_HC_Migration extends HC_Migration
{
	public function up()
	{
		return;

		// if( ! $this->db->table_exists('bookings_resources') ){
			// return;
		// }

		$this->dbforge->add_field(
			array(
				'id' => array(
					'type' => 'INT',
					'null' => FALSE,
					'unsigned' => TRUE,
					'auto_increment' => TRUE
					),
				'booking_id' => array(
					'type' => 'INT',
					'unsigned' => TRUE,
					'null' => FALSE,
					),
				'resource_id' => array(
					'type' => 'INT',
					'unsigned' => TRUE,
					'null' => FALSE,
					),
				)
			);

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('bookings_resources');
	}

	public function down()
	{
		if( $this->db->table_exists('bookings_resources') ){
			$this->dbforge->drop_table('bookings_resources');
		}
	}
}