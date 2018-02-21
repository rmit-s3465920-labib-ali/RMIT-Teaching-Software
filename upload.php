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


// Uploading file to target directory after type and duplication check is been done.

if($uploadOK == 1){

    move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file );


    loadCSVTODatabase();

    echo "The file " . $fileName . " has been uploaded successfully.";

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



    //getting first line of csv (For table columns)

    $columnName = fgetcsv($csvFile);




    //-------------------------------------------------------------------------------
    //
    //          Creation Of Database Table for Uploaded CSV
    //
    //  1. File name is parsed and stored into variable to use it to assign Name of table.
    //  2. Only one column is inserted at this stage with ID column, other will be done in next stage while looping through $columnName variable.
    //
    //-----------------------------------------------------------------------------


    //Parsing uploaded file name

    $fileName = pathinfo($_FILES['uploadFile']['name']);

    // Storing in into $tableName variable to use it for Database table name.

    $tableName = $fileName[filename];

    // Creating table for uploaded CSV file

    $sql = "CREATE TABLE $tableName (
    id INT (10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    $columnName[0] VARCHAR (10) NOT NULL

    )";

    // checking table is successfully created.

    if (mysqli_query($db, $sql)) {
        echo "Table MyGuests created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($db);
    }

    //----------------------------------END------------------------------------------------------------------------------







    //-------------------------------------------------------------------------------
    //
    //Updating the columns name of database table as per csv First Row
    //
    //
    //-----------------------------------------------------------------------------


    for($i=0; $i<=sizeof($columnName); $i++) {

        // this variable is used to get the name of the previous column already in the database table.
        $PreviousColumn = $i-1;
        $update = "ALTER TABLE $tableName ADD $columnName[$i] VARCHAR (100) NOT NULL AFTER $columnName[$PreviousColumn]";
        $db->query($update);
    }

    //----------------------------------END------------------------------------------------------------------------------






    //-------------------------------------------------------------------------------
    //           Inserting the data into table from CSV into the right columns
    //
    // 1. Each row data is stored in $line array variable.
    // 2. Columns name is taken from $columnName array variable, which is incremented to load data into all columns of a row.
    // 3. $idForTableUpdate variable is used to keep track of the row whose columns is getting updated, variable is incremented after one CSV file row is loaded to the database table.
    // 4. IF/ELSE is used so that ID is assigned to a single row, and then other columns can be updated using that ID for tracking.
    // 5. While assigning ID to a row, first column after ID is also populated with data.
    //-----------------------------------------------------------------------------

    $idForTableUpdate = 1;

   // parse data from csv file line by line
    while(($line = fgetcsv($csvFile)) !== FALSE) {
        //insert member data into database


        for ($i = 0; $i <= sizeof($columnName); $i++) {

            // when $i = 0, ID is inserted to the column which will be used to update data into all columns of that ID's row.

            if($i >= 1){
                $db->query("UPDATE $tableName SET  $columnName[$i]= '" . $line[$i] . "' WHERE id=$idForTableUpdate");
            }else {

                // First column after ID column is also inserted in the stage.

                $db->query("INSERT INTO $tableName  ($columnName[$i]) VALUES ('" . $line[$i] . "')");
            }


        }

        // After all columns of specific ID is updated with data, ID is incremented to load data in next row
        $idForTableUpdate++;

    }

    //----------------------------------END------------------------------------------------------------------------------




}

