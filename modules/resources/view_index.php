<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_View_Index_RB_HC_MVC extends _HC_MVC
{
	public function render( $entries )
	{
		$header = $this->run('prepare-header');
		$sort = $this->run('prepare-sort');

		$rows = array();
		foreach( $entries as $e ){
			$rows[$e['id']] = $this->run('prepare-row', $e);
		}

		$out = $this->make('/html/view/container');

		if( $rows ){
			if( ! isset($args['sort']) ){
				$args['sort'] = 'name-1';
			}

			$table = $this->make('/html/view/sorted-table')
				->set_header($header)
				->set_rows($rows)
				->set_sort($sort)
				;
			$table
				->add_cell_style('padding', 'x2', 'y2')
				;
			$out->add( $table );
		}

		return $out;
	}

	public function prepare_header()
	{
		$return = array(
			'title'	=> HCM::__('Name'),
			'id'	=> 'ID',
			);
		return $return;
	}

	public function prepare_sort()
	{
		$return = array(
			'title'	=> 1,
			'id'	=> 1
			);
		return $return;
	}

	public function prepare_row( $e )
	{
		$return = array();

		$p = $this->make('presenter')
			->set_data( $e )
			;

		$row = array();
		$row['title']		= $e['name'];

		$name_view = $p->present_title();
		$name_view = $this->make('/html/view/link')
			->to('zoom', $e['id'])
			->add($name_view)
			;
		$row['title_view'] = $name_view;

		$row['id']		= $e['id'];
		$id_view = $this->make('/html/view/element')->tag('span')
			->add_style('font-size', -1)
			->add_style('mute')
			->add( $e['id'] )
			;
		$row['id_view']	= $id_view;

		$description_view = $this->make('/html/view/element')->tag('span')
			->add_style('font-size', -1)
			->add_style('mute')
			->add( $p->present_description() )
			;

		$row['description_view']	= $description_view;

		return $row;
	}
}