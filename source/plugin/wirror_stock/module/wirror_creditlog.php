<?php 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


$uid = $_GET['uid'];

$ishowcreatelog = false; 


if(!$uid || $uid == $_G['uid']){

		$zjdata  = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($_G['uid']);
		
		$logdata  = C::t('#wirror_stock#wirror_stocklog')->fetch_by_uid($_G['uid']);
		
		$ocdCount = count($logdata);
		for($i=0;$i<$ocdCount;$i++){
			$logdata[$i]['createtime']  =  date('Y-m-d H:i:s',$logdata[$i]['createtime']);
			$username = $logdata[$i]['username'];
		}
}else{
	
	    $ishowcreatelog = true;
	    
		$zjdata  = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($uid);
		
		$logdata  = C::t('#wirror_stock#wirror_stocklog')->fetch_byls_uid($uid);
		
		
		$ocdCount = count($logdata);
		for($i=0;$i<$ocdCount;$i++){
			$logdata[$i]['createtime']  =  date('Y-m-d H:i:s',$logdata[$i]['createtime']);
			$username = $logdata[$i]['username'];
		}
		
		$wirror_group = unserialize($setContent['wirror_group']);
		
		if(time()>1448640000){
			//return;
		}
		
		if(!in_array($_G['groupid'],$wirror_group)){
			
			$existdata = C::t('#wirror_stock#wirror_lookstock')->fetch_by_uid($_G['uid']);
			
			if($existdata['count']>=$setContent['wirror_lookcount']){
				
				showmessage('免费查看别人股票的次数已满，请购买','plugin.php?id=wirror_stock', "",array('alert'=>'error'));
				
			}
	
			
			if(!$existdata){
			
				$lookstock = array(
					'uid'=>$_G['uid'],
					'count'=>1,
				);
				
				C::t('#wirror_stock#wirror_lookstock')->insert($lookstock);
			}else{
				
				$tmpcount = $existdata['count']+1;
				
				C::t('#wirror_stock#wirror_lookstock')->update_by_uid($_G['uid'],$tmpcount);
			}
		
	}	
}

include template('wirror_stock:wirror_stock_creditlog');
?>