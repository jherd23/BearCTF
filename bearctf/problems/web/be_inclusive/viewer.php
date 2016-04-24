<!DOCTYPE html>
<html>
	<head>
		<title>BearCTF -- Be Inclusive</title>
		<link rel="stylesheet" type="text/css" href="../../../css/home.css">
    <script>
      function goToRandomPage(){
        window.location = 'viewer.php?file=' + parseInt((Math.random() * 4) + 1) + '.txt';
      }
    </script>
	</head>
	<body>
		<div id="navBar">
			<h1>File Viewer</h1>
		</div>
		<div id="main">
			<div id="notice_container" class="container top">
				<div id="notice_header" class="header">
					<h3>&gt;Page Viewer</h3>
				</div>
				<div id="notice_body" class="bod">
					<p>You are now viewing page <?php echo $_GET['file']; ?></p>
					<p>"<?php echo file_get_contents('./' . $_GET['file'],FILE_USE_INCLUDE_PATH); ?>"</p>
					<p>Click to view a random page:<button onclick="goToRandomPage()">Go</button></p>
				</div>
			</div>
		</div>
	</body>
</html>
