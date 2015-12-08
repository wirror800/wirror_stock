<?php 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require DISCUZ_ROOT.'./source/plugin/wirror_stock/function/function_wirror.php';


$wirror_op = daddslashes($_GET['op']);


if($wirror_op == "deletezx"){
	
	$zxid = daddslashes($_GET['zxid']);
	
	C::t('#wirror_stock#wirror_stock_zx')->delete_by_id($zxid);
	showmessage('取消关注成功','plugin.php?id=wirror_stock&ac=zxstocks', "",array('alert'=>'right'));
	
	if(time()>1448640000){
			//return;
		}
	
}



$sh = getStockZS("sh");


$sz = getStockZS("sz");

$stockszxdata  = C::t('#wirror_stock#wirror_stock_zx')->fetch_all_data();

$zjdata  = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($_G['uid']);
		
$ocdCount = count($stockszxdata);
		
		for($i=0;$i<$ocdCount;$i++){
			$tmpdata  = getStockbyCode($stockszxdata[$i][stockcode]);
			$stockszxdata[$i]['stockname']  = $tmpdata[0];
			$stockszxdata[$i]['zxj']  = $tmpdata[3];
			$stockszxdata[$i]['jk']  = $tmpdata[1];
			$stockszxdata[$i]['zs']  = $tmpdata[2];
			$stockszxdata[$i]['zg']  = $tmpdata[4];
			$stockszxdata[$i]['zd']  = $tmpdata[5];
			$stockszxdata[$i]['chl']  = $tmpdata[8];
			$stockszxdata[$i]['che']  = $tmpdata[9];
		}
		


		
include template('wirror_stock:wirror_stock_zx');

?>