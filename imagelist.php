

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Images</title>

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


<div class="content">

<div class="header col-1-1">
		<h1>Billeder i den valgte kategori</h1>
	</div>
	
	<div class="images_wrapper col-1-1">
		<ul>
	
	
<?php
if($cmd = filter_input(INPUT_POST, 'cmd')){
	if($cmd == 'del_image') {
			$image_id = filter_input(INPUT_POST, 'image_id', FILTER_VALIDATE_INT)
					or die('Missing/Illegal image id parameter');
			require_once('db_con.php');
			$sql = 'DELETE FROM image WHERE image_id=?';
			$stmt = $con->prepare($sql);
			$stmt->bind_param('i', $image_id);
			$stmt->execute();

			if($stmt->affected_rows > 0){
				echo '<h3>Billedet er blevet slettet</h3><br>';
				echo '<div class="btn_image"><a href="categorylist.php"><button>Tilbage til albums</button></a></div>';
			}
			else {
				echo '<h3>Billedet kunne ikke slettes. Prøv igen!</h3><br>';
			}
		}
		else {
			die('Unknown cmd: '.$cmd);
		}
}
?>
	
	
	
	
<?php
$cid = filter_input(INPUT_GET, 'categoryid', FILTER_VALIDATE_INT)
				or die('');
		
	require_once('db_con.php');
	$sql = 'SELECT image.image_id, image.image_url, image.title, image.category_number, image.last_update, category.category_id, category.name
FROM image, category 
WHERE image.category_number = category.category_id 
and image.category_number = ?
order by image_id desc';
	$stmt = $con->prepare($sql);
	$stmt->bind_param('i', $cid);
	$stmt->execute();
	$stmt->bind_result($image_id, $url, $imgtitle, $cat_number, $lastupdate, $cat_id, $catname);
	while ($stmt->fetch()){
		
		echo '<div class="images col-1-4">';
		
		echo '<li>';
		
		echo '<h3 class="image_title">' . $imgtitle . '</h3>';
		
		echo '<img src="' . $url . '" width="250px">';
		
		echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
		echo '<input type="hidden" name="image_id" value="'.$image_id.'" />';
		
	?>
		
		
		<button class="btn_del_image" name="cmd" type="submit" value="del_image" onclick="return confirm('Er du sikker på du vil slette dette billede?')">Delete Image</button>
		
		
	<?php	
		echo '</form>'.PHP_EOL;
		
		echo '</li>';
		
		echo '</div>';
	}

	$stmt->close();
	$con->close();
?>


	</ul>
	
</div>

	</div>

	
	</div>

	
</body>
</html>