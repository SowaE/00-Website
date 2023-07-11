<?php
    include "../Methoden.php";
    $conn = VerbindungHerstellen();
    $sql = urldecode($_POST['sql']);
    PkDel($conn, $sql);
    mysqli_close($conn);
?>