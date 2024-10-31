<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface _HC_ORM_Storable_Interface
{
	public function count( $wheres = array() );
	public function fetch( $fields = '*', $wheres = array(), $limit = NULL, $orderby = NULL, $distinct = FALSE );
	public function insert( $data );
	public function update( $data, $wheres = array() );
}

class _HC_ORM_Storable implements _HC_ORM_Storable_Interface
{
	protected $db;
	protected $table;
	protected $id_field = 'id';
	static $query_cache = array();
	protected $use_cache = TRUE;
	protected $search_in = array();

	public function __construct( $db, $table, $id_field = 'id' )
	{
		$this->db = $db;
		$this->table = $table;
		$this->id_field = $id_field;
	}

	public function set_search_in( $search_in )
	{
		$this->search_in = $search_in;
		return $this;
	}

	public function search_in()
	{
		return $this->search_in;
	}

	public function table()
	{
		return $this->table;
	}

	public function count( $wheres = array() )
	{
		if( isset($wheres['search']) ){
			$search_in = $this->search_in();

			if( $search_in ){
				$search_wheres = $wheres['search'];

				$this->db->group_start();
				foreach( $search_in as $sin ){
					reset( $search_wheres );
					foreach( $search_wheres as $where ){
						list( $how, $value, $escape ) = $where;
						$this->db->or_like($sin, $value);
					}
				}
				$this->db->group_end();
			}
			unset( $wheres['search'] );
		}

		foreach( $wheres as $key => $key_wheres ){
			foreach( $key_wheres as $where ){
				list( $how, $value, $escape ) = $where;
				if( $how == 'IN' ){
					$this->db->where_in($key, $value);
				}
				elseif( $how == 'NOT IN' ){
					$this->db->where_not_in($key, $value);
				}
				elseif( $how == 'LIKE' ){
					$this->db->like($key, $value);
				}
				else {
					$this->db->where($key . $how, $value, $escape);
				}
			}
		}

		$return = $this->db->count_all_results( $this->table );
		return $return;
	}

	public function fetch( $fields = '*', $wheres = array(), $limit = NULL, $orderby = NULL, $distinct = FALSE )
	{
		$return = array();

		if( isset($wheres['search']) ){
			$search_in = $this->search_in();

			if( $search_in ){
				$search_wheres = $wheres['search'];

				$this->db->group_start();
				foreach( $search_in as $sin ){
					reset( $search_wheres );
					foreach( $search_wheres as $where ){
						list( $how, $value, $escape ) = $where;
						$this->db->or_like($sin, $value);
					}
				}
				$this->db->group_end();
			}
			unset( $wheres['search'] );
		}

		if( ! is_array($fields) && ($fields != '*') ){
			$fields = array($fields);
		}
		if( is_array($fields) && (! in_array($this->id_field, $fields)) ){
			$fields[] = $this->id_field;
		}

		if( $distinct ){
			$this->db->distinct();
		}
		$this->db->select( $fields );

		if( $limit ){
			if( count($limit) > 1 ){
				$this->db->limit( $limit[0], $limit[1] );
			}
			else {
				$this->db->limit( $limit[0] );
			}
		}
		if( $orderby ){
			foreach( $orderby as $ord ){
				$this->db->order_by( $ord[0], $ord[1] );
			}
		}

		foreach( $wheres as $key => $key_wheres ){
			foreach( $key_wheres as $where ){
				list( $how, $value, $escape ) = $where;
				if( $how == 'IN' ){
					$this->db->where_in($key, $value);
				}
				elseif( $how == 'NOT IN' ){
					$this->db->where_not_in($key, $value);
				}
				elseif( $how == 'LIKE' ){
					$this->db->like($key, $value);
				}
				else {
					$this->db->where($key . $how, $value, $escape);
				}
			}
		}

		$run = TRUE;

		$sql = $this->db->get_compiled_select($this->table);

		if( $this->use_cache ){
			if( isset(self::$query_cache[$sql]) ){
				// echo "ON CACHE: '$sql'<br>";
				$return = self::$query_cache[$sql];
				$run = FALSE;
			}
		}

		if( $run ){
			// $q = $this->db->get( $this->table );
			$q = $this->db->query( $sql );
			foreach( $q->result_array() as $row ){
				$return[ $row[$this->id_field] ] = $row;
			}
		}

		if( $this->use_cache && $run ){
			// echo "SET ON CACHE: '$sql'<br>";
			self::$query_cache[$sql] = $return;
		}

		return $return;
	}

	public function insert( $data )
	{
		$return = NULL;
		if( $this->db->insert( $this->table, $data ) ){
			$return = $this->db->insert_id();
		}
		return $return;
	}

	public function update( $data, $wheres = array() )
	{
		$return = FALSE;
		if( ! $wheres ){
			return $return;
		}

		foreach( $wheres as $key => $key_wheres ){
			foreach( $key_wheres as $where ){
				list( $how, $value, $escape ) = $where;
				$this->db->where($key . $how, $value, $escape);
			}
		}

		if(
			$this->db
				->update( $this->table, $data )
			){
				$return = TRUE;
			}
		else {
			$return = FALSE;
		}
		return $return;
	}

	public function delete( $wheres = array() )
	{
		$return = FALSE;
		if( ! $wheres ){
			return $return;
		}

		foreach( $wheres as $key => $key_wheres ){
			foreach( $key_wheres as $where ){
				list( $how, $value, $escape ) = $where;
				$this->db->where($key . $how, $value, $escape);
			}
		}

		if(
			$this->db
				->delete( $this->table )
			){
				$return = TRUE;
			}
		else {
			$return = FALSE;
		}
		return $return;
	}
}