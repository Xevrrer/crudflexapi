<?php
class JWT{
 
   
    private $secretKey = 'cBM=+t)\!TV@HZ,\dahQ7_(=c{}/rM^9R]$żźćC3FXB#fvR&Y7F5qWuX5c@;7%ndT4[WMS"UX?>K\F3?sD26*ADYJ${9SP5`nct(3(J7tHe{&DKnM[Hg4U!A!Ar])TT=m(Rs$Bh4Tyy#rzcn@F{c2KPy$"c(c87k%[-]J>S`?MwN_^5Cu[252G;<"@xdS%.]D5Y/>&RDHer\,a^j>az(YG(//RYTZedW~:M-=wu,*mzDuzM%E`5$EsHb:;V)~CN;';
	
		
	public $head;
	public $payload;
	public $token;
	public $signature;
	
    
    public function encodeToken($payload){
 
		$this->head = base64_encode('{"alg": "HS256","typ": "JWT"}');
		$this->payload = base64_encode(json_encode($payload));

        $this->token = $this->head.'.'.$this->payload;
		$this->signature = hash_hmac('sha256',$this->token,$this->secretKey);
		
		return $this->token.'.'.$this->signature;
		
    }
	
	
	public $tokenRaw;
	
	
	public function decodeToken($token){
 
	$this->tokenRaw = explode('.', $token);
	
	if(hash_hmac('sha256',$this->tokenRaw[0].'.'.$this->tokenRaw[1],$this->secretKey) === $this->tokenRaw[2]){
		
		return json_decode(base64_decode($this->tokenRaw[1]),true);
	}
	
	else {
		
		return false;
	}
	
    }
	
	
}
/*
$creator = new JWT;
$data = array('user'=> 'szakal','id' =>22);

$newToken = $creator->encodeToken($data);
$newData = $creator->decodeToken($newToken);

if($newData){
	echo 'user id is '.$newData['id'].' is admin: '.$newData['user'];
}




$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);


$x = new JWT;
echo $x->encodeToken($arr);
*/

?>