<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <style>
    .pointer {cursor: pointer;}
  </style>
</head>
<body>

<div class="container">
  <h2>Orders List</h2>
  <p>Please select list of products and click on Create Order to place order.</p>  
  <button type="button" class="btn btn-info btn-lg" onclick="document.location.href='index.php'" >View Products</button>     
  <table class="table">
    <thead>
      <tr>
        <th>Customer Name</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Type</th>
        <th>status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="order_list">
    
    </tbody>
  </table>



  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Order Status</h4>
        </div>
        <div class="modal-body">
          <p>Please select status to change</p>
          <input type="hidden" value="" id="order_id_status" >
          <select class="form-control" id="order_status">
              <option value="1">Pending</option>
              <option value="2">Confirmed</option>
              <option value="3">Cancelled</option>
              <option value="4">Dispatched</option>
              <option value="5">Delivered</option>
         </select>
        </div>
        <div class="modal-footer">
          <button type="button" id="change_status" class="btn btn-info btn-default" data-dismiss="modal">Change Status</button>
        </div>
      </div>
      
    </div>
  </div>

</div>
<script>

 function delete_order(id){
       
        $.ajax({
            url: "ePaisa/web/index.php/api/delete-order",
            type: 'POST',
            dataType: 'json',
            data : {order_id : id},  
            success: function(result){
              alert(result.message);
              window.location.reload();

    }});


   }

  function change_status(id){

     $('#order_id_status').val(id);
     $('#myModal').modal('show');

   }


$(document).ready(function(){

    $.ajax({
            url: "ePaisa/web/index.php/api/get-orders/",
            type: 'GET',
            dataType: 'json', 
            success: function(result){
            
                var product_html = '';
                for(i = 0;i< result.length ;i++){

                    product_html += '<tr> <td>'+result[i]['name']+'</td> <td>'+result[i]['product_name']+'</td> <td>'+result[i]['price']+'</td> <td>'+result[i]['type']+'</td> <td>'+result[i]['order_status']+'</td> <td> <p><span onclick="change_status('+result[i]['order_id']+')" class="glyphicon glyphicon-pencil pointer"></span></p>  <p> <span onclick="delete_order('+result[i]['order_id']+')" class="pointer glyphicon glyphicon-trash"></span></p> </td> </tr>';
               }

         $('#order_list').append(product_html);

    }});


   $(document).on('click','#change_status',function(){

          $.ajax({
            url: "ePaisa/web/index.php/api/order-status",
            type: 'POST',
            dataType: 'json',
            data : {order_id : $('#order_id_status').val(), status_id : $('#order_status').val()},  
            success: function(result){
              alert(result.message);
              window.location.reload();

    }});


   });

   $(document).on('click','#place_order',function(){

         var products = {};
          $.each($(".products_select:checked"), function(key, val){
                products[key] = {};            
                products[key]['product_id'] = $(this).val();
                products[key]['user_id'] = $('#select_user').val();
          });


         $.ajax({
            url: "ePaisa/web/index.php/api/place-order",
            type: 'POST',
            dataType: 'json',
            data : products,  
            success: function(result){
            
               var users_html = '';
                for(i = 0;i< result.length ;i++){

                    users_html += '<option '+result[i]['id']+' >'+result[i]['name']+'</option>';
               }

         $('#select_user').append(users_html);

    }});

   });

});
</script>
</body>
</html>


