// Felder für Wochentage von HTML holen
let monday = document.getElementById("mondayDate");
let tuesday = document.getElementById("tuesdayDate");
let wednesday = document.getElementById("wednesdayDate");
let thursday = document.getElementById("thursdayDate");
let friday = document.getElementById("fridayDate");

let TagesFelder = [monday, tuesday, wednesday, thursday, friday];

// AktDatum ermitteln
let aktDatum = new Date();
// AktJahr ermitteln
let aktJar = aktDatum.getFullYear();
// Erster Tage des aktJahrs
let firstDayOfAktJahr = new Date(aktJar, 0, 1);
// Vergangene Tage des aktJahrs
let vergangeTageOfAktJahr = (aktDatum - firstDayOfAktJahr) / 86400000;
// AktWoche ermitteln
let aktWoche = Math.ceil((vergangeTageOfAktJahr + firstDayOfAktJahr.getDay() + 1) / 7);
// Beginn der aktWoche
let DateOfMontagOfAktWoche = new Date(aktDatum.setDate(aktDatum.getDate() - ((aktDatum.getDay()) - 1)));
// Maximale Tage des aktMonat
let MaxDayOfAktMonat = new Date(aktJar, aktDatum.getMonth() + 1, 0).getDate();

// Wochentage ausgeben
// Montag augeben
if(DateOfMontagOfAktWoche.getMonth()+1 <= 9) {
    if(DateOfMontagOfAktWoche.getDate() <= 9) {
        TagesFelder[0].innerHTML = "0" + (DateOfMontagOfAktWoche.getDate()) + ".0" + (DateOfMontagOfAktWoche.getMonth()+1);
    } else {
        TagesFelder[0].innerHTML = (DateOfMontagOfAktWoche.getDate()) + ".0" + (DateOfMontagOfAktWoche.getMonth()+1);
    }
}else {
    if(DateOfMontagOfAktWoche.getDate() <= 9) {
        TagesFelder[0].innerHTML = "0" + (DateOfMontagOfAktWoche.getDate()) + "." + (DateOfMontagOfAktWoche.getMonth()+1);
    } else {
        TagesFelder[0].innerHTML = (DateOfMontagOfAktWoche.getDate()) + "." + (DateOfMontagOfAktWoche.getMonth()+1);
    }
}

// Restliche Tage ausgeben
let counter = 0;
for(let day = 0; day < 5; day++) {
    if(DateOfMontagOfAktWoche.getDate()+day <= MaxDayOfAktMonat) {
        if(DateOfMontagOfAktWoche.getMonth()+1 <= 9) {
            if(DateOfMontagOfAktWoche.getDate()+day <= 9) {
                TagesFelder[day].innerHTML = "0" + (DateOfMontagOfAktWoche.getDate()+day) + ".0" + (DateOfMontagOfAktWoche.getMonth()+1);
            } else {
                TagesFelder[day].innerHTML = (DateOfMontagOfAktWoche.getDate()+day) + ".0" + (DateOfMontagOfAktWoche.getMonth()+1);
            }
        }else {
            if(DateOfMontagOfAktWoche.getDate()+day <= 9) {
                TagesFelder[day].innerHTML = "0" + (DateOfMontagOfAktWoche.getDate()+day) + "." + (DateOfMontagOfAktWoche.getMonth()+1);
            } else {
                TagesFelder[day].innerHTML = (DateOfMontagOfAktWoche.getDate()+day) + "." + (DateOfMontagOfAktWoche.getMonth()+1);
            }
        }
    }else {
        counter = DateOfMontagOfAktWoche.getDate();
        aktWoche = 1;
        TagesFelder[day].innerHTML = "0" + (counter++) + ".01";
    }
}

// Kalenderwoche ausgeben
document.getElementById("KW").innerHTML = aktWoche;


