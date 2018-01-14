<?php
/**
 * Created by PhpStorm.
 * User: Labib Ali Syed
 * Date: 13/1/18
 * Time: 3:19 PM
 */


/**

 * ANY file size requirements ??????

 */

// Getting uploaded file name
$fileName = basename($_FILES["uploadFile"]["name"]);

$target_dir = "Uploaded_Files/";
$target_file = $target_dir . $fileName;


// Getting file type
$CheckFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

// Making sure all the required condition is fulfilled
$uploadOK = 1;



// Checking extension/type of a file
if( $CheckFileType != "csv"){


    // 2 indicates type error
    $uploadOK = 2;
}

// Duplicate check.
if(file_exists($target_file)){


   // 3 indicates duplicate error.
    $uploadOK = 3;

}


// Uploading file to target directory after type, and duplication check is been done.

if($uploadOK == 1){

    move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file );

    echo "The file " . $fileName . " has been uploaded successfully.";

}else{

    echo "Sorry, there was an error uploading file. Please try again.";
}






