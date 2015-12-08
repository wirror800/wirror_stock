<?php 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


$stockcode = daddslashes($_GET['code']);
		
$iscz = C::t('#wirror_stock#wirror_stock_zx')->fetch_by_uidcode($cur_uid,$stockcode);

if($iscz){
	showmessage('您已经添加该支股票到自选股','plugin.php?id=wirror_stock&ac=market', "",array('alert'=>'error'));
}
$gzdata = array(
	'uid'=>$cur_uid,
	'username'=>$cur_username,
	'stockcode'=>$stockcode,
	'createtime' =>time(),
);
C::t('#wirror_stock#wirror_stock_zx')->insert($gzdata);

showmessage('自选股设置成功','plugin.php?id=wirror_stock&ac=market');





?>