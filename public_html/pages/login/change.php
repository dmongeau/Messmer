<?php

if(!$this->auth->isLogged()) Gregory::redirect('/connexion.html');

if($_POST) {

	try {
		
		$data = $_POST;
		
		if(!isset($data['pwd']) || !isset($data['pwd2']) || empty($data['pwd']) || empty($data['pwd2'])) {
			Gregory::get()->addError('Vous devez entrer un mot de passe');
		} else if($data['pwd'] != $data['pwd2']) {
			Gregory::get()->addError('Vous devez entrer le même mot de passe dans la confirmation');
		}
		
		if(isset($data['pwd']) && !empty($data['pwd']) && strlen($data['pwd']) < 6) {
			Gregory::get()->addError('Votre mot de passe doit contenir un minimum de 6 caractères');
		}
		
		Kate::requireModel('User');
		
		$User = new User($this->auth->getIdentity()->uid);
		$User->setData(array('pwd'=>$data['pwd'],'tmpPwd'=>0));
		$User->save();
		
		if(isset($_REQUEST['next']) && !empty($_REQUEST['next'])) Gregory::redirect($_REQUEST['next']);
		else Gregory::redirect('/accueil.html');
		
	} catch(Zend_Exception $e) {
		if(!Gregory::isAJAX()) $this->addError('Il s\'est produit une erreur',500,$e);
		else Gregory::JSON(array('success'=>false, 'error'=>'Il s\'est produit une erreur'));
		
	} catch(Exception $e) {
		
		if(!Gregory::isAJAX()) $this->addError($e->getMessage(),$e->getCode(),$e);
		else Gregory::JSON(array('success'=>false, 'error'=>$e->getMessage()));
		
	}

}


?><h2>Changement de mot de passe</h2>

<form action="/connexion/changement-mot-de-passe.html?next=<?=rawurlencode(Bob::x('ne',$_REQUEST,'next'))?>" class="forgot" method="post">
    
    <?php if($this->hasErrors()) { ?>
    <div class="error"><?=$this->displayErrors()?></div>
    <?php } ?>

	<p>Veuillez choisir un nouveau mot de passe</p>
	
    <div class="spacer-small"></div>
    
    <div class="field">
    	<label>Nouveau mot de passe :</label>
        <input type="password" name="pwd" class="text" />
        <div class="clear"></div>
    </div>
    
    <div class="field">
    	<label>Confirmer votre mot de passe :</label>
        <input type="password" name="pwd2" class="text" />
        <div class="clear"></div>
    </div>
    
    <p class="field submit">
    	<button type="submit">Enregistrer</button>
    </p>
</form>