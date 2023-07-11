<?php
    include "../Methoden.php";
    $conn = VerbindungHerstellen();
    $sql = urldecode($_POST['sql']);
    SQLConnect($conn, $sql);
    mysqli_close($conn);
?>