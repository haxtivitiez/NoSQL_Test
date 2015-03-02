<!DOCTYPE html>
<!--This is modified code from https://github.com/tcstool/NoSQLMap-->
<html>

<head>
<title>User Profile Lookup</title>
</head>

<body>
<?php
	if (isset($_GET['usersearch']) && !empty($_GET['usersearch'])) {
		try {
      	$result = "";
       	$conn = new MongoClient();
       	$db = $conn->appUserData;
		 	$collection = $db->users;
		 	$search = $_GET['usersearch'];
		 	$js = "function () { var query = '". $search . "'; return this.username == query;}";
		 	print $js;
		 	print '<br/>';
       
       	$cursor = $collection->find(array('$where' => $js));
       	echo $cursor->count() . ' user found. <br/>';
       
       	foreach ($cursor as $obj) {
       		       echo 'Name: ' . $obj['name'] . '<br/>';
       	   	    echo 'Username: ' . $obj['username'] . '<br/>';
       	      	 echo 'Email: ' . $obj['email'] . '<br/>';
       	       	 echo '<br/>';
       	}
       
$conn->close();
} catch (MongoConnectionException $e) {
	die('Error connecting to MongoDB server : ' . $e->getMessage());
} catch (MongoException $e) {
	die('Error: ' . $e->getMessage());
}
}
?>
       	       
       	       
<b>Enter your username:</b><br>       	       
<form method="get" id="usersearch">
<p>Search <input type="text" name="usersearch" id="usersearch" /> <input type="submit" name="submitbutton" value="Submit" /></p>
</form>
<div id="results">
<?php echo $result; ?>
</div>
</body>
</html>