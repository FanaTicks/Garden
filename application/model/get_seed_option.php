<?php
header('Content-Type: application/json; charset=utf-8');

$link = mysqli_connect("localhost", "root", "admin", "Garden");
mysqli_set_charset($link, "utf8");

$result = mysqli_query($link, "SELECT * FROM Seed");

$options = array();
while ($row = mysqli_fetch_assoc($result)) {
    $options[] = array(
        'Id_Seed' => $row['Id_Seed'],
        'Name_Seed' => $row['Name_Seed']
    );
}

echo json_encode($options);
?>
