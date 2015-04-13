<?php

namespace MiniFreezer;

use \SimpleHttpClient\SimpleHttpClient;
use \SimpleHttpClient\Context;
use \MiniFreezer\MiniFreezer;

class CouchDB
{
	public function __construct($options,$context = null){
		$this->database = $options['database'];
		$this->http = new SimpleHttpClient($options);
		$this->context = empty($context) ? new Context($options) : $context;
	}

	public function fetch($id){
		$url = '/'.$this->database.'/'.urlencode($id);
		$this->context->get($url);
		return MiniFreezer::cast($this->fetchResult()['body']);
	}

	public function storeMany(array $objs,callable $cb = null){
		$url = '/'.$this->database.'/_bulk_docs';
		$this->context->post($url, json_encode(array('docs'=>array($objs))));
		return $this->fetchResult();
	}

	public function fetchResult(){
		if(!empty($cb)){
			$this->context->setCallback($cb);
			$this->context->dispatch();
		}
		else{
			$result = $this->context->fetch();
			$buffers = $this->context->getBuffers(function($doc){
				return explode("\r\n\r\n",$doc,2);
			});
			return ['headers'=>$buffers[1][0],'body'=>$buffers[1][1]];
		}
	}

	public function store($obj,callable $cb = null){
		$url = '/'.$this->database.'/_bulk_docs';
		$this->context->post($url, json_encode(array('docs'=>array($obj))));
		return $this->fetchResult();
	}
}
