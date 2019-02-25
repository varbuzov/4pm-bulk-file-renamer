<?php 
include 'config.php';
session_start();

$target_dir = UPLOAD_FOLDER . "/";
$files = !empty($_SESSION['files']) ? $_SESSION['files'] : array(); 

if (!empty($_POST)) {
	$new_files = array();
	foreach ($_POST as $index => $name) {
		$new_name = $target_dir . $name . '.' . pathinfo($files[$index], PATHINFO_EXTENSION);
		$attempt = 0;
		if (file_exists($new_name)) {
			$name .= '-' . md5(date('dmthis'));
			$new_name = $target_dir . $name . '.' . pathinfo($files[$index], PATHINFO_EXTENSION);
		}

		rename($files[$index], $new_name);
		$new_files[] = $new_name;
	}
	$_SESSION['files'] = $new_files;
	header("Refresh:0");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>4pm File Uploader & Renamer</title>
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
	<?php if ($count = count($files)): ?>
		<div class="row">
			<div class="col">
				<div class="alert alert-info" role="alert"><?php echo $count ?> file(s) uploaded. They may be renamed below.<div>
			</div>
		</div>
	<?php else: ?>
		<div class="row">
			<div class="col">
				<div class="alert alert-warning" role="alert">There haven't been any files uploaded. <a href=".">Upload files</a>.<div>
			</div>
		</div>
	<?php endif ?>
	<div class="row">
		<div class="col">
			<div class="form-row align-items-center pb-3">
				<div class="col-auto">
					<input type="text" id="baseName" placeholder="Base name" class="form-control">
				</div>
				<div class="col-auto">
					<button type="button" class="btn btn-outline-primary" id="updateName">Update All</button>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<form method="post">
				<table class="table file-names">
					<tr>
						<th>Image</th>
						<th>Name</th>
					</tr>
					<?php foreach ($files as $index => $file): ?>
						<?php $file = preg_replace("/\.[^.]+$/", "", str_replace($target_dir, '', $file)); ?>
						<tr>
							<td width="200">
								<img src="<?php echo "$target_dir/$file" ?>">
							</td>
							<td><input type="text" name="<?php echo $index ?>" class="form-control" value="<?php echo $file ?>"></td>
						</tr>
					<?php endforeach ?>
				</table>
				<input type="submit" value="Update" class="btn btn-primary mb-5">
			</form>
			<p>Your file names:</p>
			<pre><?php foreach ($files as $file): ?><?php print_r(PUBLIC_URL . '/' . str_replace($target_dir, '', $file) . "\n") ?><?php endforeach ?></pre>
			<a href="." class="btn btn-outline-primary">+ Upload More</a>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	$('#updateName').on('click', function() {
		var baseName = $('#baseName').val();
		baseName = baseName.replace(/[^a-z0-9]/gi, '-').toLowerCase();
		if (baseName) {
			var elements = $('.file-names input');
			for (var i = elements.length - 1; i >= 0; i--) {
				$(elements[i]).val(baseName + '-' + i);
			}
		}
	})
</script>
</body>
</html>