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

	public function fetch($id, callable $cb = null){
		$url = '/'.$this->database.'/'.urlencode($id);
		$this->context->get($url);
		return MiniFreezer::cast($this->fetchResult($cb));
	}

	private function parseHeaders($headers){
		$return = array();
		$head = explode(' ',array_shift($headers),3);
		$return['_protocol'] = $head[0];
		$return['_code'] = $head[1];
		$return['_message'] = $head[2];
		foreach($headers as $header){
			list($key,$value) = explode(':',$header);
			$return[strtolower(trim($key))] = strtolower(trim($value));
		}
		return $return;
	}

	public function getBuffers(){
		$buffers = $this->context->getBuffers();
		$return = array();
		foreach($buffers as &$buffer){
			list($headers,$json) = explode("\r\n\r\n",$buffer);
			$return['headers'] = $this->parseHeaders(explode("\r\n",$headers));
			$body = json_decode($json,true);
			$return['body'] = empty($body) ? $json : $body;
		}
		return $return;
	}

	public function fetchResult(callable $cb = null){
		if(!empty($cb)){
			$this->context->setCallback($cb);
			$this->context->dispatch();
		}
		else{
			$result = $this->context->fetch();
			return $this->getBuffers();
		}
	}

	public function store($obj,callable $cb = null){
		$url = '/'.$this->database.'/_bulk_docs';
		$this->context->post($url, json_encode(array('docs'=>array($obj))));
		return $this->fetchResult($cb);
	}

	public function storeMany(array $objs, callable $cb = null){
		$url = '/'.$this->database.'/_bulk_docs';
		$this->context->post($url, json_encode(array('docs'=>$objs)));
		return $this->fetchResult($cb);
	}
}
