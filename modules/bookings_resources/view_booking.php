<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Resources_View_Booking_RB_HC_MVC extends _HC_MVC
{
	public function render( $model, $form )
	{
		$link = $this->make('/html/view/link')
			->to('booking/update', $model['id'])
			->href()
			;

		$display_form = $this->make('/html/view/form')
			->add_attr('action', $link )
			->set_form( $form )
			;

		$input_resources = $form->input('resources');

	// check conflicts
		$resource_conflicts = array();

		$cm = $this->make('/conflicts/model/manager');
		$t = $this->make('/app/lib')->run('time');
		$p = $this->make('/resources/presenter');

		$api = $this->make('/http/lib/api')
			->request('/api/resources')
			->get()
			;
		$all_resources = $api->response();

		$conflicts_view = array();
		foreach( $all_resources as $resource ){
			$test_booking = $model;
			$test_booking['resources'] = array(
				$resource['id'] => $resource
				);

			$this_conflicts = $cm->run('conflicts', $test_booking);
			if( $this_conflicts ){
				if( ! isset($conflicts_view[$resource['id']]) ){
					$conflicts_view[$resource['id']] = array();
				}

				$this_view = $this->make('/conflicts/view/index')
					->run('prepare-view', $this_conflicts)
					;
				// $this_view = 'KOKO';
				$conflicts_view[$resource['id']] = $this_view;
			}
		}

		$out = $this->make('/html/view/list');

		$current_resources = $input_resources->value();

		foreach( $all_resources as $resource ){
			$this_input = $input_resources->render_one($resource['id']);
			$this_label = $p->set_data($resource)->present_name();

			$this_label = $this->make('/html/view/element')->tag('span')
				->add( $this_label )
				;

			$alert_color = in_array($resource['id'], $current_resources) ? 'red' : 'maroon';
			$ok_color = 'olive';

			if( isset($conflicts_view[$resource['id']]) ){
				$this_label
					->add_style('color', $alert_color)
					;
			}
			else {
				$this_label
					->add_style('color', $ok_color)
					;
			}

			if( isset($conflicts_view[$resource['id']]) ){
				$this_conflicts_view = $this->make('/html/view/element')->tag('div')
					->add( $conflicts_view[$resource['id']] )
					->add_style('margin', 'b2', 't1', 'l3')
					;

				$conflicts_title = $this->make('/html/view/element')->tag('a')
					->add( $this->make('/html/view/icon')->icon('exclamation') )
					->add( HCM::__('Conflicts') )
					->add_style('box', 1)
					->add_style('color', $alert_color)
					->add_style('border-color', $alert_color)
					;

				$this_label
					->prepend( $this->make('/html/view/icon')->icon('exclamation') )
					;

				$this_conflicts_view = $this->make('/html/view/collapse')
					->set_title( $this_label )
					->set_content( $this_conflicts_view )
					;

				$this_label = $this_conflicts_view->render_trigger();
			}

			$this_input
				->set_label( $this_label )
				;

			$resource_view = $this->make('/html/view/element')->tag('div')
				->add_style('margin', 'b1')
				->add_style('border', 'bottom')
				;

			$resource_view
				->add( $this_input )
				;

			if( isset($conflicts_view[$resource['id']]) ){
				$resource_view
					->add( $this_conflicts_view->render_content() )
					;
			}

			$out->add( $resource_view );
		}

		$display_form->add( $out );

		if( ! $form->readonly() ){
			$buttons = $this->make('/html/view/list-inline')
				->add_style('margin', 't2')
				;

			$buttons->add(
				$this->make('/html/view/element')->tag('input')
					->add_attr('type', 'submit')
					->add_attr('title', HCM::__('Save') )
					->add_attr('value', HCM::__('Save') )
					->add_style('btn-primary')
				);

			$display_form->add( $buttons );
		}

		return $display_form;
	}
}