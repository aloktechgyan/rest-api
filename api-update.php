<?php
header('Content-Type: application/json');

header('Access-Control-Allow-Origin; *');

// Add  one more meethod (While using post)
header('Access-Control-Allow-Methods: PUT');

header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

/* [ Acess-Control-Allow-Headers ]=> Allow headers  */

/* [ Content-Type ]=> Contents type  */

/* [ Acess-Control-Allow-Methods ]=> Allow method  */

/* [ Authorization ]=> Page Authorize  */

/* [ X-Requested-With ]=> Comming value trough  ajax   */


$data=json_decode(file_get_contents("php://input"), true);


//return Associave array (if true)

$id=$data['sid'];
$name=$data['sname'];
$class=$data['sclass'];
$dep=$data['sdepartment'];
$roll=$data['roll'];


include 'config.php';

$sql="update student set name='{$name}', class='{$class}', department='{$dep}', roll='{$roll}' where id={$id}";

if(mysqli_query($conn,$sql)){
	echo json_encode(array('message'=>'Update Student Record Successfully','status'=>true));
}else{
	echo json_encode(array('message'=>'Error to Update Record','status'=>false));
}

?>