<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class _HC_ORM_WordPress_Custom_Post_Storable implements _HC_ORM_Storable_Interface
{
	public $post_type = NULL;

	protected function _get_id( $wheres = array() )
	{
		$return = NULL;
		foreach( $wheres as $key => $key_wheres ){
			if( $key == 'id' ){
				$key_wheres = array_shift( $key_wheres );
				if( $key_wheres[0] == '=' ){
					$return = array( $key_wheres[1] );
					break;
				}
				elseif( $key_wheres[0] == 'IN' ){
					$return = $key_wheres[1];
					break;
				}
			}
		}
		return $return;
	}

	protected function _prepare_args( $wheres = array() )
	{
		$post_id = $this->_get_id( $wheres );

		$args = array( 
			'post_type'	=> $this->post_type
			);

		if( isset($wheres['search']) ){
			foreach( $wheres['search'] as $where ){
				$args['s'] = $where[1];
			}
			unset($wheres['search']);
		}

	// one
		if( $post_id ){
			$args['post__in'] = $post_id;
		}
		else {
			if( $wheres ){
				$meta_query = array();
				foreach( $wheres as $k => $conds ){
					reset( $conds );
					if( substr($k, 0, strlen('post_')) == 'post_' ){
						foreach( $conds as $cond ){
							$args['s'] = $cond[1];
						}
					}
					else {
						foreach( $conds as $cond ){
							switch( $cond[0] ){
								case 'NOT IN':
								case 'NOTIN':
									$args['post__not_in'] = $cond[1];
									continue;
									break;
								
								default:
									$meta_query[] = array(
										'key'		=> $k,
										'value'		=> $cond[1],
										'compare'	=> $cond[0],
										);
									break;
							}
						}
					}
				}
				$args['meta_query'] = $meta_query;
			}
		}

		return $args;
	}

	public function fetch( $fields = '*', $wheres = array(), $limit = NULL, $orderby = NULL, $distinct = FALSE )
	{
		$return = array();

	// check if we have any post_ parts
		$post_wheres = array();
		reset( $wheres );
		foreach( $wheres as $k => $w ){
			if( substr($k, 0, strlen('post_')) == 'post_' ){
				$post_wheres[$k] = $w;
			}
		}

		$args = $this->_prepare_args( $wheres );
		if( $orderby ){
			foreach( $orderby as $ord ){
				$args['orderby'] = $ord[0];
				$args['order'] = $ord[1];
			}
		}

		if( $limit ){
			if( count($limit) > 1 ){
				$args['posts_per_page'] = $limit[0];
				$args['offset'] = $limit[1];
			}
			else {
				$args['posts_per_page'] = $limit[0];
			}
		}
		else {
			$args['nopaging'] = TRUE;
		}

		// $posts = get_posts( $args );
		$query = new WP_Query( $args );
		// echo $query->request;

		if( $query->have_posts() ){
			while( $query->have_posts() ){
				$post = $query->next_post();
				$post = $post->to_array();
				$post['id'] = $post['ID'];

				$skip_this = FALSE;
				if( $post_wheres ){
					reset( $post_wheres );
					foreach( $post_wheres as $k => $conds ){
						if( ! isset($post[$k]) ){
							$skip_this = TRUE;
							break;
						}

						foreach( $conds as $cond ){
							$compare = $cond[0];
							$value = $cond[1];

							switch( $compare ){
								case '=':
									if( $post[$k] != $value ){
										// echo "POST FAILED!";
										// _print_r( $post );
										$skip_this = TRUE;
									}
									break;
							}
							if( $skip_this ){
								break;
							}
						}
					}
				}

				if( $skip_this ){
					continue;
				}

				$meta = get_post_meta( $post['id'] );
				foreach( $meta as $k => $v ){
					if( substr($k, 0, 1) == '_' ){
						continue;
					}
					if( is_array($v) && count($v) == 1 ){
						$v = array_shift( $v );
					}
					$post[$k] = $v;
				}

				$return[ $post['id'] ] = $post;
			}
		}

		return $return;
	}

	public function count( $wheres = array() )
	{
		$return = 0;
		$args = $this->_prepare_args( $wheres );
		$query = new WP_Query( $args );

		$return = $query->found_posts;
		return $return;
	}

	public function delete( $data = array(), $post_id = NULL )
	{
		if( ! $post_id ){
			return;
		}

		reset( $data );
		foreach( $data as $k => $v ){
			delete_post_meta( $post_id, $k, $v );
		}
	}

	public function insert( $data, $post_id = NULL )
	{
		if( ! $post_id ){
			$core_data = array();
			$core_data['post_status'] = 'publish';
			$core_data['post_type'] = $this->post_type;
			reset( $data );
			foreach( $data as $k => $v ){
			// skip all starting with 'post_'
				if( substr($k, 0, strlen('post_')) != 'post_' ){
					continue;
				}
				$core_data[$k] = $data[$k];
			}

			$post_id = wp_insert_post( $core_data );
		}

		if( ! $post_id ){
			return;
		}

		if( is_array($post_id) ){
			$post_id = array_shift( $post_id );
		}

		reset( $data );
		foreach( $data as $k => $v ){
		// skip all starting with 'post_'
			if( substr($k, 0, strlen('post_')) == 'post_' ){
				continue;
			}
			if( $k == 'id' ){
				continue;
			}
			add_post_meta( $post_id, $k, $v );
		}
		return $post_id;
	}

	public function update( $data, $wheres = array() )
	{
		$post_id = $this->_get_id( $wheres );
		if( ! $post_id ){
			return $return;
		}

		reset( $data );
		foreach( $data as $k => $v ){
			foreach( $post_id as $pid ){
				update_post_meta( $pid, $k, $v );
			}
		}
	}
}
