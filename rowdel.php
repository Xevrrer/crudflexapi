<?php
include_once 'config/headers.php';
include_once 'library/jwt.php';
include_once 'config/database.php';

$database = new Database();
$conn = $database->Connect();

$data = json_decode(file_get_contents("php://input"));

if(!$data){echo 'Acces denied.';exit();}

$creator = new JWT;
$tokenData = $creator->decodeToken($data->token);

if(!$tokenData){
	echo json_encode(array("message" => "Token expired or signature is incorrect."));
	exit();
}


if(!$tokenData['admin']){
	echo json_encode(array("blocked" => 'Only admin have this permission.'));
	exit(http_response_code(404));
}


$stmt = $conn->prepare('UPDATE products SET deleted=1 WHERE id_product =?');
$stmt->bind_param("d" ,$data->id);
$stmt->execute();

http_response_code(200);
echo json_encode(array("message" => 'row was deleted correctly'));

?>