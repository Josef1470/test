<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index_style.css">
    <title>Document</title>
</head>
<body>
<div id="data_table">
    <table>
        <tr>
            <th>Bild</th>
            <th>Namn</th>
            <th>Banknummer</th>
            <th>Saldo</th>
        </tr>

        <?php
        // Connection till mysqli server
        $servername = "localhost";
        $username = "root";
        $password = "";

        $conn = new mysqli($servername, $username, $password);

        if (!$conn){
            die("connection failed: " . mysqli_connection_error());
        }       

        $select_base = mysqli_select_db($conn, 'user_bank');

        if(!$select_base ) {
            die("Could not select database: " . mysqli_error($conn));
        }

        $sql = "SELECT Bild, Namn, Bankkonto, Saldo FROM user_info";
        $result = mysqli_query($conn, $sql);

        // En while loop som echoar datan som blir sparad som en array så länge det inte är slut på tuppler i tabellen
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><img src='" . $row["Bild"] . "' alt='Bild' style='width:100px;height:100px;'></td>";
                echo "<td>" . $row["Namn"] . "</td>";
                echo "<td>" . $row["Bankkonto"] . "</td>";
                echo "<td>" . $row["Saldo"] . "</td>";
                echo "</tr>";
            }
        }
        ?>

    </table>

    <a href="./php/userdata.php">Gå till registrering</a>
</div>
</body>
</html>