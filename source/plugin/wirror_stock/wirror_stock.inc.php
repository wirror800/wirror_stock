<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}



	$setContent =  $_G['cache']['plugin']['wirror_stock'];

	$modarray = array('index', 'market', 'zxstocks', 'stockgz', 'buystock', 'zjchange', 'mystock', 'creditlog', 'sellstock', 'detail');
	$mod = !in_array($_GET['ac'], $modarray) ? 'index' : $_GET['ac'];



	if($mod != 'index'){
		if(!$_G['uid']) {
			showmessage('not_loggedin', NULL, array(), array('login' => 1));
		}
		
	}

	$zjdata  = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($_G['uid']);
	
	
	

	require DISCUZ_ROOT.'./source/plugin/wirror_stock/module/wirror_'.$mod.'.php';
	
?>