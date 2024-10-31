<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Model_RB_HC_MVC extends _HC_ORM
{
	protected $table = 'bookings';
	// protected $fields = array('time_start', 'time_end', 'duration');
	protected $default_order_by = array(
		'ts_start'	=> 'ASC',
		);

	public function save()
	{
		$api = $this->make('/http/lib/api')
			->request('/api/purchases')
			;

		$ref_prefix = 



	// generate timestamps
		$date = $this->get('date');
		$time_start = $this->get('time_start');
		$duration = $this->get('duration');

		$t = $this->make('/app/lib')->run('time');
		$t->setTimezone('UTC');

		$t->setDateDb( $date );
		if( $time_start ){
			$t->modify('+ ' . $time_start . ' seconds');
		}
		$ts_start = $t->getTimestamp();

		$t->modify('+ ' . $duration);
		$ts_end = $t->getTimestamp();

		$this->set('ts_start', $ts_start);
		$this->set('ts_end', $ts_end);

		return parent::save();
	}
}