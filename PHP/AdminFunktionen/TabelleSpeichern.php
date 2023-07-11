<?php    
    include "../Methoden.php";
    $conn = VerbindungHerstellen();
    $sql = urldecode($_POST['sql']);
    $sqlBetter = "";
    for($i = 0; $i < strlen($sql); $i++) {
        if($sql[$i] != '!') {
            $sqlBetter .= $sql[$i];
        } else {
            $sqlBetter .= "NULL";
        }
    }
    SQLConnect($conn, $sqlBetter);
    mysqli_close($conn);
?>