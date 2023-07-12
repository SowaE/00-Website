var xmlhttp = new XMLHttpRequest();
xmlhttp.open("GET", "NavigationMitAdmin.html", true);
xmlhttp.send();
xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200)
        document.getElementById("navigation").innerHTML = this.responseText;
};