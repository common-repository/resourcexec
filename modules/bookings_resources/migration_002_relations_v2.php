<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Resources_Relations_V2_RB_HC_Migration extends HC_Migration
{
	public function up()
	{
	// move current relations to new table
		if( ! $this->db->table_exists('bookings_resources') ){
			return;
		}

		$current_relations = array();
		$query = $this->db->get('bookings_resources');
		foreach( $query->result_array() as $row ){
			$current_relations[] = $row;
		}

		foreach( $current_relations as $cr ){
			$insert = array(
				'relation_name'	=> 'resource_booking',
				'from_id'		=> $cr['resource_id'],
				'to_id'			=> $cr['booking_id'],
				);
			$this->db->insert('relations', $insert);
		}

		if( $this->db->table_exists('bookings_resources') ){
			$this->dbforge->drop_table('bookings_resources');
		}
	}

	public function down()
	{
		// if( $this->db->table_exists('bookings_resources') ){
			// $this->dbforge->drop_table('bookings_resources');
		// }
	}
}