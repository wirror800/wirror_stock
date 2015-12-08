<?php

//cronname:cron_wirror_stock
//week:
//day:
//hour:23
//minute:59

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require DISCUZ_ROOT.'./source/plugin/wirror_stock/function/function_wirror.php';

//获取所有uid
$uids = C::t('#wirror_stock#wirror_stocklog')->getUIDs();

foreach($uids as $uidvalue)
{
	
	
		$buydata = C::t('#wirror_stock#wirror_buystock')->fetch_by_uid($uidvalue['uid']);
		
		//计算总的胜算率
		$ssl = jsyycs($buydata);
		
		//计算仓位
		$cw = jscw($buydata,$uidvalue['uid']);
		
		//计算总收益率
		$zsyl = jszsyl($buydata,$uidvalue['uid']);
		
		
		$existdata = C::t('#wirror_stock#wirror_stockph')->fetch_by_uid($uidvalue['uid']);
		
		
		if(!$existdata){
		
			$insertdata = array(
				'uid'=>$uidvalue['uid'],
				'username'=>$uidvalue['username'],
				'sslstr'=>$ssl,
				'cw'=>$cw,
				'zssl'=>$zssl,
				'createtime'=>time(),
			);
			
			C::t('#wirror_stock#wirror_stockph')->insert($insertdata);
		
		}else{
			
			C::t('#wirror_stock#wirror_stockph')->update_by_uid($uidvalue['uid'],$ssl,$cw,$zsyl);
		}
		
}





?>
