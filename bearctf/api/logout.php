<?php
	$redirect = '';
	if($_POST['redirect'] !== 'none'){
		$redirect = ",\"redirect\":\"". $_POST['redirect'] . "\"";
	}
	if(!isset($_COOKIE['username']) && !isset($_COOKIE['id'])){
		die('{"success":"nope","reason":"User already logged out."' . $redirect . '}');
	}else{
		setcookie('username','',time() - 100,'/');
		setcookie('id','',time() - 100,'/');
		echo '{"success":"yes","response":"User successfully logged out!"' . $redirect . '}';
	}
?>