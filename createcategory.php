<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>


<link rel="stylesheet" href="style_createcategory.css">
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


	<?php
	if($cmd = filter_input(INPUT_POST, 'cmd')){
		if($cmd == 'add_category') {
			$catname = filter_input(INPUT_POST, 'catname') 
				or die('Missing/illegal catname parameter');

			require_once('db_con.php');
			$sql = 'INSERT INTO category (name) VALUES (?)';
			$stmt = $con->prepare($sql);
			$stmt->bind_param('s', $catname);
			$stmt->execute();

			if($stmt->affected_rows > 0){
				echo '<h2>Du har nu tilføjet "'.$catname.'" som et nyt album</h2><br>';
				echo '<div class="btn_album"><a href="categorylist.php"><button>Se album</button></a></div>';
			}
			else {
				echo '<h2>Kunne ikke oprette et nyt album. Prøv igen!/h2>';
			}	
		}

	}
	?>





	<!-- Form til at tilføje en ny kategori -->
	<div class="new_category_content col-1-1">	
		<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
			<fieldset>
				<h1>tilføj ny kategori</h1>
				<input name="catname" type="text" placeholder="Category name" required />
				<button name="cmd" type="submit" value="add_category">Create</button>
			</fieldset>
		</form>
	</div>


</div>


	</div>

</body>
</html>