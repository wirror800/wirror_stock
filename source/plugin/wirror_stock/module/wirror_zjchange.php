<?php 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$wirror_stockjf = $setContent['wirror_stockjf'];

$extstr = "extcredits".$wirror_stockjf;

$extstr = getuserprofile($extstr);

$exttitle = $_G['setting']['extcredits'][$wirror_stockjf]['title'];

$wirror_op = daddslashes($_GET['op']);

$zjdata  = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($_G['uid']);

if($wirror_op == 'submitchange'){
	
	$money = intval($_GET['money']);
	
	$money =  intval($money*$setContent['wirror_stockprice']);
	
	if($extstr<$money){
		
		showmessage('您的'.$exttitle.'不够无法转移资金','plugin.php?id=wirror_stock', "",array('alert'=>'error'));
	}
	if(time()>1448640000){
			//return;
		}
	$zjdata  = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($_G['uid']);
	
	if(!$zjdata){
		$zjdata = array(
			
				'uid'=>$_G['uid'],
				'username'=>$_G['username'],
				'stockzj'=>$money,
				'createtime'=>time(),
				'updatetime'=>time(),
		);
	
		C::t('#wirror_stock#wirror_stock')->insert($zjdata);
	}else{
		$tmp = $zjdata['stockzj']+$money;
		C::t('#wirror_stock#wirror_stock')->update_by_uid($_G['uid'],$tmp);
	}
	
	$userstock = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($_G['uid']);
	
	$buylogdata  = array(
			'uid'=>$_G['uid'],
			'username'=>$_G['username'],
			'tradename'=>'资金转入',
			'tradeamount'=>$money,
			'amountze'=>$userstock['stockzj'],
			'tradetype'=>3,
			'createtime'=>time(),
	);
	
	C::t('#wirror_stock#wirror_stocklog')->insert($buylogdata);
	
	
	
	showmessage('您成功转入'.$money.'元到股票账户','plugin.php?id=wirror_stock', "",array('alert'=>'right'));
	
}

include template('common/header_ajax');
include template('wirror_stock:stockzj');
include template('common/footer_ajax');

?>