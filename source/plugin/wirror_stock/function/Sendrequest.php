<?php
class Sendrequest {
	
	 public function SetPost($url){
	 	
	 		
	 		$ch = curl_init();
	 		curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
           
            curl_setopt ($ch, CURLOPT_HTTPHEADER,$header);
         
            curl_setopt($ch, CURLOPT_TIMEOUT,1000);
         
            $returndata = curl_exec($ch);
            
            curl_close($ch);
           
            return $returndata;
	 }
	
	
}

?>
