<?php
	if(!isset($_COOKIE['canViewFlag'])){
		setcookie('canViewFlag',0,time() + 5 * 86400);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>BearCTF -- Dessert</title>
		<link rel="stylesheet" type="text/css" href="../../../css/home.css">
	</head>
	<body>
		<div id="navBar">
			<h1>Flag Viewer</h1>
		</div>
		<div id="main">
			<div id="notice_container" class="container top">
				<div id="notice_header" class="header">
					<h3>&gt;Flag Status</h3>
				</div>
				<div id="notice_body" class="bod">
					<?php
						if($_COOKIE['canViewFlag'] === '1'){
							echo '<p>The flag is {cookie_monster_would_be_proud}</p>';
						}else{
							echo '<p>You do not have permission to view the flag.</p>';
						}
					 ?>
				</div>
			</div>
		</div>
	</body>
</html>
