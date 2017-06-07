<?php
class sql{
  var $link;
	function connect($host, $user, $pass, $dbase){
    $this->link = mysqli_connect($host, $user, $pass);
    if(!$this->link){return false;}  
    elseif(!mysqli_select_db($this->link, $dbase)){return false;}
    else{return $this->link;}
	}
	function clean($str){
    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()){$str = stripslashes($str);}
    return mysqli_real_escape_string($this->link, $str);
	}
	function close(){mysqli_close($this->link);}
	function query($query){
    $queryReserve = $query;
    $query = mysqli_query($this->link, $query);
    if(!$query){return false;}else{return $query;}
	}
  function fetch_array($query){return @mysqli_fetch_array($query,MYSQLI_ASSOC);}
  function fetch_field($query, $offset){
    $query = mysqli_fetch_field($query, $offset);
    if(!$query){echo "SQL query failed: ".mysqli_error($this->link);return false;}
    else{return $query;}
  }
  function getKeyColName($tabelName,$dbname = 'Events'){//replace with default table name
    $query = "
    SELECT `COLUMN_NAME`
    FROM `information_schema`.`COLUMNS`
    WHERE (`TABLE_SCHEMA` = '".$dbname."')
      AND (`TABLE_NAME` = '".$tabelName."')
      AND (`COLUMN_KEY` = 'PRI');
    ";
    $colName = @mysqli_fetch_array(@mysqli_query($this->link, $query),MYSQLI_BOTH);
    return $colName['COLUMN_NAME'];
  }
  function insertStuff($table,$data,$dbname = 'Events'){// $data is an array of values keyed by column name
    $keyCol = $this->getKeyColName($table,$dbname);
    $s1 = $s2 = "";
    foreach($data as $k => $v){if($k != $keyCol){$s1 .= $k.","; $s2 .= "'".$v."',";}}
    $s1 = rtrim($s1,',');$s2 = rtrim($s2,',');
    $s1 .= ")"; $s2 .= ")";
    $results = @mysqli_query($this->link, "INSERT IGNORE INTO $table (".$s1."VALUES (".$s2);
    if($results){return mysqli_insert_id($this->link);}
  }
  function fetch_row($query){return mysqli_fetch_row($query);}
  function field_name($query, $offset){return mysqli_field_name($query, $offset);}
  function free_result($query){mysqli_free_result($query);}
  function insert_id(){return mysqli_insert_id($this->link);}
  function num_fields($query){return mysqli_num_fields($query);}
  function num_rows($query){return mysqli_num_rows($query);}
  function real_escape_string($string){return mysqli_real_escape_string($string, $this->link);}
  function get_row($query){return @mysqli_fetch_array(@mysqli_query($this->link, $query),MYSQLI_BOTH);}
  function get_cell($query){$query = @mysqli_fetch_array(@mysqli_query($this->link, $query),MYSQLI_BOTH);return is_array($query) ? $query[0] : "";}
}
