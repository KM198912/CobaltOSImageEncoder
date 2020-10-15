<?php
if(!function_exists('imagecreatefromjpeg')) exit("php-gd is not installed please ask your host to enable/install it");
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	die();
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	;
  } else {
    echo "Sorry, there was an error uploading your file.";
	die();
  }
}

list($width, $height) = getimagesize("uploads/" . basename( $_FILES["fileToUpload"]["name"]));
$resource = imagecreatefromjpeg("uploads/" . basename( $_FILES["fileToUpload"]["name"])); 

$o = "$width,$height;";

$redList = array();
$greenList = array();
$blueList = array();

$index = 0;
for($x = 0; $x < $width; $x++) {
    for($y = 0; $y < $height; $y++) {
        $rgb = imagecolorat($resource, $x, $y);
	$r = ($rgb >> 16) & 0xFF;
	$g = ($rgb >> 8) & 0xFF;
	$b = $rgb & 0xFF;
	$redList[$index] = $r;
	$greenList[$index] = $g;
	$blueList[$index] = $b;
	$index = $index + 1;
    }
}

foreach ($redList as $i) {
	$o = $o . $i . ",";
}
$o = rtrim($o, ",") . ";";
foreach ($blueList as $i) {
	$o = $o . $i . ",";
}
$o = rtrim($o, ",") . ";";
foreach ($greenList as $i) {
	$o = $o . $i . ",";
}
$o = rtrim($o, ",");
echo $o;
?>
