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

include('dbConfig.php');





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


    loadCSVTODatabase();
}else{

    echo "Sorry, there was an error uploading file. Please try again.";
}




function loadCSVTODatabase(){

   // gets global variable from dbConfig.php for database connection.
    global $db;

    // TASK
    // try to read file without saving it to the directory.

   // $content = file_get_contents($_FILES["uploadFile"]["tmp_name"]);

    $fileToRead = "Uploaded_Files/" . basename($_FILES["uploadFile"]["name"]);


//    $myfile = fopen("$fileToRead", "r") or die("Unable to open file!");
//    echo fread($myfile,filesize("$fileToRead"));
//    fclose($myfile);


    //open uploaded csv file with read only mode
    $csvFile = fopen("$fileToRead", 'r');


    //skip first line
    fgetcsv($csvFile);

    //parse data from csv file line by line
    while(($line = fgetcsv($csvFile)) !== FALSE){
    //insert member data into database

        $db->query("INSERT INTO Marks (COURSE, SID, ASSID, SID2, ASS2_SUB, LEADER, A2_TTL, OVERALL_COMMENT, UI_ABLE_2_ADD_ATHLETE_2_GAME, UI_ABLE_2_RUN_GAME_VIA_GUI, UI_DISPLAY_RESULT, UI_DISP_ATHLETE_SCORE, UI_FILE_HANDLE, FILE_LOAD, FILE_SAVE, FILE_RELOAD, CODING_STYLE, COMMENTS_JAVADOC, GOOD_USER_UI_BONUS
    ) VALUES ('".$line[0]."','".$line[1]."','".$line[2]."','".$line[3]."','".$line[4]."','".$line[5]."','".$line[6]."','".$line[7]."','".$line[8]."','".$line[9]."','".$line[10]."','".$line[11]."','".$line[12]."','".$line[13]."','".$line[14]."','".$line[15]."','".$line[16]."','".$line[17]."','".$line[18]."')");


}

}

