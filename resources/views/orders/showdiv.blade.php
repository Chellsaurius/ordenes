<script>
    function showComisions() {
        var select = document.getElementById("belongsTo");
        var div = document.getElementById("divComisions");
        var typesDiv = document.getElementById("divTypes");
        var comisionsSelect = document.getElementById("comision");
        var typesSelect = document.getElementById("types");
        //console.log(select.value);
        if (select.value == 1) {
            div.style.display = "block";
            comisionsSelect.disabled = false; // habilita el select
        } else {
            div.style.display = "none";
            comisionsSelect.disabled = true; // deshabilita el select
        }
        if (select.value == 2) {
            typesDiv.style.display = "block";
            typesSelect.disabled = false; // habilita el select
        } else {
            typesDiv.style.display = "none";
            typesSelect.disabled = true; // deshabilita el select
        } 
    }
</script>