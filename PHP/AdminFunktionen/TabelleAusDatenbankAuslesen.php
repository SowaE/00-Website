<?php
    include "../Methoden.php";
    $conn = VerbindungHerstellen();

    // Deten Auslesen
    $tableName = $_POST["InputTableName"];
    
    // Prüfen ob Daten ausgefüllt sind
    if(isset($tableName)) {
        // Tabelle aus Datenbank auslesen
        $table = TabelleLesen($conn, $tableName);

        if($table->num_rows != 0) {
            // Ausgabe der Tabellenstruktur (Spaltennamen)
            echo "<table id='DBTabel'><tr>";
            $colNames = array();
            $i = 0;
            while ($field = $table->fetch_field()) {
                echo "<th>" . $field->name . "</th>";
                $colNames[$i++] = $field->name;
            }
            echo "<td></td><td></td>";
            echo "</tr>";
            // Ausgabe der Tabelleninhalte (Zeilen)
            $r = 0;
            $c;
            while ($row = $table->fetch_assoc()) {
                echo "<tr>";
                $c = 0;
                foreach ($row as $value) {
                    echo "<td id='row" . $r . "col" . $c . "'>" . $value . "</td>";
                    $c++;
                }
                echo "<td><input id='btnChangeRow" . $r . "' type='button' value='change'></td>";
                echo "<td><input id='btnSaveRow" . $r . "' type='button' value='save'style='display:none'></td>";
                echo "</tr>";
                $r++;
            }
            $output = $r;
            $output1 = $c;
            echo "</table>";

            echo "<div>Den zu Löschenden Primary Key hier eingeben</div>";
            echo "<input id='inpPkDel' type='text'> <input id='btnPkDel' type='button' value='löschen'>";

            echo "<div>Für neuen Eintrag auf Neu klicken</div>";
            echo "<input id='btnPkNew' type='button' value='Neu'>";
            echo "<div id='inpPkNew'></div>";

            // Anfang Datenübergabe der Variablen an JS
            echo "<!-- Anfang Datenübergabe der Variablen an JS --><div id='domTargetTableChange' style='display:none'>";
                $output .= ";" . $output1 . ";" . $tableName;
                foreach($colNames as $v)
                    $output .= ";" . $v;
                echo htmlspecialchars($output);
            echo "</div><!-- Ende Datenübergabe der Variablen an JS -->";
            // Ende Datenübergabe der Variablen an JS
            mysqli_close($conn);
            echo "<script src='../../JavaScript/AdminFunktionen/TabelleBearbeiten.js' type='text/javascript'></script>";
        }
        else {
            mysqli_close($conn);
            echo "<script> 
                    alert('Tabelle konte nicht gefunden werden');
                    window.location.href = '../../AdminBereich.html';
                </script>";
        }
    }
    else {
        mysqli_close($conn);
        echo "<script> 
                alert('Tabellenname eingeben');
                window.location.href = '../../AdminBereich.html';
            </script>";
    }
?>