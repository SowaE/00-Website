<?php
    function VerbindungHerstellen() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "BEAT_IT_DB";
        // Verbindung herstellen
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        
        // Überprüfen, ob die Verbindung erfolgreich ist
        if (!$conn) {
            die("Verbindung fehlgeschlagen: " . mysqli_connect_error());
        }

        return $conn;
    }

    function CheckEmail($email, $connection) {
        $sql = "SELECT Email FROM benutzer WHERE Email = '" . $email . "'";
        $ergebnis = mysqli_query($connection, $sql)->num_rows;
        if($ergebnis == 0)
            return false;
        else
            return true;
    }

    function GetMaxUserID($conn) {
        $sql = "SELECT MAX(Benutzer_ID) FROM benutzer";
        $ergebnis = mysqli_query($conn, $sql)->fetch_row()[0];
        return $ergebnis;
    }

    function NeuenBenutzerAnlegen($mail, $vName, $nName, $passwort, $klasse, $conn) {
        $maxBenutzerID = GetMaxUserID($conn) + 1;
        $sql = "INSERT INTO benutzer (Benutzer_ID, Benutzer_Art, Klasse_ID, Vorname, Nachname, Email, Password) ";
        $passwortHash = crypt($passwort, "87cd084d190e436f147322b90e7384f6a8e0676c99d21ef519ea718e51d45f9c");
        if($klasse == " ") {
            $klasse = "null";
        }
        $sql .= "VALUES ( " . $maxBenutzerID . ", 1, " . $klasse . ", '". $vName . "', '" . $nName . "', '" . $mail . "', '" . $passwortHash . "')";
        $ergebnis = mysqli_query($conn, $sql);
    }

    function TabelleLesen($conn, $tableName) {
        $sql = "SELECT * FROM " . $tableName;
        $ergebnis = mysqli_query($conn, $sql);
        return $ergebnis;
    }

    function SQLConnect($conn, $sql) {
        $reslut = mysqli_query($conn, $sql);
        if(!$reslut)
            echo "Error updating record: " . mysqli_error($conn);
    }

    function NoMoreFalschEingabe($inputString)
	{
		$saubereEingabe = trim(nl2br(strip_tags($inputString)));
		return $saubereEingabe;
	}
?>