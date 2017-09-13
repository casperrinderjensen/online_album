<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Upload photo</title>


<link rel="stylesheet" href="style_album.css">
<link rel="stylesheet" href="browser_reset.css">
<link rel="stylesheet" href="simplegrid.css">

<link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">



<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

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



	<div class="upload_content col-1-2">


	<h1>Upload photo</h1>


<?php
	require_once("db_con.php");	
	
	$cmd = filter_input(INPUT_POST, 'upload');
	
	
	
/* IMAGE UPLOAD */

	
	// variable to check if there were upload problems/errors!
	$uploadOk = 0;
	
	
	
	if($cmd){
		
		
		// Billedetitel 
		$imagetitle = filter_input(INPUT_POST, 'imagetitle')
				or die('Missing/Illegal Image title parameter');
		
		
		// Kategorinummer 
		$catnumber = filter_input(INPUT_POST, 'minDropListe')
				or die('Missing/Illegal Category number parameter');
		
		
		// storing the path to your image directory
		$target_dir = "images/";
 		$target_file = $target_dir . basename($_FILES['fileToUpload']['name']); //specifies the path of the file to be uploaded (fx: images/bulletin-board-background.jpg)
		
		 // Check if file is an image
		 $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		 if($check !== false) {
		 //echo "<h3>Billedet er " . $check["mime"] . ". </h3><br>";
		 $uploadOk = 1;
		 } else {
		 echo "<h4>Filen er ikke et billede. Prøv igen!</h4><br>";
		 $uploadOk = 0;
		 }
		
		
		// Check if file already exists
		 if (file_exists($target_file)) {
		 echo "<h4>Filen eksisterer allerede. Prøv igen!</h4><br>";
		 $uploadOk = 0; 
		 }
		
		// Check if $uploadOk is set to 0 by an error
		 if ($uploadOk == 0) {
		 echo "<h4>Desværre, dit billede blev ikke uploadet. Prøv igen!</h4><br>";
		 // if everything is ok, try to upload file
		 } else {
		 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

		
			 
			 // the query inserting target path into database!	 
		$stmt = $con->prepare("INSERT INTO image (image_url, title, category_number) VALUES (?, ?, ?)");
			$stmt->bind_param("ssi", $target_file, $imagetitle, $catnumber);
			$stmt->execute();
			// close statement
			$stmt->close();
			 
	
		 echo "<h3>Dit billede ". basename( $_FILES["fileToUpload"]["name"]). " blev uploadet!</h3>";
		 } else {
		 echo "<h4>Sorry, there was an error uploading your file.</h4>";
		 	}
		 }
		
	// end of cmd:
	}



?>



<!-- Enctype multipart MUST be used in connection with a file/image upload -->
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
<div class="box">
				
				<input type="file" name="fileToUpload" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple  style="display: none;"/>
					<label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
				</div>
			

<input class="text" type="text" name="imagetitle" placeholder="Indtast billed titel"><br>




<!-- Kategori numre bliver slected fra databasen og smidt ind i select formen -->
<select class="select" name="minDropListe">
<option selected disabled>Vælg kategori</option>

<?php
	require_once('db_con.php');
	
	$sql = 'SELECT category_id, category.name FROM category order by category.name';
	$stmt = $con->query($sql);
	  
	  // Kategorinumrene bliver lavet om til navnene på kategorierne
	 if($stmt->num_rows > 0){
		 while($row = $stmt->fetch_assoc()){
			 echo "<option name='category_id' value='" . $row['category_id']."'>" . $row['name']."</option>"; 
		 }}
	  
	  	else {
			echo 'Could not find category' .$cid;
		}
	 	
?>	

</select> <br>


	<button type="submit" name="upload" value="Upload">upload photo</button>
</form>


</div>



<div class="last_update col-1-2">
<!-- Billedetitel og url bliver selected og bliver vist -->
<h1>Senest uploadet billede</h1>





<?php

	$stmt = $con->prepare("SELECT image_url, title FROM image order by image_id desc limit 1");
	$stmt->execute();
	$stmt->bind_result($url, $imgtitle);
	
	while($stmt->fetch()){
		
		echo '<p>' . $imgtitle . ' </p>';
		echo '<img src="' . $url . '" width="250px">';
		
	}	

	$stmt->close();
	$con->close();
	
?>

</div>


<script src="js/custom-file-input.js"></script>


	</div>

</body>
</html>