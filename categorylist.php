<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dine albums</title>

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


<div class="category_content col-1-1">
	<div class="header_content">
		<ul>
			<li>
				<h1>dine albums</h1>
				<a href="createcategory.php"><button>tilføj album +</button></a>
			</li>
		</ul>
	</div>


<div class="echo_del">
<?php
	
	// Tilføj kategori
if($cmd = filter_input(INPUT_POST, 'cmd')){
	if($cmd == 'del_category') {
		$cid = filter_input(INPUT_POST, 'cid', FILTER_VALIDATE_INT) 
			or die('Missing/illegal cid parameter');
		
		require_once('db_con.php');
		$sql = 'DELETE FROM category WHERE category_id=?';
		$stmt = $con->prepare($sql);
		$stmt->bind_param('i', $cid);
		$stmt->execute();
		
		if($stmt->affected_rows > 0){
			
			echo '<h1>Kategorien blev slettet</h1>';
			
		}
		else {
			
			echo '<h1>Kunne ikke slette kategorien. Prøv igen!</h1>';
			
		}
	}
	else {
		die('Unknown cmd: '.$cmd);
	}
	

}
?>

</div>

	
	
	
	
	<ul>

		<?php

	// inkluder alt indhold fra db_con.php i denne fil - once = loader kun "en" gang.
	require_once('db_con.php');	


		// prepared statement for at kunne læse data fra en database
		$sql = 'SELECT category_id, name FROM category';
		$stmt = $con->prepare($sql);
		// $stmt->bind_param(); not needed - no placeholders.....


		// execute the statement
		$stmt->execute();
		// forberedelsen til data afhentning: prepared statement
		$stmt->bind_result($cid, $nam);

		// lykke
		while ($stmt->fetch()){
			echo '<a href="imagelist.php?categoryid='.$cid.'"><div class="categories"><li><p>' . $nam .'</p></li>'.PHP_EOL;

	?>

	<!-- Omdøb kategori -->

	<object><a href="renamecategory.php?cid=<?=$cid?>"><button class="btn_rename">Omdøb kategori</button></a></object>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<input type="hidden" name="cid" value="<?=$cid?>" />
			<button class="btn_delete" name="cmd" type="submit" value="del_category" onclick="return confirm('Er du sikker på du vil slette denne kategori?')">Slet kategori</button>
		</form>

	<?php
		echo '</div></a>';}
	?>

	</ul>
</div>






</div>



</body>
</html>