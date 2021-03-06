<html>
<head>
<title> Update Contact </title>
</head>
<body style="background-color:#E6E6FA">

<!--Heading of application and links to other pages-->
<center>
    <h2 class="c1">Phone Book Application</h3>
	<div class="c2">
	<a href="http://localhost/Phonebook1/addcontact.php">Add Contact</a> | <a href="http://localhost/Phonebook1/deletecontact.php">Delete Contact</a> | <a href="http://localhost/Phonebook1/updatecontact.php">Update Contact</a>
	</div>
</center>
<hr>
<?php
if(isset($_POST["UpdateAction"])){
// Start the session
session_start();

//Connecting code to Database
$DB_USER ='root';
$DB_PASSWORD = '';
$DB_HOST = 'localhost';
$DB_NAME ='site';
$db= new mysqli($DB_HOST,$DB_USER, $DB_PASSWORD, $DB_NAME)
or die("Could not connect to MySQL");

//Receive & Validating the Data Provided by the User
//Validating the Data Provided by the User
$v_firstName = $_POST['u_firstName'];
$v_firstName = HTMLSpecialChars($v_firstName);
$v_middleName = $_POST['u_middleName'];
$v_middleName = HTMLSpecialChars($v_middleName);
$v_lastName = $_POST['u_lastName'];
$v_lastName = HTMLSpecialChars($v_lastName);
$v_phoneNumber = $_POST['u_phoneNumber'];
$v_phoneNumber = HTMLSpecialChars($v_phoneNumber);
$v_email = $_POST['u_email'];
$v_email = HTMLSpecialChars($v_email);
$v_address = $_POST['u_address'];
$v_address = HTMLSpecialChars($v_address);
$v_city = $_POST['u_city'];
$v_city = HTMLSpecialChars($v_city);
$v_state = $_POST['u_state'];
$v_state = HTMLSpecialChars($v_state);
$v_zipcode = $_POST['u_zipcode'];
$v_zipcode = HTMLSpecialChars($v_zipcode);

//The First name chosen for update passed as post 
$update = $_POST['u_contact_id'];
$update = HTMLSpecialChars($update);

//Validating that all Important Data has been provided by the user

if(empty($v_firstName)){
	$Prompt='First Name<br>';}
if(empty($v_phoneNumber)){
	$Prompt='Phone Number<br>';}

if ($Prompt){
	echo $Prompt;
}
else{
//For Image
$target_dir = "uploads/";
$prefix = "_".$v_firstName."_";
$target_file = $target_dir .$prefix.basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if($check !== false) {
	$uploadOk = 1;
} else {
	echo "File is not an image.";
	$uploadOk = 0;
}

// Check if file already exists
if (file_exists($target_file)) {
	echo "Sorry, file already exists.";
	$uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
	echo "Sorry, your file is too large.";
	$uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "JPG" && $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	echo "The file ".$prefix.basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	} else {
	echo "Sorry, there was an error uploading your file.";
	}
}

$v_picName = $prefix.basename( $_FILES["fileToUpload"]["name"]);

}

// Echo session variables that were set on previous page
$id = $_SESSION["user_id"] ;
$table = 'contacts';

//data into database
$sql = "UPDATE $table SET v_firstName = '$v_firstName', v_middleName = '$v_middleName', v_lastName = '$v_lastName',v_phoneNumber = '$v_phoneNumber', v_email = '$v_email', v_address = '$v_address', v_city = '$v_city', v_state = '$v_state',v_zipcode = '$v_zipcode', v_picName='$v_picName' WHERE contact_id='$update' and user_id='$id'";

if (mysqli_query($db, $sql)) {
    echo "Record updated successfully";
	echo '<h3><a href="http://localhost/Phonebook1/phonebook_index.php">Take me to Contact List</a></p>';
	echo "<hr>";
	echo "<center>";
	echo '<h3><a href="http://localhost/Phonebook1/logout.php">Logout</a></p>';
	echo '<h3><a href="http://localhost/Phonebook1/phonebook_index.php">Go Back to Home</a></p>';
	echo "<p>Copyright 2016 Manjil Thapa Magar </p>";
	echo "</h3>";
	echo "</center>";
	exit();
} else {
    echo "Error updating record: " . mysqli_error($db);
}

mysqli_close($db);
}
?>

