<script>
    function load(id){
        var url = 'AJAX/obtenerÓrdenes';
        //console.log(id + url);
        
        $.ajax({
            url: url,
            method: 'get',
            dataType: 'json',
        }).done(function(data){
            // console.log(data)
            // var name = document.getElementById("order" + id).innerText;
            // name = name.toUpperCase();
            var orders = "";
            //console.log("orden: " + order_id);
            orders += "<option name='order' id='order_id" + id + "' value='' class='text-uppercase' disabled selected> " + 'Seleccione una opción' + "</option>";
            for (let index = 0; index < data.length; index++) {
                orders += "<option name='order' id='order_id" + id + "' value='" + data[index].order_id + "' class='text-uppercase'> " + data[index].order_subject + "</option>";
                
            }
            document.getElementById("order" + id).innerHTML = orders;
        
        })
    }
    
</script>