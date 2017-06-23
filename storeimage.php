<?php

header('content-type: multipart/form-data');
header("access-control-allow-origin: *"); 

$imageString = '';

//error_log($_POST["base"]);

if(isset($_POST['base'])) {
	error_log("inside isset");
	$imageString = $_POST['base'];
}

$msg = '';
base64_to_jpeg($imageString, 'file.jpg');
//error_log(print($imageFile));
$img = file_get_contents('file.jpg');

//unlink('file.jpg');
$con = mysqli_connect('localhost','root','root','maneapp') or die('Unable To connect');
$sql = "insert into feed (picture) values(?)";
$stmt = mysqli_prepare($con,$sql);
//$img = mysqli_escape_string($con, $img);
error_log(var_dump($img));
mysqli_stmt_bind_param($stmt, "s", $img);
mysqli_stmt_execute($stmt);
$check = mysqli_stmt_affected_rows($stmt);
if($check==1){
	$msg = 'Image Successfullly Uploaded';
	echo 'success';
}else{
	$msg = 'Error uploading image';
	echo 'failure';
}

function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' ); 

    //error_log($base64_string);
    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );
    //error_log($data[1] . ' this is data 1');

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp ); 

    return $output_file; 
}
mysqli_close($con);

?>