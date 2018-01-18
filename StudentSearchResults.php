<?php
/**
 * Created by PhpStorm.
 * User: Labib Ali Syed
 * Date: 18/1/18
 * Time: 12:20 AM
 */

include('dbConfig.php');


$studentID    = $_POST['studentID'];
$course      = $_POST['subject'];
$assingmentNo = $_POST['assignmentNo'];



// Making query to search student results using Course, Student ID, and Assignment No.
$query = "SELECT * From Marks WHERE COURSE = '$course' AND SID = '$studentID' AND ASSID = '$assingmentNo' ";

$result = $db->query($query);

//Checking num of rows in query result.
if($result->num_rows > 0){

    //Output data of each row
    while ($row = $result->fetch_assoc()){

      //Get Column(Key) value
        while(current($row)){


            $columnName = key($row);
            //printing key and value of the row.
            echo $columnName. ": " . $row[$columnName]. "</br>";

            next($row);
        }


    }

}else{

    echo "0 result";
}

