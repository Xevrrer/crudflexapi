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

$stmt = $conn->prepare("SELECT * FROM products where deleted = 0");
$stmt->execute();
$result = $stmt->get_result();

$arr = []; 
while ($row = $result->fetch_assoc()) {
	
		//array_push($arr,$row);
		$arr[$row['id_product']] = $row;
	
        
    }
http_response_code(200);
echo json_encode($arr);




?>