<?php
header('Content-Type: application/json');

header('Access-Control-Allow-Origin; *');

// Add  one more meethod (While using post)
header('Access-Control-Allow-Methods: POST');

header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

/* [ Acess-Control-Allow-Headers ]=> Allow headers  */

/* [ Content-Type ]=> Contents type  */

/* [ Acess-Control-Allow-Methods ]=> Allow method  */

/* [ Authorization ]=> Page Authorize  */

/* [ X-Requested-With ]=> Comming value trough  ajax   */


$data=json_decode(file_get_contents("php://input"), true);


//return Associave array (if true)

$name=$data['sname'];
$class=$data['sclass'];
$dep=$data['sdepartment'];
$roll=$data['roll'];


include 'config.php';

$sql="Insert into student(name,class,department,roll) values('{$name}','{$class}','{$dep}','{$roll}')";


if(mysqli_query($conn,$sql)){
	echo json_encode(array('message'=>'Student Record Found','status'=>true));
}else{
	echo json_encode(array('message'=>'Record Not Inserted','status'=>false));
}

?>