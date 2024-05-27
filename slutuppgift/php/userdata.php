<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form.css">
    <title>Document</title>
</head>
<body>
    <!-- Formulär för inmatning av info -->
    <form action="#" method="post" enctype="multipart/form-data">
        <label for="fname">First name:* </label> <br>
        <input type="text" name="fname" placeholder="John"> <br> <br>

        <label for="banknumber">Bank account number:* </label> <br>
        <input type="text" name="banknumber" placeholder="Min 4 numbers, max 34"> <br> <br>

        <label for="balance">Account balance:* </label> <br>
        <input type="text" name="balance" placeholder="xxxx"> <br> <br>

        <label for="picture">Picture of you: </label> <br>
        <input type="file" name="picture"> <br>

        <input type="submit" name="submit" value="Spara">
    </form>




<?php
// Connection till mysqli server
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if (!$conn){
    die("connection failed: " . mysqli_connection_error());
}


// Välja databas (user_bank i detta fall)
$select_base = mysqli_select_db($conn, 'user_bank');

if(!$select_base ) {
    die("Could not select database: " . mysqli_error($conn));
}


// $sql = "CREATE TABLE user_info(
//     Bild VARCHAR(50) NOT NULL,
//     Namn VARCHAR(30) NOT NULL,
//     Bankkonto VARCHAR(34) PRIMARY KEY NOT NULL,
//     Saldo INT(6) NOT NULL,
//     reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
// )";

// if (mysqli_query($conn, $sql)){
//     echo "Table 'user_info' created successfully";
// }
// else{
//     echo "Error creating table" . mysqli_error($conn);
// }


$target_dir = "../bilder/";
$target_file = $target_dir . basename($_FILES["picture"]["name"]);
$uploadOk = 1;

// Skapade liknande variablare men ändrade från "../" till "./" för att lägga in denna versionen i databasen 
// för att den kommer att accessas från index.php. Den andra target_dir variabeln är för att accessa mappen 
// bilder från userdata.php pch det behövs "../" för att backa.

$target_dir2 = "./bilder/";
$target_file2 = $target_dir2 . basename($_FILES["picture"]["name"]);

$name = $_POST["fname"];
$banknumber = $_POST["banknumber"];
$balance = $_POST["balance"];





if (isset($_POST["submit"])){

    if (empty($name)){
        echo "Name cannot be empty! <br>";
    }
    
    if (empty($banknumber)){
        echo "Banknumber cannot be empty! <br>";
    }
    elseif (strlen($banknumber) < 4 || strlen($banknumber) > 34){
        echo "Banknumber must be between 4 and 34 numbers! <br>";
    }

    if (empty($balance)){
        echo "Balance cannot be empty!";
    }
    
    // Om alla vilkor för formen uppfyllda då sparar den till databasen
    if (!empty($name) && !empty($banknumber) && (strlen($banknumber) >= 4 && strlen($banknumber) <= 34) && !empty($balance)){
        // Uploadar bilden från formulären till mappen "bilder".

        $sql = "INSERT INTO user_info (Bild, Namn, Bankkonto, Saldo)
                VALUES ('$target_file2', '$name', '$banknumber', '$balance')";
    
        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully <br>";
        } 
        else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        if ($uploadOk == 0) {
            echo "Error";
        } 
    
        else {
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                echo "Filen '". basename( $_FILES['picture']['name']). "' har laddats upp i mappen 'bilder' <br>";
        } 
        else {
            echo "Det uppstod ett problem när filen skulle laddas upp! <br>";
        }
        }
    }    

    
}

?>
</body>
</html>