<script>
    function orders(id){
        var id = id;
        var url = 'AJAX/listaDeOrdenes';
        //console.log(id + url);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data:{
                "_token": "{{ csrf_token() }}",
                id: id,
            }
        }).done(function(data){
            //console.log(data)
            var name = document.getElementById("order" + id).innerText;
            var order_id = document.getElementById("order_id" + id).value;
            name = name.toUpperCase();
            var orders = "";
            console.log(order_id);
            orders += "<option name='order' value='" + order_id + "' class='text-uppercase' disabled selected> " + name + "</option>";
            for (let index = 0; index < data.length; index++) {
                orders += "<option name='order' value='" + data[index].order_id + "' class='text-uppercase'> " + data[index].order_subject + "</option>";
                
            }
            document.getElementById("order" + id).innerHTML = orders;
        
        })
    }
</script>