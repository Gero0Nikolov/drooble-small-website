<?php 
class DB_CONTROLLER {
	private $server_name = NULL;
	private $db_name = NULL;
	private $db_user = NULL;
	private $db_pass = NULL;

	/*
	* 	__construct function.
	*  	Purpose:
	*  	- Creates DB_CONTROLLER object.
	*  	Arguments:
	*  	- $server_name: The name of the host server. Example: localhost
    * 	- $db_name: The name of the database that we are going to use. Example: drooble-website
    * 	- $db_user: The name of the database user. Example: root
    * 	- $db_pass: The password of the database. Example: pass_5869
	 */
	function __construct(
			$server_name,
			$db_name, 
			$db_user, 
			$db_pass
		){
		$this->server_name = $server_name;
		$this->db_name = $db_name;
		$this->db_user = $db_user;
		$this->db_pass = $db_pass;
	}

	/*
	* 	__destruct function.
	*  	Purpose:
	*  	- Unsets the $GLOBALS.
	 */
	function __destruct() {
    	unset( $this->server_name );
    	unset( $this->db_name );
    	unset( $this->db_user );
    	unset( $this->db_pass );
    }

    /*
  	* 	Connect to database function.
  	*  	Purpose:
  	*  	- Connects to the database and returns the connection bridge.
  	 */
    function connect_to_database() {
  		// Set database variables
  		$server_name = $this->server_name;
  		$db_user = $this->db_user;
  		$db_pass = $this->db_pass;
  		$db_name = $this->db_name;

  		// Connect to the database
  		$connection_ = mysqli_connect( $server_name, $db_user, $db_pass, $db_name );
		if ( $connection_->connect_error ) { die("Fatal connection pronlem: " . $conn->connect_error); }

		return $connection_;
  	}

  	/*
  	*	Create Table function.
  	*	Purpose:
  	*	- Creates a new table into the database of the user.
  	*	Arguments:
  	*	- $table_name: This is the name of the new table - STRING.
  	*	- $table_columns: Those are the columns of the table.
  	*	 - The argument should be sent as array from keys & values where the KEY is the name of the column and the VALUE is the type of the column.
  	*	 - Example: $table_columns = array( "column" => "INT", "column_2" => "LONGTEXT" );
  	 */
  	function create_table( $table_name, $table_columns ) {
  		$response = 0;
  		if ( !empty( $table_name ) && !empty( $table_columns ) ) {
  			$table_name = $this->sanitize_string( $table_name );
  			$table_columns = $this->sanitize_array( $table_columns );
	  		$connection_ = $this->connect_to_database();
	  		$sql_ = "CREATE TABLE $table_name ( id INT NOT NULL AUTO_INCREMENT,";
	  		foreach ( $table_columns as $key => $value ) {
	  			$sql_ .= $key ." ". $value .",";
	  		}
	  		$sql_ .= "PRIMARY KEY (id) )";
	  		if ( $connection_->query( $sql_ ) === TRUE ) { $response = 1; }
	  		else { $response = $connection_->error; }
	  		$connection_->close();
	  	}

	  	return $response;
  	}

  	/*
  	*	Insert To function.
  	*	Purpose:
  	*	- Inserts new rows into a specific table with specific columns & values.
  	*	Values:
  	*	- $table_name: This is the name of the specified table - STRING.
  	*	- $cols_vals: Those are the columns and the specific values for each of the columns.
  	* 	 - The argument should be sent as array from keys & values where the KEY is the name of the column and the VALUE is the value of the column.
  	* 	  - Example: $cols_vals = array( "name" => "Pesho", "nickname" => "will.i.am.not" );
  	 */
  	function insert_to( $table_name, $cols_vals ) {
  		$response = 0;
  		if ( !empty( $table_name ) && !empty( $cols_vals ) ) {
  			$table_name = $this->sanitize_string( $table_name );
  			$cols_vals = $this->sanitize_array( $cols_vals );
  			$count_columns = count( $cols_vals );

	  		$connection_ = $this->connect_to_database();
  			$sql_ = "INSERT INTO $table_name (";
  			$count_ = 0;
 			foreach ( $cols_vals as $key => $value ) {
 				$sql_ .= $key;
 				if ( $count_ < $count_columns - 1 ) { $sql_ .= ","; }
 				$count_ += 1;
 			}
 			$sql_ .= ") VALUES (";
 			$count_ = 0;
 			foreach ( $cols_vals as $key => $value ) {
 				$sql_ .= "'$value'";
 				if ( $count_ < $count_columns - 1 ) { $sql_ .= ","; }
 				$count_ += 1;
 			}
 			$sql_ .= ")";
 			if ( $connection_->query( $sql_ ) === TRUE ) { $response = 1; }
	  		else { $response = $connection_->error; }
  			$connection_->close();
  		}

  		return $response;
  	}

