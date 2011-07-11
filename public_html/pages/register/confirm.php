<?php

try {


	if(!isset($_REQUEST['key']) || empty($_REQUEST['key']) || !isset($_REQUEST['t']) || empty($_REQUEST['t'])) {
		Gregory::redirect('/inscription.html');
	}
	
	Kate::requireModel('User');
	
	$User = new User();
	$users = $User->getItems(array('confirmKey'=>$_REQUEST['key']));
	
	if(!$users || !sizeof($users) || sizeof($users) > 1 || md5(strtotime($users[0]['dateadded'])) != $_REQUEST['t']) {
		throw new Exception('Confirmation invalide');
	}
	
	$User->setData($users[0]);
	$User->setData(array(
		'confirmKey'=>'',
		'published'=>1
	));
	$User->save();
	
	
	if(isset($_REQUEST['next']) && !empty($_REQUEST['next'])) Gregory::redirect($_REQUEST['next']);
	else Gregory::redirect('/compte/');

	
} catch(Exception $e) {
	$this->catchError($e);
	Gregory::redirect('/inscription.html');
	
}

