<?php
namespace Framework;

if (!isset($_SESSION)) { 
  session_start(); 
}
include_once 'application.php';

header('Content-Type: text/html; charset=utf-8');

class Initializer extends Application {
	function __construct() {
		$this->loadFramework();
		$this->loadControllers();
    $this->loadModels();
		$this->loadRoutes();
	}
	
	function loadFramework() {
		$files = scandir(dirname(__FILE__));
		foreach($files as $file) {
			if ($file != '.' and $file != '..') {
				include_once dirname(__FILE__) .'/' . $file;
			}
		}
	}
	
  function loadModels() {
		if (is_dir('app/models')) {
			$files = scandir('app/models');
			foreach($files as $file) {
				if ($file != '.' and $file != '..') {
					include 'app/models/' . $file;
				}
			}
		}
	}
  
	function loadControllers() {
		if (is_dir('app/controllers')) {
			$files = scandir('app/controllers');
			foreach($files as $file) {
				if ($file != '.' and $file != '..') {
					include 'app/controllers/' . $file;
				}
			}
		}
	}
	
	function loadRoutes() {
		if (file_exists('config/routes.php')) {
			include 'config/routes.php';
		}
	}
	
	function run() {
    $path = strtok($_SERVER['REQUEST_URI'],'?');
		parent::route($_SERVER['REQUEST_METHOD'], $path);
	}
}