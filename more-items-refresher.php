<?

header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: http://localhost:8100");

ini_set('memory_limit', '1024M');

if(isset($_POST['page'])) {
	$page = $_POST['page'];
}
if(isset($_POST['lastNumRows'])) {
  $lastNumRows = $_POST['lastNumRows'];
}

$user = 'eamondev_root';
$password = 'bonjour3';
$db = 'eamondev_maneapp';
$host = 'localhost';

//$user = 'root';
//$password = 'root';
//$db = 'maneapp';
//$host = 'localhost';

// Create connection
$conn = new mysqli($host, $user, $password, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



//$limitVar1 = $page;
//error_log("limit var: " + strval($limitVar1))

$sql = "SELECT * FROM feed ORDER BY id DESC";	
$result = $conn->query($sql);

$array = [];

$allItems = $result->num_rows;

if($result->num_rows > $lastNumRows) {
  $counter = $result->num_rows - $lastNumRows;
  // output data of each row
  while($row = $result->fetch_assoc()) {
    if($counter > 0) {
	//if($row['id'] > ((10 * $page) - 10) && $row['id'] < (10 * $page) + 1)  {
    //error_log($row['id']);
		  $base64Blob = base64_encode($row['picture']);
  	  $array[] = $base64Blob;
      $counter--;
    }
    else {
      break;
    }
  //}
  }

  $array[] = $allItems;
} else {
  error_log('made it to 0 results');
	$array[] = "0 results";
}

echo json_encode($array);

$conn->close();

?>
