<?php



return array(

	'/' => 'index.php',
	'/accueil.html' => 'index.php',
	
	/*
	 *
	 * À propos
	 *
	 */
	'/a-propos/' => 'about/about.php',
	'/a-propos/:action.html' => 'about/about.php',
	
	/*
	 *
	 * Inscription
	 *
	 */
	'/inscription.html' => 'register/register.php',
	'/inscription/confirmation.html' => 'register/confirm.php',
	
	
	
	/*
	 *
	 * Login
	 *
	 */
	'/connexion.html' => 'login/login.php',
	'/connexion/mot-de-passe-oublie.html' => 'login/forgot.php',
	'/connexion/changement-mot-de-passe.html' => 'login/change.php',
	'/deconnexion.html' => 'login/logout.php',
	
);