<?php
$link = mysqli_connect("localhost", "root", "admin", "Garden");
$result = mysqli_query($link, "SELECT * FROM Seed");
$seeds = [];
while ($row = mysqli_fetch_assoc($result)) {
    $seeds[] = ['id' => $row['Id_Seed'], 'name' => $row['Name_Seed']];
}
echo json_encode($seeds);
?>
