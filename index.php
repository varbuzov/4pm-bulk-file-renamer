<?php 
include 'config.php';
session_start();

if (isset($_FILES['upload']['name'])) {
	$files = array();
	foreach ($_FILES['upload']['name'] as $index => $file) {
		$target_dir = UPLOAD_FOLDER . "/";
		$target_file = $target_dir . date('Y-m-d-his-') . basename($file);
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		$upload_success = move_uploaded_file($_FILES['upload']['tmp_name'][$index], $target_file);
		if ($upload_success) {
			$files[] = $target_file;
		}
		if ($files) {
			$_SESSION['files'] = $files;
			header('Location: ' . 'naming.php');
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col text-center py-5 mb-5">
			<h1><a href="." class="text-dark">4pm</a></h1>
			<div>File Uploader & Renamer</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<form method="post" enctype="multipart/form-data">
				<input name="upload[]" type="file" multiple="multiple" class="form-control-file mb-3">
				<input type="submit" value="Upload" class="btn btn-primary">
			</form>
		</div>
	</div>
</div>


</body>
</html>