<?php
if(isset($_POST["Update"])){
// Start the session
session_start();

//Connecting code to Database
$DB_USER ='root';
$DB_PASSWORD = '';
$DB_HOST = 'localhost';
$DB_NAME ='site';
$db= new mysqli($DB_HOST,$DB_USER, $DB_PASSWORD, $DB_NAME)
or die("Could not connect to MySQL");


//Receive & Validating the Data Provided by the User
$delete1 = $_POST['delete1'];
$delete1= HTMLSpecialChars($delete1);

// Echo session variables that were set on previous page
$id = $_SESSION["user_id"] ;
$table = 'contacts';

//List the Contacts available on the Database
$query = "SELECT v_firstName, v_middleName, v_lastName, v_phoneNumber, v_email, v_address, v_city, v_state, v_zipcode, v_picName FROM $table WHERE contact_id='$delete1' and user_id=$id";
$response = @mysqli_query($db, $query);
$row = mysqli_fetch_array($response);
//Save the datat into new variables
$u_firstName = $row['v_firstName'];
$u_middleName = $row['v_middleName'];
$u_lastName = $row['v_lastName'];
$u_phoneNumber = $row['v_phoneNumber'];
$u_email = $row['v_email'];
$u_address = $row['v_address'];
$u_city = $row['v_city'];
$u_state = $row['v_state'];
$u_zipcode = $row['v_zipcode'];

//Form to get the user input of First, Middle, Last Names, Phone Number and Email
echo '<table align="centre" cellspacing="5" cellpadding="10" width="100%">';
echo "<form action='updatecontact.php' method='POST' enctype='multipart/form-data'>";

echo "Choose your Profile Picture:";
echo "<input type='file' name='fileToUpload' id='fileToUpload'>";
echo "<tr><td><b>First Name</b></td>";
echo "<td><input type='text' name='u_firstName' value='$u_firstName' maxlength=50></td></tr>";
echo "<tr><td><b>Middle Name</b></td>";
echo "<td><input type='text' name='u_middleName' value='$u_middleName' maxlength=50></td></tr>";
echo "<tr><td><b>Last Name</b></td>";
echo "<td><input type='text' name='u_lastName' value='$u_lastName' maxlength=50></td></tr>";
echo "<tr><td><b>Phone Number</b></td>";
echo "<td><input type='text' name='u_phoneNumber' value='$u_phoneNumber' maxlength=50></td></tr>";
echo "<tr><td><b>Email</b></td>";
echo "<td><input type='text' name='u_email' value='$u_email' maxlength=50></td></tr>";
echo "<tr><td><b>Address</b></td>";
echo "<td><input type='text' name='u_address' value='$u_address' maxlength=50></td></tr>";
echo "<tr><td><b>City</b></td>";
echo "<td><input type='text' name='u_city' value='$u_city' maxlength=50></td></tr>";
echo "<tr><td><b>State</b></td>";
echo "<td><input type='text' name='u_state' value='$u_state' maxlength=50></td></tr>";
echo "<tr><td><b>Zip Code</b></td>";
echo "<td><input type='text' name='u_zipcode' value='$u_zipcode' maxlength=50></td></tr>";

echo "<tr><td><input type='hidden' name='u_contact_id' value='$delete1'</td></tr>";

echo "<td> <align='center'> <input type='submit' name='UpdateAction' value='Submit'>";
echo "<input type='reset' name='reset' value='Clear'></td></tr>";
echo "</form>";
echo "</table>";

mysqli_close($db);


}
else{

// Start the session
session_start();

//Connecting code to Database
$DB_USER ='root';
$DB_PASSWORD = '';
$DB_HOST = 'localhost';
$DB_NAME ='site';
$db= new mysqli($DB_HOST,$DB_USER, $DB_PASSWORD, $DB_NAME)
or die("Could not connect to MySQL");

// Echo session variables that were set on previous page
$id = $_SESSION["user_id"] ;
$table = 'contacts';

//Get the Contact List from Database
$query = "SELECT contact_id, v_firstName FROM $table where user_id=$id";
$response = @mysqli_query($db, $query);

//Form to get the user input of First, Middle, Last Names, Phone Number and Email
echo '<table align="centre" cellspacing="5" cellpadding="10" >';
echo "<form action='updatecontact.php' method='post'>";
echo "<tr>";

//Show checkbox for all the Contacts as option to delete
if ($response)
{
echo '<td align="left"><b>Choose the Contact to Update </b></td>';

while($row = mysqli_fetch_array($response))
{
	echo '<tr><td align="left">'.
	$row['v_firstName'].'</td>';
	$row['contact_id'].'</td>';
	$v_first = $row['v_firstName'];
	$v_first = HTMLSpecialChars($v_first);
	$contact_id = $row['contact_id'];
	$contact_id = HTMLSpecialChars($contact_id);
	echo "<td><input type='checkbox' name='delete1' value=$contact_id>  <br>";
	echo '</tr>';
}


}
else{
	echo"No DATABASE";
	echo mysqli_error($db);
}
mysqli_close($db);

//Submit the chosen contacts to be deleted
echo "<td> <align='center'> <input type='submit' name='Update' value='Submit'>";

echo "</form>";
echo "</table>";

}
?>

<hr>
<!--Footer-->
<center>
<h3><a href="http://localhost/Phonebook1/logout.php">Logout</a></p>
<h3><a href="http://localhost/Phonebook1/phonebook_index.php">Go Back to Home</a></p>
<p>Copyright 2016 Manjil Thapa Magar </p>
</h3>
</center>

</body>
</html>