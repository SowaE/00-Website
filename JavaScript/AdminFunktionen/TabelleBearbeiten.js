const spaltenNamen = new Array();
let datenAusPHPArray;
let EingabemaskeCounter = 0;
document.addEventListener("DOMContentLoaded", function() {
    // Daten von PHP enfangen
    let datenAusPHP = document.getElementById("domTargetTableChange").textContent;
    datenAusPHPArray = datenAusPHP.split(';');
    let zeilenAnzahl = datenAusPHPArray[0];
    let spaltenAnzahl = datenAusPHPArray[1];

    let spaltenNamenIndex = 0;
    for(let i = 3; i < datenAusPHPArray.length; i++) {
        spaltenNamen[spaltenNamenIndex] = datenAusPHPArray[i];
        spaltenNamenIndex++;
    }
    // EventListener hinzufügen
    for (let i = 0; i < zeilenAnzahl; i++) {
        var changeButton = document.getElementById("btnChangeRow" + i);
        changeButton.addEventListener("click", function() {
            ZeileBearbeiten(i, spaltenAnzahl, zeilenAnzahl);
        });
    
        var saveButton = document.getElementById("btnSaveRow" + i);
        saveButton.addEventListener("click", function() {
            ZeileSpeichern(i, spaltenAnzahl, zeilenAnzahl);
        });
    }

    document.getElementById("btnPkDel").addEventListener("click", function() {
        PkDel(datenAusPHPArray[2]);
    });

    document.getElementById("btnPkNew").addEventListener("click", function() {
        if(EingabemaskeCounter == 0) {
            CreateEingabeMaske(spaltenAnzahl);
            EingabemaskeCounter = 1;
        }
    });

    // Den ursprünglichen Konsolenlog speichern
    var originalConsoleLog = console.log;

    // Neuen Konsolenlog definieren
    console.log = function(message) {
        // Den ursprünglichen Konsolenlog aufrufen
        originalConsoleLog.apply(console, arguments);
    
        // Den letzten Konsolenoutput auslesen und mit alert ausgeben
        var lastOutput = arguments[0];
        if(lastOutput.length != 0)
            alert(lastOutput);
    };
});

function ZeileBearbeiten(zeilenNr, numOfCols, numOfRows) {
    document.getElementById("btnSaveRow" + zeilenNr).setAttribute("style", "display:inline-block");
    RowsLock(zeilenNr, numOfRows, true);
    ChangeRowState(zeilenNr, numOfCols, true);
}

function ZeileSpeichern(zeilenNr, numOfCols, numOfRows) {
    document.getElementById("btnSaveRow" + zeilenNr).setAttribute("style", "display:none");
    RowsLock(zeilenNr, numOfRows, false);
    let sql = ÄnderungenSpeichern(zeilenNr, numOfCols, datenAusPHPArray[2]);
    SqlAnPhpübergeben("../../PHP/AdminFunktionen/TabelleSpeichern.php", sql);
    ChangeRowState(zeilenNr, numOfCols, false);
}

// Blockiert alle Zeilen der Eingabe-Form bis auf Speichern geklickt wurde
// <<aktRow>> Aktuelle zu bearbeitende Zeile
// <<numOfRows>> Anzahl an Zeilen der zu bearbeitenden Tabelle
// <<lock>> wenn true dann geblockt, wenn false dann bearbeitbar
function RowsLock(aktRow, numOfRows, lock) {
    for(let r = 0; r < numOfRows; r++) {
        if(r != aktRow) {
            if(lock) {
                document.getElementById("btnChangeRow" + r).setAttribute("style", "display:none");
                document.getElementById("btnSaveRow" + r).setAttribute("style", "display:none");
            }
            else {
                document.getElementById("btnChangeRow" + r).setAttribute("style", "display:inline-block");
            }
        }
    }
}

// Ändert die Zeile zu eingabefeldnern
// <<rowNr>> Aktuell zu bearbeitende Zeile
// <<numOfCols>> Spaltenanzahl der Zeile
// <<changebel> Wenn true können Felder bearbeitet werden, wenn false dann sind die Felder nicht bearbeitbar
function ChangeRowState(rowNr, numOfCols, changabl) {
    for(let c = 1; c < numOfCols; c ++) {
        let tblElement = document.getElementById("row" + rowNr + "col" + c);
        if(changabl) {
            document.getElementById("btnChangeRow" + rowNr).setAttribute("style", "display:none");
            let inhalt = tblElement.textContent;
            tblElement.textContent = null;  
            let inputElement = document.createElement("input");
            inputElement.setAttribute("type", "text");
            inputElement.setAttribute("value", inhalt);
            inputElement.setAttribute("id", ("inpRow" + rowNr + "col" + c));
            inputElement.setAttribute("class", ("inpRow" + rowNr + "col" + c));
            inputElement.setAttribute("name", ("inpRow" + rowNr + "col" + c));
            inputElement.setAttribute("style", "width:100%  ");
            tblElement.appendChild(inputElement);
        }
        else {
            document.getElementById("btnChangeRow" + rowNr).setAttribute("style", "display:inline-block");
            let inputElement = document.getElementById("inpRow" + rowNr + "col" + c);
            let inhalt = inputElement.value;
            tblElement.removeChild(inputElement);
            tblElement.textContent = inhalt;
        }
    }
}

