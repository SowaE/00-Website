<?php

function KlassenAuslesen () {
    include "Methoden.php";
    $con = VerbindungHerstellen();
    $table = TabelleLesen($con, "klasse");
    echo "<select name='klasse' id='klasse'>";
    echo "<option value=' '> </option>";
    while($row = mysqli_fetch_array($table)) {
        echo "<option value=".$row['Klasse_ID'].">".$row['Bezeichnung']."</option>";
    }
    echo "</select>";

    while ($row = $table->fetch_assoc()) {
        foreach($row as $value) {
            echo $value;
        }
    }
}
?>
