<?php

namespace WPFP\App\Libraries;

class Query_builder
{
	public $db;
	public $dbConnect = '';

	public function __construct($setDbConnect = null)
	{
		if ($setDbConnect == null) {
			
			require_once( ABSPATH .'wp-config.php' );

			$connectDB = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			$this->dbConnect = $connectDB;
		} else {
			$this->dbConnect = $setDbConnect;
	
		}
	}

	// connect to database
	public function db_conn()
	{
		return $this->dbConnect;
	}

	// query method
	public function query($query)
	{
		$this->db = $this->db_conn();
		return $this->db->query($query);
	}

	// fetch data
	public function rowArr($data)
	{
		while ($datas = $data->fetch_array()) {
			$fetch_data[] = $datas;
		}

		$fetch_data = $data->num_rows > 0 ? $fetch_data : [];

		return $fetch_data;
	}

	// get num rows data
	public function getNum($data)
	{
		return $data->num_rows;
	}

	// delete data from database
	public function delete($table, $where)
	{
		$this->db = $this->db_conn();
		$get_where = "";

		foreach ($where as $name_fields => $value_of_fields) {
			$get_where = "$get_where $name_fields = '$value_of_fields' AND ";
		}

		$this->where = rtrim($get_where, ' AND ');
		$execute_query =  $this->db->query("DELETE FROM $table WHERE $this->where");
		return $execute_query !== FALSE ? TRUE : FALSE;
	}

	// select data and set where
	public function select($table, $where = NULL, $like = NULL, $limit = NULL, $orderby = NULL)
	{

		$this->db = $this->db_conn();
		$get_where = "";

		// set query limit
		$this->limit = $limit !== NULL ? 'LIMIT ' . $limit : ' ';
		// set query order by
		$this->orderby = $orderby !== NULL ? 'ORDER BY ' . $orderby : ' ';
		// set query order name
		$this->like = $like !== NULL ? 'LIKE \'' . $like . '\'' : ' ';
		// set where
		$this->where = $where !== NULL ? ' WHERE ' . $where : ' ';

		if (isset($where) && is_array($where)) {
			foreach ($where as $name_fields => $value_of_fields) {
				$get_where = "$get_where $name_fields = '$value_of_fields' AND ";
			}

			// re set where
			$this->where = rtrim($get_where, ' AND ');
		}

		$getData = $this->db->query("SELECT * FROM $table $this->where $this->like $this->orderby $this->limit");

		if ($getData !== FALSE) {
			return $getData;
		} else {
			return FALSE;
		}
	}

	public function update($table, $data, $where)
	{
		$this->db = $this->db_conn();
		$get_where = "";
		$get_datas = "";

		foreach ($where as $name_fields => $value_of_fields) {
			$get_where = "$get_where $name_fields = '$value_of_fields' AND ";
		}

		foreach ($data as $name_fields => $value_of_fields) {
			$get_datas = "$get_datas $name_fields = '$value_of_fields', ";
		}

		$this->datas = rtrim($get_datas, ', ');
		$this->where = rtrim($get_where, ' AND ');

		$execute_query = $this->db->query("UPDATE $table SET $this->datas WHERE $this->where");

		return $execute_query !== FALSE ? TRUE : FALSE;
	}

	public function insert($table, $data = NULL)
	{
		$this->db = $this->db_conn();
		$get_fields = "";
		$get_values = "";
		if ($data !== NULL) {

			foreach ($data as $name_fields => $value_of_fields) {
				$get_fields = "$get_fields, `$name_fields`";
				$get_values = "$get_values, '$value_of_fields'";
			}

			$this->fields = ltrim($get_fields, ', ');
			$this->values = ltrim($get_values, ', ');

			$execute_query = $this->db->query("INSERT INTO $table ($this->fields) VALUES ($this->values)");

			return $execute_query !== FALSE ? TRUE : FALSE;
		} else {
			return FALSE;
		}
	}
}
