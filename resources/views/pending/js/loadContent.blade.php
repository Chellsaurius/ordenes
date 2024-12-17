<script>
    function content(id){
        //console.log(id);
        
        //console.log(id + url);
        var contents = document.getElementById("contents" + id);
        contents.style.display = "block";
        
        var order = document.getElementById("order" + id).value;
        console.log(order);
        var url = 'AJAX/obtenerContenido/' + order;
        $.ajax({
            url: url,
            method: 'get',
            dataType: 'json',
        }).done(function(data){
            //console.log(data)
            var contents = "";
            // console.log(content_id);
            contents += "<option name='content' value='' class='text-uppercase' disabled selected> " + 'Seleccione una opción' + "</option>";
            // $("#content" + id).empty();
            // $("#content" + id).html('');
            for (let index = 0; index < data.length; index++) {
                contents += "<option name='content' value='" + data[index].content_id + "' class='text-uppercase'> " + "(" + data[index].content_number + ") " + data[index].content_description.substring(0,70) + "... " + "</option>";
                
            }
            document.getElementById("content" + id).innerHTML = contents;
            // divToUpdate.html("content" + id);
        
        })
    }
    
</script>