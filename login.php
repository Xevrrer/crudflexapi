<?php
include_once 'config/headers.php';
include_once 'library/jwt.php';
include_once 'config/database.php';

$database = new Database();
$conn = $database->Connect();

$data = json_decode(file_get_contents("php://input"));
//$data = file_get_contents("php://input");

if(!$data){echo 'Acces denied.';exit();}


$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $data->login);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();



if($result->num_rows === 0){
	http_response_code(200);
	echo json_encode(array("message" => "user not found."));
}



else if(password_verify($data->password,$row["password"])){
	
	$creator = new JWT;
	$data = array('user'=> $data->login,'admin'=> $row['owner']);
	$newToken = $creator->encodeToken($data);
	
	http_response_code(200);
	echo json_encode(array("message" => "logged in successfully",
						   "token" => $newToken,
						   "login" => $row['username'],
						   "admin" => $row['owner']
						   ));
}

else {
	http_response_code(200);
	echo json_encode(array("message" => "wrong password or username"));
}






?>