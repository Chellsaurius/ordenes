function showComisions() {
    var select = document.getElementById("belongsTo");
    var div = document.getElementById("divComisions");
    //console.log(select.value);
    if (select.value == 1) {
        div.style.display = "block";
    } else {
        div.style.display = "none";
    }
}