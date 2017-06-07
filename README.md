# SQuirrL
PHP SQL class<br>

$db = new sql();<br>
$dbconn = $db->connect(E_DATABASE_SERVER, E_DATABASE_USER, E_DATABASE_PASSWORD, EM_DATABASE_NAME);<br>
print_r($db->get_row('SELECT * FROM TABLE_NAME WHERE ID = "1"'));<br>
echo $db->get_cell('SELECT COLUMN_NAME FROM TABLE_NAME WHERE ID = "1"');<br>
echo $db->getKeyColName(TABLE_NAME,DB_NAME);<br>
echo $db->insertStuff(TABLE_NAME,array(COLOMN_NAME=>NEW_VALUE));// returns new row ID on success or false on fail
