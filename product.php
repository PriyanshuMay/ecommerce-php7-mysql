<?php
   session_start();
   include('config/config.php');
   include('function/function.php');
?>
<?php  include('boilerplate.php'); ?>
<?php  include('navbar.php'); ?>
<?php
   $id = $_GET['id'];
   $result = mysqli_query($mysqli,"SELECT * FROM product WHERE id=$id");
   $row = mysqli_fetch_assoc($result);
   $product_id = $row['id'];
   $categories = $row['categories'];
   $qty = $row['qty'];

        $customer = $_SESSION['email'];

        $get_customer = "SELECT * FROM customer WHERE email ='$customer'";

        $run_customer = mysqli_query($mysqli,$get_customer);

        $row_customer = mysqli_fetch_assoc($run_customer);

        $customer_id = $row_customer['id'];
        $customer_name = $row_customer['name'];
        $customer_img = $row_customer['customer_img'];

?>

<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
<link rel="stylesheet" type="text/css" href="css/detail.css">

    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/jquery.min.js"></script>
    <script src="jquery-3.2.1.min.js"></script>

  <style>
    .input-hidden {
  position: absolute;
  left: -9999px;
}

input[type=radio]:checked + label>img {
  border: 1px solid #FFC107;
  box-shadow: 0 0 2px 0px #FFC107;
}


input[type=radio] + label>img {
  border: 1px solid #000;
  width: 45px;
  height: 35px;
  border-radius: 2px;

}


</style>

<script type="text/javascript">
      $("a").click(function() {
    $(this).next().prop("checked", "checked");
});

  $('a').click(function() {
        $('li:has(input:radio:checked)').addClass('active');
        $('li:has(input:radio:not(:checked))').removeClass('active');
    });
    </script>
<style class="cp-pen-styles">
</style>

<style type="text/css">
  .product-details .product-images img {

    display: block;
    width: 500px;

}
</style>

