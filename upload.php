<?php
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

for($x = 0; $x < $width; $x++) {
    for($y = 0; $y < $height; $y++) {
        // pixel color at (x, y)
        $rgb = imagecolorat($resource, $x, $y);
	$redList[($x * $y) + $x] = ($rgb >> 16) & 255;
	$greenList[($x * $y) + $x] = ($rgb >> 8) & 255;
	$blueList[($x * $y) + $x] = $rgb & 255;
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
$deflate = base64_encode(gzdeflate($o, 9));
echo $deflate;
?>