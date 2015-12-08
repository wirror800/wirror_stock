<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_myrepeats.php 31512 2012-09-04 07:11:08Z monkey $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_wirror_stockph extends discuz_table
{
	public function __construct() {

		$this->_table = 'wirror_stockph';
		$this->_pk    = '';

		parent::__construct();
	}
	
	public function fetch_all_data()
	{
		return DB::fetch_all('SELECT * FROM  %t     ORDER BY gcreatetime desc ', array($this->_table));
	}
	
	public function insert_data($data)
	{
		return 	DB::insert($this->_table,$data);
	}
	
	public function  fetch_by_uid($uid)
   {
		return DB::fetch_all('SELECT  *  FROM  %t  WHERE  uid=%s ORDER BY createtime desc', array($this->_table, $uid));
	}
	
	public function update_by_uid($uid,$ssl,$cw,$zsyl)
	{
		return DB::query("UPDATE  %t  SET  sslstr=".$ssl.",cw=".$cw.",zssl=".$zsyl.",updatetime=".time()."  WHERE uid=%s", array($this->_table, $uid));
	}
	
	public function getSLL(){
		
		return DB::fetch_all('SELECT  *  FROM  %t  ORDER BY sslstr desc limit 15', array($this->_table));
	}
	
	
	public function getzpx($count){
		return DB::fetch_all('SELECT  *  FROM  %t  ORDER BY sslstr desc limit '.$count, array($this->_table));
	}
	

	public function getsslstr($count){
		
		return DB::fetch_all('SELECT  *  FROM  %t  ORDER BY sslstr desc limit '.$count, array($this->_table));
	}
	
	public function getzssl($count){
		
		return DB::fetch_all('SELECT  *  FROM  %t  ORDER BY zssl desc limit  '.$count, array($this->_table));
	}


	public function  fetch_by_uiddata($uid)
   {
		return DB::fetch_first('SELECT  *  FROM  %t  WHERE  uid=%s ORDER BY createtime desc', array($this->_table, $uid));
	}
	
}

?>