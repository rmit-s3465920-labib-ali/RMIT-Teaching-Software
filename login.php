<?php
/**
 * Created by PhpStorm.
 * Author: Labib Ali Syed
 * Date: 20/12/17
 * Time: 01:45 PM
 */

 // Parsing the login form value and assigning into variable.

$studentID = $_POST['studentID'];
$subject   = $_POST['subject'];




/**

   * Establishing connect to mysql database
   * Providng database port number
   * Assigning database username, password and database name

*/

$servername = "localhost:8889";
$username = "root";
$password = "root";
$dbname  = "RMIT-Teaching-Software";



// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// making query, finding Student ID and subject name into the database and counting the result of the query. 

$sql = "SELECT Subject FROM SID WHERE Subject='$subject' and SID='$studentID'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$count = mysqli_num_rows($result);


if($count >= 1) {

    include("StudentHome.html");

}else {


    echo "<script type='text/javascript'> alert('Student or subject was incorrect!');\n </script>";
    include("index.html");



}
