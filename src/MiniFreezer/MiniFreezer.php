<?php

namespace MiniFreezer;

use \SimpleHttpClient\SimpleHttpClient;
use \SimpleHttpClient\Context;

abstract class MiniFreezer implements \JsonSerializable
{
	public $_id;
	public $_rev;
	public $state;
	public $hash;
	public $class;
	public $_deleted;

	public static function cast($json){
		$json = (object)json_decode($json,true);
		$className = $json->class;
		$ser = serialize($json);
		return unserialize(str_replace('O:8:"stdClass"','O:'.strlen($className).':"'.$className.'"',$ser));
	}

	public function jsonSerialize(){
		$ret = array('_id'   => empty($this->_id) ? $this->generateUUID() : $this->_id);
		if(!empty($this->_rev)){
			$ret['_rev'] = $this->_rev;
		}
		$ret['class'] = get_class($this);
		$ret['state'] = $this->getState();
		if(!empty($this->_deleted)){
			$ret['_deleted'] = true;
		}
		$ret['hash'] = sha1(json_encode($ret));
		return $ret;
	}

	public function delete(){
		$this->_deleted = true;
	}

	public function getState(){
		return $this->state;
	}
	private function generateUUID(){
		return sprintf(
			'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
			mt_rand(0, 0x0fff) | 0x4000,
			mt_rand(0, 0x3fff) | 0x8000,
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
	}

	public function __set($k,$v){
		$this->state[$k] = $v;
	}

	public function __get($k){
		return $this->state[$k];
	}
}