// Erstelt eine Update anweisung für alle Spalten der Tabelle
// <<rowNr>> Aktuell zu bearbeitende Zeile
// <<numOfCols>> Spaltenanzahl der Zeile
// <<tableName>> Name der zu ändernde Tablle
function ÄnderungenSpeichern(rowNr, numOfCols, tableName) {
    let sql = "UPDATE `" + tableName + "` SET ";
    for(let c = 1; c < numOfCols; c++) {
        let inpValue = document.getElementById("inpRow" + rowNr + "col" + c).value
        if(inpValue.length != 0) {
            sql += "`" + spaltenNamen[c] + "`='" + inpValue + "'";
        } else {
            sql += "`" + spaltenNamen[c] + "`= NULL";
        }
        if(c < numOfCols - 1) {
            sql += ", ";
        }
    }
    sql += " WHERE `" + tableName + "`.`" + spaltenNamen[0] + "`=" + document.getElementById("row" + rowNr + "col0").textContent;
    return sql;
}

// Übergibt eine SQL an PHP
// <<sql>> SQL-Anweisung welche übergeben werden soll
// <<php>> Pfad zur PHP-Datei
function SqlAnPhpübergeben(php, sql) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText); // Hier können Sie die Antwort des PHP-Skripts verarbeiten
        }
    };
    xhttp.open("POST", php, true); // Passe den Dateinamen an dein PHP-Skript an
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("sql=" + encodeURIComponent(sql));
}

// Löscht User
// <<tableName>> Name der zu verändernden Tabelle
function PkDel(tableName){
    let pkOfTable = document.getElementById("inpPkDel").value;
    if(pkOfTable.length != 0) {
        let sql = "DELETE FROM `" + tableName + "` WHERE `" + tableName + "`.`" + spaltenNamen[0] + "` = " + pkOfTable;
        SqlAnPhpübergeben("../../PHP/AdminFunktionen/SQLConnect.php", sql);
        location.reload()
    }
}

// Fügt einen neuen Benutzer hinzu
function PkNew() {
    let tableName = datenAusPHPArray[2];
    let sql = "INSERT INTO " + tableName + " (";
    for(let i = 0; i < spaltenNamen.length; i++) {
        if(i < spaltenNamen.length-1) {
            sql += spaltenNamen[i] + ", ";
        }else {
            sql += spaltenNamen[i];
        }
    }

    sql += ") VALUES (";
    for (let val = 0; val < datenAusPHPArray[1]; val++) {
        if(document.getElementById("TblVal"+spaltenNamen[val]).firstChild.value.length != 0) {
            if(val < datenAusPHPArray[1]-1) {
            sql += "'" + document.getElementById("TblVal"+spaltenNamen[val]).firstChild.value + "', ";
            } else {
                sql += "'" + document.getElementById("TblVal"+spaltenNamen[val]).firstChild.value + "'";
            }
        } else {
            if(val < datenAusPHPArray[1]-1) {
                sql += null + ",";
            } else {
                sql += null;
            }
        }
    }
    sql += ")";
    SqlAnPhpübergeben("../../PHP/AdminFunktionen/SQLConnect.php", sql);
    location.reload()
    document.getElementById("inpPkNew").childNodes = null
}   

// Erstellt eine Eingabemaske
function CreateEingabeMaske(anzCols) {
    let tblPkNew = document.createElement("table");
    tblPkNew.setAttribute("id", "tblPkNew");

    let rowtblPkNew = document.createElement("tr");
    let row1tblPkNew = document.createElement("tr");

    for(let i = 0; i < anzCols+1; i++) {
        let col = document.createElement("td");
        let col1 = document.createElement("td");

        col.setAttribute("id", ("Ue"+spaltenNamen[i]));
        col.textContent = spaltenNamen[i];
        rowtblPkNew.appendChild(col);

        col1.setAttribute("id", ("TblVal"+spaltenNamen[i]));
        let inp = document.createElement("input");
        inp.setAttribute("id", ("TblVal"+spaltenNamen[i]));
        if(i == 0) {
            let lastPk = document.getElementById("row"+(datenAusPHPArray[0]-1)+"col0").textContent;
            inp.setAttribute("value", ++lastPk);
        }
        col1.appendChild(inp);

        if(i == anzCols-1) {
            let btnSave = document.createElement("input");
            btnSave.setAttribute("type", "button")
            btnSave.setAttribute("id", "btnSavePkNew");
            btnSave.setAttribute("value", "Speichern");

            btnSave.addEventListener("click", function() {
                PkNew();
            });
            col1.appendChild(btnSave);
            row1tblPkNew.appendChild(col1);
            break;
        } else {
            row1tblPkNew.appendChild(col1);
        }
    }

    tblPkNew.appendChild(rowtblPkNew);
    tblPkNew.appendChild(row1tblPkNew);
    let inpPkNew = document.getElementById("inpPkNew");
    inpPkNew.appendChild(tblPkNew);
}