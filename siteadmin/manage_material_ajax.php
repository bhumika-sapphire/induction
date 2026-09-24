<?php
include_once '../includes/startup.php';
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
$table = 'training_material_master';
 
// Table's primary key
$primaryKey = 'training_material_id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '@serial_no := @serial_no + 1 as row_number', 	'dt' => 0, 	'field' => 'row_number' ),  
    array( 'db' => '`tmm`.`material_title`', 	'dt' => 1, 	'field' => 'material_title' ),
    array( 'db' => '`c`.`chapter_name`', 	'dt' => 2, 	'field' => 'chapter_name' ),
    array( 'db' => '`t`.`topic_name`',  	'dt' => 3, 	'field' => 'topic_name' ),
	array( 'db' => '`tmm`.`material_file`', 'dt' => 4, 'formatter' => function( $d, $row ) {
				if($d != "")
				{
					return '<td><span class="glyphicon glyphicon-ok"></span></td>';
				}
				else
				{
					return '<td><span class="glyphicon glyphicon-remove"></span></td>';
				}
                },
            'field' => 'material_file' ),
	array( 'db' => '`tmm`.`training_material_id`', 'dt' => 5, 'formatter' => function( $d, $row ) {
                return '<td><a href="edit_material.php?material_id='.$d.'" ><button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</button></a></td>';},
            'field' => 'material_id' ),
	array( 'db' => '`tmm`.`training_material_id`', 'dt' => 6, 'formatter' => function( $d, $row ) {
                return '<td><a onclick="return confirm("Are you sure you want to delete this material?")" href="delete_material.php?material_id='.$row["material_id"].'"><button class="btn btn-primary"><span class="glyphicon glyphicon-remove-circle"></span> Delete</button></a></td>';},
            'field' => 'material_id' )	
);

// SQL server connection information
$sql_details = array(
    'user' => DB_USER,
    'pass' => DB_PASSWORD,
    'db'   => DB_DATABASE,
    'host' => DB_HOST
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.php' );

$joinQuery = "FROM `training_material_master` AS `tmm`, `chapter_master` AS `c`, `topic_master` AS `t`";
$extraCondition = "`t`.`topic_id`=`tmm`.`topic_id` AND `c`.`chapter_id`=`tmm`.`chapter_id` AND `t`.`topic_id`=`c`.`topic_id` ";

echo json_encode(
     SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition)
);