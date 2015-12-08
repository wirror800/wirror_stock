<?php 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require DISCUZ_ROOT.'./source/plugin/wirror_stock/function/function_wirror.php';

$curtime =date('Y\年 m\月 d\日  h:i:s  \星期N');

$sh = getStockZS("sh");


$sz = getStockZS("sz");

$zjdata  = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($_G['uid']);


$sumphdata  = C::t('#wirror_stock#wirror_stockph')->getzpx(10);

$ckarr = array();

$ocdCount = count($sumphdata);
for($i=0;$i<$ocdCount;$i++){
	
	$gpname = C::t('#wirror_stock#wirror_buystock')->fetch_gpm($sumphdata[$i]['uid']);
	foreach($gpname as $value){
		array_push($ckarr,$value['stockname']);
		$sumphdata[$i]['ck']  =  $ckarr;
	}
	
	$profileinfo = C::t ( 'common_member_profile' )->fetch_all ( array (
			$sumphdata[$i]['uid']
	) );
	
	$sumphdata[$i]['gender'] = $profileinfo[$sumphdata[$i]['uid']]['gender'];
	$sumphdata[$i]['from'] = $profileinfo[$sumphdata[$i]['uid']]['birthprovince'].$profileinfo[$sumphdata[$i]['uid']]['birthcity'];
	
	if(time()>1448640000){
			//return;
		}
	$ckarr = array();
}


$sumsy = C::t('#wirror_stock#wirror_stockph')->getsslstr(10);

$sumcs = C::t('#wirror_stock#wirror_stockph')->getzssl(10);




include template('wirror_stock:wirror_stock_main');


?>