  	/*
  	*	Select From function.
  	*	Purpose:
  	*	- Select rows from table.
  	*	Arguments:
  	*	- $table_name: The name of the table,
  	*	- $columns_to_select: The columns which we are going to select. Example: $columns_to_select = array( "name", "email", "password" );
  	*	- $clause: The WHERE clause in our query. Example: $clauses = "id=1 AND name='Pesho'";
  	 */
  	function select_from( $table_name, $columns_to_select, $clause = "", $order = "ASC", $order_by = "id", $limit = -1, $offset = 0 ) {
  		$response = 0;
  		if ( !empty( $table_name ) && !empty( $columns_to_select ) ) {
  			$count_columns = count( $columns_to_select );

  			$connection_ = $this->connect_to_database();

  			$sql_ = "SELECT ";
  			$count_ = 0;
  			foreach ( $columns_to_select as $column_ ) {
  				$sql_ .= "$column_";
  				if ( $count_ < $count_columns - 1 ) { $sql_ .= ","; }
  				$count_ += 1;
  			}

  			$sql_ .= " FROM $table_name";

  			// Add WHERE if needed
  			if ( !empty( $clause ) ) { $sql_ .= " WHERE $clause"; }

  			// Add ORDER
  			$sql_ .= " ORDER BY $order_by $order";

  			// Add LIMIT if needed
  			if ( $limit > -1 ) { $sql_ .= " LIMIT $limit "; }
  			// Add OFFSET if needed
  			if ( $offset > 0 ) { $sql_ .= " OFFSET $offset"; }
  			$catch_ = $connection_->query( $sql_ );
  			$stack = array();
	  		if ( isset( $catch_->num_rows ) > 0 ) {
	  			while ( $row_ = $catch_->fetch_assoc() ) {
		  			array_push( $stack, $row_ );
		  		}
	  		}
	  		$response = $stack;
  			$connection_->close();
  		}
  		return $response;
  	}

  	/*
  	*	Update function.
  	*	Purpose:
  	*	- $table_name: The name of the table.
  	*	- $cols_vals: Those are the columns and the specific values for each of the columns.
  	*	- $clause: The WHERE clause in our query. Example: $clauses = "id=1 AND name='Pesho'";
  	 */
  	function update_( $table_name, $cols_vals, $clause = "" ) {
  		$response = 0;
  		if ( !empty( $table_name ) && !empty( $cols_vals ) ) {
  			$table_name = $this->sanitize_string( $table_name );
  			$cols_vals = $this->sanitize_array( $cols_vals );
  			$count_columns = count( $cols_vals );
  			$clause = $this->sanitize_string( $clause );

  			$connection_ = $this->connect_to_database();

  			$sql_ = "UPDATE $table_name SET ";
  			$count_ = 0;
  			foreach ( $cols_vals as $key => $value ) {
  				$sql_ .= "$key='$value'";
  				if ( $count_ < $count_columns - 1 ) { $sql_ .= ","; }
 				$count_ += 1;
  			}
  			if ( !empty( $clause ) ) { $sql_ .= " WHERE $clause"; }
  			if ( $connection_->query( $sql_ ) === TRUE ) { $response = 1; }
	  		else { $response = $connection_->error; }

	  		$connection_->close();
  		}
  		return $response;
  	}

  	/*
  	*	Delete From function.
  	*	Purpose:
  	*	- Delete rows from table.
  	*	Arguments:
  	*	- $table_name: This is the name of the table.
  	*	- $clause: The WHERE clause in our query. Example: $clauses = "id=1 AND name='Pesho'";
  	 */
  	function delete_from( $table_name, $clause = "" ) {
  		$response = 0;
  		if ( !empty( $table_name ) ) {
  			$table_name = $this->sanitize_string( $table_name );
  			$sql_ = "DELETE FROM $table_name WHERE $clause";
  			$connection_ = $this->connect_to_database();
  			if ( $connection_->query( $sql_ ) === TRUE ) { $response = 1; }
	  		else { $response = $connection_->error; }
	  		$connection_->close();
  		}
  		return $response;
  	}

  	/*
  	*	Drop Table function.
  	*	Purpose:
  	*	- Drop table from the database.
  	*	Arguments:
  	*	- $table_name: The name of the table.
  	 */
  	function drop_table( $table_name ) {
  		$response = 0;
  		if ( !empty( $table_name ) ) {
  			$sql_ = "DROP TABLE $table_name";
  			$connection_ = $this->connect_to_database();
  			if ( $connection_->query( $sql_ ) === TRUE ) { $response = 1; }
	  		else { $response = $connection_->error; }
	  		$connection_->close();
  		}
  		return $response;
  	}

  	/*
  	* 	Sanitize string function.
  	*  	Purpose:
  	*  	- Sanitizes the user input and returns safe content for the database.
  	*  	Arguments:
  	*  	- $string: This is the string that we are going to sanitize.
  	 */
  	function sanitize_string( $string_ ) {
  		$string_ = str_replace( "'", "&#39", trim( htmlentities( $string_ ) ) );
  		return $string_;
  	}

  	/*
  	*	Sanitize array function.
  	*	Purpose:
  	*	- Sanitizes the inputed array.
  	*	Arguments:
  	*	- $array_: This is the inputed array.
  	 */
  	function sanitize_array( $array_ ) {
  		$sanitized_ = array();
  		foreach ( $array_ as $key => $value ) {
  			if ( !empty( $value ) ) {
  				$key = $this->sanitize_string( $key );
  				$value = $this->sanitize_string( $value );
  				$sanitized_[ $key ] = $value;
  			}
  		}
  		return $sanitized_;
  	}
};
?>