<?php
include('config/config.php');

   $id = $_GET['id'];
   $result = mysqli_query($mysqli,"SELECT * FROM product LEFT JOIN categories 
                                   ON categories.cat_id = product.categories WHERE product.id=$id");
   $row2 = mysqli_fetch_assoc($result);
   $cat_id = $row2['cat_id'];
   $cat_name = $row2['cat_name'];
?>

<main>
    <div class="section section-gray">
        <div class="section-content">
            <div class="product-details">
                <ul class="product-images">
                    <li class="preview"><img src="admin/cover/<?php echo $row2['cover'] ?> " alt="" ></li>
                    <li class="javascript:void(0)"><img src="admin/cover/<?php echo $row2['cover'] ?> " alt="" ></li>
                    <?php
                      $sql2 = "SELECT * FROM image_attributes
                              WHERE product_id = $id";
                      $run = mysqli_query($mysqli,$sql2);
                    while($row2 = mysqli_fetch_assoc($run)):
                    ?>
                    
                    <li>
                        <a href="javascript:void(0)"><img src="admin/uploads/<?php echo $row2['image'] ?> " alt="row2image" ></a>
                    </li>
                    <?php endwhile; ?> 
                    
                </ul>
                <?php
include('config/config.php');

   $id = $_GET['id'];
   $result = mysqli_query($mysqli,"SELECT * FROM product WHERE id=$id");
   $row3 = mysqli_fetch_assoc($result);
?>              

                <ul class="product-info">
                 
                    <li><p id="title"><?php echo $row3['product_name']?><br>
                    <span class="badge badge-primary">&#x20B9;&nbsp;<?php echo $row3['price']?></span>
                  
                  </p></li>

              <div class="row">  
                <div class="col-md-6 mb-3">
                  <p>Colors</p>
       <div class="form-group">

       <form method="post" action="detail_add.php" enctype="multipart/form-data">
       
       <input type="hidden" name="id" value="<?php echo $id?>">
         <?php

            $sql ="SELECT distinct a.*,p.color,p.product_id FROM product_attribute p
                   LEFT JOIN attribute a
                   ON p.color = a.attr_id
                   WHERE p.product_id = '$id'";
                   $ret = mysqli_query($mysqli,$sql);
                  $num_results=mysqli_num_rows($ret);
                  for($i=0;$i<$num_results;$i++)
  {
    $row=mysqli_fetch_array($ret);

    echo"<input type=\"radio\" name=\"rdocolor\" value=\"".$row['value']."\"
  id=\"happy_".$row['attr_id']."\" class=\"custom-control-input\"/>";
    echo "<label for=\"happy_".$row['attr_id']."\">";
    ?>
     
     <img 
    src="admin/images/<?php echo $row['attr_img'] ?>" 
    alt="<?php echo $row['value'] ?>" />
    <?php

    echo "<label>";
  
  }
 ?>
           
                          </div>
                            </div>
                          </div>  

      <div class="row">

          <?php 
            $result = "SELECT * FROM product_attribute where product_id = $id";
            $sql = mysqli_query($mysqli,$result);
            $row = mysqli_fetch_assoc($sql);             
          ?>

           <div class="col-md-6 mb-3">
            <p class="col_size">Sizes</p>
         
                <select name="size" class="custom-select d-block w-100" id="size" required>
                  <option value="">Choose...</option>
                           <?php

                                    $sql ="SELECT distinct a.*,p.size,p.product_id FROM product_attribute p
                                     LEFT JOIN attribute a
                                     ON p.size = a.attr_id
                                     WHERE p.product_id = '$id'";

                               $result = mysqli_query($mysqli,$sql);

                               while($row = mysqli_fetch_assoc($result)){
                                    $size = $row['size'];
                                                  ?>

                                    <?php if($size == 0){ ?>
                                      <option value='ONE SIZE'>ONE SIZE</option>
                                   <?php  }else{ ?>                                               
                                  <option value='<?php echo $row['value']; ?>'><?php echo $row['value']; ?></option>
                                        <?php } ?>          
                                              <?php  } ?>
                </select>   
              </div>

               
                          <br><br>

                          <div class="col-md-8">

                     <style type="text/css">
                          
                          </style>
<!--      ----------------------------------- In stock & sold out ------------------------ -->
                          <?php if($qty == 0){
                            echo "<span class='badge badge-danger'>SOLD OUT</span>";
                          }
                          else{
                            echo "<span class='badge badge-success'>In Stock</span>";
                          }

                          ?>
<!--      ----------------------------------- In stock & sold out end------------------------ -->
                     <br><br>
 
                            

              

                           

         <?php
              $sql ="SELECT distinct a.*,p.color,p.product_id FROM product_attribute p
                     LEFT JOIN attribute a
                     ON p.size = a.attr_id
                     WHERE p.product_id = '$id'";

             $result = mysqli_query($mysqli,$sql);

             while($row = mysqli_fetch_assoc($result)){

        ?>
   

         <?php } ?>

          
          <?php 
      $s = "SELECT * FROM product WHERE id = '$id'";
      $r = mysqli_query($mysqli,$s);
      $row_r = mysqli_fetch_assoc($r);
        $product_id = $row_r['id'];
        $customer = $_SESSION['email'];

    
      $sql5 = "SELECT * FROM customer WHERE email = '$customer'";
      $run5 = mysqli_query($mysqli,$sql5);
      $row5 =mysqli_fetch_assoc($run5);
      $customer_id = $row5['id'];
      $customer_name = $row5['name'];
      
      
      $sql_fav = "SELECT * FROM add_to_favourite WHERE customer_id ='$customer_id' AND product_id = '$product_id'";
      $run_fav = mysqli_query($mysqli,$sql_fav);
      $row_fav = mysqli_fetch_assoc($run_fav);
        $fav = $row_fav['fav_id'];
       
        ?>

      <?php if($qty > 0){ ?>
              <input type="submit" name="submit" value="Add To Cart" style="clear:both; background: #48c9b0; border: none; color: #fff; font-size: 14px; padding: 10px; cursor: pointer;" /> <a href="cart.php">View Cart</a>
      <?php }else{ ?>

      <?php

   include('config/config.php');
   $id = $_GET['id'];
   $result = mysqli_query($mysqli,"SELECT * FROM product WHERE id=$id");
   $row = mysqli_fetch_assoc($result);
   
   ?>
     <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $row['id']; ?>" id="getUser"><i class="material-icons">add_shopping_cart</i></button>
     <?php } ?>

       <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
             <div class="modal-dialog"> 
                  <div class="modal-content"> 
                  
                       <div class="modal-header"> 
                        <h4 class="modal-title">
                             
                            </h4> 
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                            
                       </div> 
                       <div class="modal-body"> 
                       
                           <div id="modal-loader" style="display: none; text-align: center;">
                            <img src="ajax-loader.gif">
                           </div>
                            
                           <!-- content will be load here -->                          
                           <div id="dynamic-content">
                           
                           </div>
                             
                        </div> 
                        
                        
                 </div> 
              </div>
       </div><!-- /.modal --> 

<script>
$(document).ready(function(){
  
  $(document).on('click', '#getUser', function(e){
    
    e.preventDefault();
    
    var uid = $(this).data('id');  
    $('#dynamic-content').html(''); 
    $('#modal-loader').show();     
    
    $.ajax({
      url: 'getemail.php',
      type: 'POST',
      data: 'id='+uid,
      dataType: 'html'
    })
    .done(function(data){
      console.log(data);  
      $('#dynamic-content').html('');    
      $('#dynamic-content').html(data); 
      $('#modal-loader').hide();     
    })
    .fail(function(){
      $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
      $('#modal-loader').hide();
    });
    
  });
  
});

</script>

<!--      -----------------------------------Add To Whilist ------------------------ -->
       <br><br>

          <?php  if($fav == 0){ ?>
         
            <a href="add_fav.php?id=<?php echo $row_r['id']; ?>" ><i class="material-icons">favorite</i></a>

        <?php }else{ ?>
            <a href="remove_wishlist.php?id=<?php echo $row_r['id']; ?>" ><i class="material-icons">favorite_border</i></a>
        
        <?php } ?>
    
       
         
     
      </div>

      <!--      -----------------------------------Add To Whilist  end------------------------ -->


          
    </div><!-- col8 -->
                    <li class="product-description">
                       
                    </li>
                </ul>
            </div>
        </div>
    </div>
     

<style type="text/css">
    .blog .carousel-indicators {
    left: 0;
    top: auto;
    bottom: -40px;

}

.blog .carousel-indicators li {
    background: #a3a3a3;
    border-radius: 5px;
    width: 25px;
    height: 2px;
}

.blog .carousel-indicators .active {
background: teal;

}
.ftr2{
  background-color: #fff;
  height: 450px;

}
.ftr2 p{
    font-size: 12px;
    color: #7F8C8D;
}

.ftr2 p strong {
    color: #2E405E;
    font-size: 12px;
}
</style>
<script type="text/javascript">
    // optional
        $('#blogCarousel').carousel({
                interval: 5000
        });
</script>
<?php

    include('config/config.php');
    $smilar = mysqli_query($mysqli,"SELECT * FROM product WHERE categories='$categories' ORDER BY id DESC LIMIT 0,4");
    
    
?>
<div class="ftr2">
  <h2 style="text-align: center; color: #5d6d7e; font-weight: bold; font-size: 17px;">Similar Product</h2>
  <br>
<div class="container">
            <div class="row blog">
                <div class="col-md-12">
                    <div id="blogCarousel" class="carousel slide" data-ride="carousel">

                        <ol class="carousel-indicators">
                            <li data-target="#blogCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#blogCarousel" data-slide-to="1"></li>
                        </ol>
                        <div class="carousel-inner">

                            <div class="carousel-item active">
                                <div class="row">
                                  <?php while($row_similar = mysqli_fetch_assoc($smilar)):?>
                                    <div class="col-md-3">
                                        <a href="product.php?id=<?php echo $row_similar['id'] ?>">
                                            <img src="admin/cover/<?php echo $row_similar['cover'] ?>" alt="Image" style="width: 250px; height:250px;">
                                            
                                        </a>
                                        <p><?php echo $row_similar['product_name']; ?></p>
                                        <p><strong>US$<?php echo $row_similar['price']; ?></strong></p>
                                    </div>
                                  <?php endwhile; ?>
                             
                                </div>
                             
                            </div>

                            <div class="carousel-item">
                                <div class="row">
                  <?php

                  include('config/config.php');
                  $smilar2 = mysqli_query($mysqli,"SELECT * FROM product WHERE categories='$categories' ORDER BY id DESC LIMIT 4,4");
                  while($row_similar2 = mysqli_fetch_assoc($smilar2)):
    
                  ?>
          
                                    <div class="col-md-3">
                                        <a href="product.php?id=<?php echo $row_similar2['id'] ?>">
                                           <img src="admin/cover/<?php echo $row_similar2['cover'] ?>" alt="Image" style="width: 250px; height:250px;">
                                        </a>
                                        <p><?php echo $row_similar2['product_name']; ?></p>
                                        <p><strong>US$<?php echo $row_similar2['price']; ?></strong></p>
                                    </div>
                                    <?php endwhile; ?>
                                </div>
                                <!--.row-->
                            </div>
                            <!--.item-->

                        </div>
                        <!--.carousel-inner-->
                            <a class="carousel-control-prev" href="#blogCarousel" role="button" data-slide="prev" style="margin-bottom: 100px; font-size: 10px;">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#blogCarousel" role="button" data-slide="next" style="margin-bottom: 100px; font-size: 10px;">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
                    </div>
               </div>
            </div>
</div>
</div>
<?php include('footer.php'); ?>
</body>
</html>