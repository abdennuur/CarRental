<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{

	if(isset($_POST['update']))
	{
		// Check if file was uploaded without errors
		if(isset($_FILES["img1"]) && $_FILES["img1"]["error"] == 0) {
			$id = intval($_GET['imgid']);
			
			// Get file details
			$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
			$filename = $_FILES["img1"]["name"];
			$filetype = $_FILES["img1"]["type"];
			$filesize = $_FILES["img1"]["size"];
			
			// Validate file extension
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if(!array_key_exists($ext, $allowed)) {
				$error = "Error: Please select a valid image file format.";
			}
			
			// Validate file size - 5MB maximum
			$maxsize = 5 * 1024 * 1024;
			if($filesize > $maxsize) {
				$error = "Error: File size is larger than the allowed limit (5MB).";
			}
			
			// Validate MIME type of the file
			if(in_array($filetype, $allowed) && empty($error)) {
				// Create safe filename
				$new_filename = md5(time() . $filename) . "." . $ext;
				$upload_dir = "img/vehicleimages/";
				$upload_path = $upload_dir . $new_filename;
				
				// Check if directory exists, create if not
				if (!file_exists($upload_dir)) {
					if (!mkdir($upload_dir, 0755, true)) {
						$error = "Failed to create directory: $upload_dir";
						// Additional debugging info
						$error .= " Current directory: " . getcwd();
						$error .= " PHP User: " . get_current_user();
					}
				}
				
				// Check if directory is writable
				if (!is_writable($upload_dir)) {
					$error = "Directory is not writable: $upload_dir";
					// Try to make it writable
					chmod($upload_dir, 0755);
					if (!is_writable($upload_dir)) {
						$error .= " - Failed to make directory writable.";
					} else {
						$error .= " - Successfully made directory writable.";
					}
				}
				
				// If no errors, try to move the uploaded file
				if (empty($error)) {
					if(move_uploaded_file($_FILES["img1"]["tmp_name"], $upload_path)) {
						// File uploaded successfully, now update database
						try {
							$sql = "UPDATE tblvehicles SET Vimage1 = :vimage1 WHERE id = :id";
							$query = $dbh->prepare($sql);
							$query->bindParam(':vimage1', $new_filename, PDO::PARAM_STR);
							$query->bindParam(':id', $id, PDO::PARAM_STR);
							
							if($query->execute()) {
								$msg = "Image updated successfully. New filename: " . $new_filename;
							} else {
								$error = "Database update failed: " . print_r($query->errorInfo(), true);
							}
						} catch(PDOException $e) {
							$error = "Database error: " . $e->getMessage();
						}
					} else {
						$error = "Error: File upload failed. Check directory permissions.";
						// Debug information
						$error .= " Upload path: $upload_path";
						$error .= " PHP Upload Error: " . $_FILES["img1"]["error"];
						$error .= " Current directory: " . getcwd();
						$error .= " PHP User: " . get_current_user();
						$error .= " is_writable: " . (is_writable($upload_dir) ? "Yes" : "No");
					}
				}
			} else {
				if (empty($error)) {
					$error = "Error: There was a problem with the file. Type: $filetype is not allowed.";
				}
			}
		} else {
			$error = "Error: " . $_FILES["img1"]["error"];
			switch($_FILES["img1"]["error"]) {
				case 1:
					$error .= " - File exceeded upload_max_filesize.";
					break;
				case 2:
					$error .= " - File exceeded max_file_size.";
					break;
				case 3:
					$error .= " - File only partially uploaded.";
					break;
				case 4:
					$error .= " - No file uploaded.";
					break;
				case 6:
					$error .= " - Missing a temporary folder.";
					break;
				case 7:
					$error .= " - Failed to write file to disk.";
					break;
				case 8:
					$error .= " - A PHP extension stopped the file upload.";
					break;
			}
		}
	}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>Car Rental Portal | Admin Update Image 1</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>


</head>

<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
	<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Vehicle Image 1 </h2>

						<div class="row">
							<div class="col-md-10">
								<div class="panel panel-default">
									<div class="panel-heading">Vehicle Image 1 Details</div>
									<div class="panel-body">
										<form method="post" class="form-horizontal" enctype="multipart/form-data">
										
											
  	        	  <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>



<div class="form-group">
												<label class="col-sm-4 control-label">Current Image1</label>
<?php 
$id=intval($_GET['imgid']);
$sql ="SELECT Vimage1 from tblvehicles where tblvehicles.id=:id";
$query = $dbh -> prepare($sql);
$query-> bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>

<div class="col-sm-8">
<img src="img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" width="1024" height="1024" style="border:solid 1px #000">
</div>
<?php }}?>
</div>

											<div class="form-group">
												<label class="col-sm-4 control-label">Upload New Image 1<span style="color:red">*</span></label>
												<div class="col-sm-8">
											<input type="file" name="img1" required>
												</div>
											</div>
											<div class="hr-dashed"></div>
											
										
								
											
											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-4">
								
													<button class="btn btn-primary" name="update" type="submit">Update</button>
												</div>
											</div>

										</form>

									</div>
								</div>
							</div>
							
						</div>
						
					

					</div>
				</div>
				
			
			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>

</body>

</html>
<?php } ?>