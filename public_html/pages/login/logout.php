<?php

try {
	
	$this->auth->logout();
	
	if(!Gregory::isAJAX()) {
		if(isset($_REQUEST['next']) && !empty($_REQUEST['next'])) Gregory::redirect($_REQUEST['next']);
		else Gregory::redirect('/accueil.html');
	} else {
		Gregory::JSON(array('success'=>true));
	}
	
} catch(Zend_Exception $e) {
	
	if(!Gregory::isAJAX()) $error = 'Il s\'est produit une erreur';
	else Gregory::JSON(array('success'=>false, 'error'=>'Il s\'est produit une erreur'));
	
} catch(Exception $e) {
	
	if(!Gregory::isAJAX()) $error = $e->getMessage();
	else Gregory::JSON(array('success'=>false, 'error'=>$e->getMessage()));
	
}

