<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin; *');

/* --------BY Post Method ----- 
   $data=json_decode(file_get_contents("php://input"), true);
   $search_value=$data['search'];
 */
// BY using Get method (from url )

   $search_value=isset($_GET['search'])?$_GET['search'] : die();

include 'config.php';

$sql="select *from student where name like '%{$search_value}%'";

$result=mysqli_query($conn,$sql) or die("SQL Query Failed");

if(mysqli_num_rows($result) > 0 ){

	$output = mysqli_fetch_all($result, MYSQLI_ASSOC);

	echo json_encode($output);

}else{
	echo json_encode(array('message'=>'No Search Found','status'=>false));
}

?>