<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Omdøb album</title>


<link rel="stylesheet" href="style_album.css">
<link rel="stylesheet" href="browser_reset.css">
<link rel="stylesheet" href="simplegrid.css">

<link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">


</head>

<body>

<div class="grid grid-pad">




<!-- Navigation herunder -->


<div class="nav col-1-1">

	<a href="#"><img src="img/logo.svg"></a>
	
	<ul>
		<li><a href="categorylist.php"><p>dine albums</p></a></li>
		<li id="upload_li" ><a href="upload.php"><p>upload photo</p></a></li>
	</ul>
	
	
</div>


<div class="rename_content col-1-1">

	<h1>Omdøb album navn</h1>

	<div class="echo_rename">
<?php
	
	// Når knappen 'cmd' klikkes, vil der opdateres en valgt kategori
if($cmd = filter_input(INPUT_POST, 'cmd')){
	if($cmd == 'rename_category') {
		$cid = filter_input(INPUT_POST, 'cid', FILTER_VALIDATE_INT) 
			or die('Missing/illegal cid parameter');
		
		$catname = filter_input(INPUT_POST, 'catname') 
			or die('Missing/illegal catname parameter');
		
		require_once('db_con.php');
		$sql = 'UPDATE category SET name=? WHERE category_id=?';
		$stmt = $con->prepare($sql);
		$stmt->bind_param('si', $catname, $cid);
		$stmt->execute();
		
		if($stmt->affected_rows > 0){
			echo '<h1>Du har nu omdøbt albummets navn til: '.$catname.'</h1>';
		}
		else {
			echo '<h1>Kunne ikke ændre albummets navn. Prøv igen!</h1>';
		}	
	}
}
?>

	</div>




<?php
	
	// Selecter det navn der skal opdateres
	
	if (empty($cid)){
		$cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT) 
			or die('Missing/illegal cid parameter');	
	}
	require_once('db_con.php');
	$sql = 'SELECT name FROM category WHERE category_id=?';
	$stmt = $con->prepare($sql);
	$stmt->bind_param('i', $cid);
	$stmt->execute();
	$stmt->bind_result($catname);
	while($stmt->fetch()){} 
?>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<fieldset>
    	<h1>Omdøb album</h1>
    	<input name="cid" type="hidden" value="<?=$cid?>" />
    	<input name="catname" type="text" value="<?=$catname?>" />
    	<button name="cmd" type="submit" value="rename_category">Gem nye navn</button>
	</fieldset>
</form>
	
	<div class="btn_rename">
		<a href="categorylist.php"><button>View all Categories</button></a>
	</div>


	</div>

	</div>

</body>
</html>