<?php

if($_POST) {

	try {
	
		if(!isset($_POST['email']) || empty($_POST['email']) || !Zend_Validate::is($_POST['email'],'EmailAddress')) {
			throw new Exception('Vous devez entrer une adresse courriel valide.');	
		}
		
		Kate::requireModel('User');
		
		$User = new User();
		$users = $User->getItems(array('lower email'=>strtolower($_POST['email']),'available'=>true));
		
		if(!isset($users[0]) || !isset($users[0]['email'])) {
			throw new Exception('Il n\'y a pas de compte pour cette adresse courriel.');
		}
		
		$User->setData($users[0]);
		
		$newpwd = substr(md5(time().uniqid()),0,6);
		$User->setData(array('pwd'=>$newpwd,'tmpPwd'=>1));
		$User->save();
		
		$User->mailForget($newpwd);
		
		Gregory::redirect('/connexion.html?newpwd=1');
		
	} catch(Zend_Exception $e) {
		if(!Gregory::isAJAX()) $this->addError('Il s\'est produit une erreur',500,$e);
		else Gregory::JSON(array('success'=>false, 'error'=>'Il s\'est produit une erreur'));
		
	} catch(Exception $e) {
		
		if(!Gregory::isAJAX()) $this->addError($e->getMessage(),$e->getCode(),$e);
		else Gregory::JSON(array('success'=>false, 'error'=>$e->getMessage()));
		
	}

}


?><h2>Mot de passe oublié</h2>

<form action="/connexion/mot-de-passe-oublie.html" class="forgot" method="post">
    
    <?php if($this->hasErrors()) { ?>
    <div class="error"><?=$this->displayErrors()?></div>
    <?php } ?>

	<p>Veuillez entrer l'adresse courriel de votre compte et nous vous enverrons un lien qui vous permet de définir un nouveau mot de passe.</p>
	
    <div class="spacer-small"></div>
    
    <div class="field">
    	<label>Courriel :</label>
        <input type="text" name="email" class="text" />
        <div class="clear"></div>
    </div>
    
    <p class="field submit">
    	<button type="submit">Envoyer</button>
    </p>
</form>