<script>
    function busqueda(){
        var text = document.getElementById('search').value;
        //console.log(text);
        if (!text || text.trim() === "") {
            console.log("La variable está vacía.");
            text = 0
        } else {
            console.log("La variable contiene un valor.");
        }
        var url = '/listaDeActas/busqueda/' + text;
        //console.log(id + url);
        // location.replace("https://www.w3schools.com");   el replace corra la URL actual lo que hace imposible 
            // darle un back
        window.location = url;
        //window.location.replace(url);
        
    }
</script>