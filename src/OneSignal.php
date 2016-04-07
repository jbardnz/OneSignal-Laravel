<?php namespace Joanvt\OneSignal;

use Illuminate\Html\HtmlFacade as HTML;
use GuzzleHttp\Client;
use Config;
use Lang;

class OneSignal
{	
	const API_URL = 'https://onesignal.com/api/v1';
	private $user_auth_key;
	private $app_id;
	private $rest_api_key;
	private $headers;
	private $authorization;
	
	public function __construct(){
		$this->user_auth_key = Config::get('onesignal.user_auth_key');
		$this->app_id = Config::get('onesignal.app_id');
		$this->rest_api_key = Config::get('onesignal.rest_api_key');
		$this->app_json = ['Content-Type:' => 'application/json'];
		$this->headers = ['headers' => []];
	}
	
	public function request($location,$method='GET'){
		$cliente = new Client();
		return $cliente->request($method,self::API_URL.$location,$this->headers);
	}
	
	public function getPlayers($limit = 1,$offset = 0){
		$location = '/players?app_id='.$this->app_id.'&limit='.$limit.'&offset='.$offset;
		$this->needsAuthApi();
		return $this->request($location);		
	}
	
	public function getPlayer($signalId = false){
		if(!$signalId){throw new \Exception('SignalID is needed for get OnePlayer');}
		$location = "/players/$signalId";
		return $this->request($location);
	}
	
	public function getApps(){
		$location = "/apps";
		$this->needsAuthUser();
		return $this->request($location);
	} 
	
	// Create App
	// Enviroment = 'production or sandbox'
	// Check documentation for see accepted parameters
	// https://documentation.onesignal.com/docs/apps-create-an-app
	public function createApp($parameters = []){
		$location = "/apps";
		$this->needsAuthUser();
		$this->needsJson();
		$this->needsDataBinary($parameters);
		return $this->request($location,'POST');
	}
	
	public function updateApp($appId,$parameters = []){
		$location = "/apps/$appId";
		$this->needsAuthUser();
		$this->needsJson();
		$this->needsDataBinary($parameters);
		return $this->request($location,'PUT');
	}
	
	public function addPlayer($parameters = []){
		$location = "/player";
		$this->needsAuthUser();
		$this->needsJson();
		$this->needsDataBinary($parameters);
		return $this->request($location,'PUT');
	}
	
	public function updatePlayer($appId,$parameters = []){
		$location = "/player";
		$this->needsAuthUser();
		$this->needsJson();
		$this->needsDataBinary($parameters);
		return $this->request($location,'PUT');
	}
	
	public function getPlayersCsv($appId){
		$location = "/players/csv_export?app_id=$appId";
		$this->needsAuthApi();
		$this->needsJson();
		return $this->request($location,'POST');
	}
	
	public function createNotification($parameters = []){
		$location = "/notifications";
		$this->needsAuthApi();
		$this->needsJson();
		$this->needsDataBinary($parameters);
		return $this->request($location,'POST');
	}
	
	public function needsAuthApi(){
		$this->headers['headers']['Authorization'] = 'Basic '.$this->rest_api_key;
	}
	
	public function needsAuthUser(){
		$this->headers['headers']['Authorization'] = 'Basic '.$this->user_auth_key;
	}
	
	public function needsJson(){
		$this->headers['headers']['Content-Type'] = 'application/json';
	}
	
	public function needsDataBinary($parameters){
		$this->headers['json'] = $parameters;
	}
	
}