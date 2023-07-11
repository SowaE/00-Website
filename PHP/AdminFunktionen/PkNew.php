<?php
    include "../Methoden.php";
    $conn = VerbindungHerstellen();
    $sql = urldecode($_POST['sql']);
    PkNew($conn, $sql);
    mysqli_close($conn);
?>