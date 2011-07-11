<?php


if($_POST) {
	
	
	try {
		
		Kate::requireModel('User');
		
		$data = $_POST;
		$data['published'] = 1;
		
		$User = new User();
		$User->setData($data);
		$User->validate();
		$User->save();
		
		if(isset($_FILES['photo']['size']) && (int)$_FILES['photo']['size'] > 0) {
			Kate::requireModel('Photo');
			try {
				$Photo = Photo::addPhoto($_FILES['photo']);
			
				$User->setData(array('pid' => $Photo->getPrimary()));
				$User->save();
			} catch(Exception $e) {
				$this->addError($e->getMessage(),$e->getCode(),$e);
			}
		}
		
		$user = $User->fetch();
		
		$User->mailRegister($data['pwd']);
		
		$this->auth->login($user['email'],$user['pwd'],true);
		
		if(!Gregory::isAJAX()) {
			if(isset($_REQUEST['next']) && !empty($_REQUEST['next'])) Gregory::redirect($_REQUEST['next']);
			else {
				Gregory::redirect('/membres/'.$user['username'].'?register=1');
			}
		} else {
			Gregory::JSON(array('success'=>true,'user'=>$user));
		}
		
	} catch(Zend_Exception $e) {
		if(!Gregory::isAJAX()) $this->addError('Il s\'est produit une erreur');
		else Gregory::JSON(array('success'=>false, 'error'=>'Il s\'est produit une erreur'));
		
	} catch(Exception $e) {
		if(Gregory::isAJAX()) Gregory::JSON(array('success'=>false, 'error'=>$e->getMessage()));
		
	}
	
	
}

?>
<form action="/inscription.html?next=<?=rawurlencode(Bob::x('ne',$_REQUEST,'next'))?>" class="login" method="post">
    <h3>Inscription</h3>
    
    <?php if($this->hasErrors()) { ?>
    <div class="error">
    <p>Votre formulaire contient des erreurs:</p>
	<?=$this->displayErrors(true,array('alwaysList'=>true))?>
    </div>
    <?php } ?>
    
    <div class="field">
    	<label>Courriel :</label>
        <input type="text" name="email" class="text" value="<?=Bob::x('ne',$_POST,'email')?>" />
        <div class="clear"></div>
    </div>
	
    <div class="field">
    	<label>Nom d'utilisateur :</label>
        <input type="text" name="username" class="text" value="<?=Bob::x('ne',$_POST,'username')?>" />
        <div class="clear"></div>
    </div>
	
    <div class="field">
    	<label>Mot de passe :</label>
        <input type="password" name="pwd" class="text" value="<?=Bob::x('ne',$_POST,'pwd')?>" />
        <div class="clear"></div>
    </div>
	
    <div class="field">
    	<label>Confirmez votre mot de passe :</label>
        <input type="password" name="pwd2" class="text" value="<?=Bob::x('ne',$_POST,'pwd2')?>" />
        <div class="clear"></div>
    </div>
    
    
    <div class="field">
        <label>Choisir une photo :</label>
        <input type="file" name="photo" />
        <div class="note">Format jpeg, png, gif. Maximum 10 mo.</div>
        <div class="clear"></div>
    </div>
    
    <div class="spacer-small"></div>
    
    <p class="field">
    	<button type="submit">Inscription</button>
    </p>
</form>