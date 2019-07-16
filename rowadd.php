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

/*
if(!$tokenData['admin'){
	echo json_encode(array("blocked" => 'Only admin have this permission.'));
	exit(http_response_code(404));
}*/



$stmt = $conn->prepare('INSERT INTO `products` () VALUES()');
$stmt->execute();

http_response_code(200);
echo json_encode(array("message" => 'row was added correctly.'));

?>