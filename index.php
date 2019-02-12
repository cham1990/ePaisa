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
  <h2>Products List</h2>
  <p>Please select list of products and click on Create Order to place order.</p>  
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Place Order</button> 
  <button type="button" class="btn btn-info btn-lg" onclick="document.location.href='orders.php'">View Orders</button> 
 <input type="hidden" id="url" value="<?php ?>"  >
  
     
  <table class="table">
    <thead>
      <tr>
        <th></th>
        <th>Product Name</th>
        <th>Product Price</th>
        <th>Product Type</th>
      </tr>
    </thead>
    <tbody id="product_list">
    
    </tbody>
  </table>



  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Select User</h4>
        </div>
        <div class="modal-body">
          <p>Please select User to place order</p>
          <select class="form-control pointer" id="select_user"></select>
        </div>
        <div class="modal-footer">
          <button type="button" id="place_order" class="btn btn-info btn-default" data-dismiss="modal">Place Order</button>
        </div>
      </div>
      
    </div>
  </div>

</div>
<script>
$(document).ready(function(){

    $.ajax({
            url: "ePaisa/web/index.php/api/get-products/",
            type: 'GET',
            dataType: 'json', 
            success: function(result){
            
                var product_html = '';
                for(i = 0;i< result.length ;i++){

                    product_html += '<tr> <td><input class="products_select" type="checkbox" value="'+result[i]['id']+'"></td> <td>'+result[i]['name']+'</td> <td>'+result[i]['price']+'</td><td>'+result[i]['type']+'</td> </tr>';
               }

         $('#product_list').append(product_html);

    }});

     $.ajax({
            url: "ePaisa/web/index.php/api/get-customers",
            type: 'GET',
            dataType: 'json', 
            success: function(result){
            
               var users_html = '';
                for(i = 0;i< result.length ;i++){

                    users_html += '<option value="'+result[i]['id']+'" >'+result[i]['name']+'</option>';
               }

         $('#select_user').append(users_html);

    }});



   $(document).on('click','#place_order',function(){

         var products = {};
         var is_checked = 0;
          $.each($(".products_select:checked"), function(key, val){
                products[key] = {};            
                products[key]['product_id'] = $(this).val();
                products[key]['user_id'] = $('#select_user').val();
  
                is_checked = 1;
          });

         if(is_checked == 1){
		 $.ajax({
		    url: "ePaisa/web/index.php/api/place-order",
		    type: 'POST',
		    dataType: 'json',
		    data : products,  
		    success: function(result){

		      alert(result.message);
                      window.location.reload();

	    }});
     } else {
             alert("Please select at least one product to place order.");

    }

   });

});
</script>
</body>
</html>


