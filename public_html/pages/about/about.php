<?php


$route = $this->getRoute();
$action = isset($route['params']['action']) ? $route['params']['action']:'about';

switch($action) {
	
	
	case 'contact':
	
		include dirname(__FILE__).'/public/contact.php';
	
	break;
	
	
	case 'conditions':
		
		include dirname(__FILE__).'/public/conditions.php';
	
	break;
	
	
	case 'confidentialite':
		
		include dirname(__FILE__).'/public/privacy.php';
	
	break;
	
	default:
		
		include dirname(__FILE__).'/public/about.php';
		
	break;
	
	
}
