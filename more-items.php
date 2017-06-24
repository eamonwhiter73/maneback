<?

header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *"); 

ini_set('memory_limit', '1024M');

if(isset($_POST['page'])) {
	$page = $_POST['page'];
}

/*$user = 'eamondev_root';
$password = 'bonjour3';
$db = 'eamondev_maneapp';
$host = 'localhost';*/

$user = 'root';
$password = 'root';
$db = 'maneapp';
$host = 'localhost';

// Create connection
$conn = new mysqli($host, $user, $password, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$limitVar1 = $page;
//error_log("limit var: " + strval($limitVar1));

$sql = "SELECT * FROM feed ORDER BY id DESC LIMIT $limitVar1, 10";	
$result = $conn->query($sql);

$array = [];

//error_log($result->num_rows);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
	//if($row['id'] > ((10 * $page) - 10) && $row['id'] < (10 * $page) + 1)  {
    //error_log($row['id']);
		$base64Blob = base64_encode($row['picture']);
  	$array[] = $base64Blob;
  //}
  }
  
  $sql2 = "SELECT * FROM feed";
  $result2 = $conn->query($sql2);
  $allItems = $result2->num_rows;
  
  $array[] = $allItems;
} else {
	$array[] = "0 results";
}

echo json_encode($array);

$conn->close();

?>
