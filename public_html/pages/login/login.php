<?php

if($this->auth->isLogged()) {
	if(isset($_REQUEST['next']) && !empty($_REQUEST['next'])) Gregory::redirect($_REQUEST['next']);
	else Gregory::redirect('/');	
}


if($_POST) {
	
	try {
		
		if(!isset($_POST['email']) || !isset($_POST['pwd']) || empty($_POST['email']) || empty($_POST['pwd'])) {
			throw new Exception('Vous devez entrer votre adresse courriel et votre mot de passe.');	
		}
		
		Kate::requireModel('User');
		
		$this->addFilter('auth.login.identity',array('User','filterIdentity'));
		$this->addAction('auth.login.valid',array('User','loggedIn'));
		
		$user = $this->auth->login(Bob::x('ne',$_POST,'email'),Bob::x('ne',$_POST,'pwd'),false);
		
		if((int)$user->tmpPwd == 1) {
			Gregory::redirect('/connexion/changement-mot-de-passe.html?next='.rawurlencode(Bob::x('ne',$_REQUEST,'next')));
		}
		
		if(!Gregory::isAJAX()) {
			if(isset($_REQUEST['next']) && !empty($_REQUEST['next'])) Gregory::redirect($_REQUEST['next']);
			else Gregory::redirect('/');
		} else {
			Gregory::JSON(array('success'=>true,'user'=>$user));
		}
		
	} catch(Zend_Exception $e) {
		
		if(!Gregory::isAJAX()) $this->addError('Il s\'est produit une erreur',500,$e);
		else Gregory::JSON(array('success'=>false, 'error'=>'Il s\'est produit une erreur'));
		
	} catch(Exception $e) {
		
		if(!Gregory::isAJAX()) $this->addError($e->getMessage(),$e->getCode(),$e);
		else Gregory::JSON(array('success'=>false, 'error'=>$e->getMessage()));
		
	}
	
}

?>
<div class="fleft" style="width:275px;">
<form action="/connexion.html?next=<?=rawurlencode(Bob::x('ne',$_REQUEST,'next'))?>" class="login" method="post">
    <h3>Connexion</h3>
    
    <?php if($this->hasErrors()) { ?>
    <div class="error"><?=$this->displayErrors()?></div>
    <?php } ?>
    
    <?php if(isset($_REQUEST['newpwd']) && (int)$_REQUEST['newpwd'] == 1) { ?>
    <div class="success">Un mot de passe temporaire a été envoyé à votre adresse courriel.</div>
    <?php } ?>
    
    <?php if(isset($_REQUEST['closed']) && (int)$_REQUEST['closed'] == 1) { ?>
    <div class="success">Votre compte est maintenant fermé.</div>
    <?php } ?>
	
    <div class="field">
    	<label>Courriel :</label>
        <input type="text" name="email" class="text" style="width:250px;" />
        <div class="clear"></div>
    </div>
	
    <div class="field">
    	<label>Mot de passe :</label>
        <input type="password" name="pwd" class="text" style="width:250px;" />
        <div class="clear"></div>
    </div>
    
    <p class="field submit">
    	<button type="submit">Connexion</button>
        <span><a href="/connexion/mot-de-passe-oublie.html" class="forgot">Mot de passe oublié</a></span>
    </p>
</form>
</div>

<div class="fleft" style="width:250px;" align="center">
	<div class="spacer"></div>
    <p>Si vous possédez un compte Facebook, utilisez-le pour vous connecter au site.</p>
    <p>
        <a href="/connexion/facebook.html" class="facebookLogin">Connectez-vous avec Facebook</a>
    </p>

</div>