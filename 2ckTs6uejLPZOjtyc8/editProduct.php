<?php
require('header.php');
$id = $_GET['id'];
$result = mysqli_query($connect,"SELECT * FROM product WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $code = $_POST['code'];
    $section = $_POST['cat'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $supplier = $_POST['supplier'];
    $MRP = $_POST['MRP'];
    $cost = $_POST['cost'];
    $description = $_POST['description'];
    $temp = explode(".", $_FILES["file"]["name"]);
    $file = round(microtime(true)) . '.' . end($temp);
    $dirpath = realpath(dirname(getcwd()));

    if($_FILES["file"]["name"]){
        move_uploaded_file($_FILES["file"]["tmp_name"], "../uploads/" . $file);
    }
    else{
        $file = $row['file'];
    }

    $sql = "UPDATE product SET name='$name',code='$code',section='$section',category='$category'
    ,brand='$brand',supplier='$supplier',description='$description',MRP='$MRP',cost='$cost',file='$file',modified_date=now() WHERE id = $id ";

    $run = mysqli_query($connect, $sql);

    if ($run) {
        echo "<script>window.open('manageProduct.php','_self')</script>";
       
    } else {
        echo "Error description: " . mysqli_error($connect) ;
    }
}
?>

<div class="container-fluid">
    <div class="row">
    <div class="col-lg-9 mx-auto mt-4 text-center">
         <h2><span class="badge badge-light">Edit Product</span></h2>
      </div>
    <div class="col-lg-9 mx-auto mt-3 text-center">
                    <a href="updateVariant.php?id=<?php echo $row['id'] ?>" class="m-2 btn btn-sm btn-success">
                        <i class="fas fa-wrench mr-2"></i> <b>Update Quantity and Variants</b></a>

                        <a href="editSubImage.php?id=<?php echo $row['id'] ?>" class="m-2 btn btn-sm btn-info">
                        <i class="fa fa-plus-square mr-2"></i> <b>Update Sub-Images</b></a>

                </div>
        <div class="col-lg-6 login-section-wrapper pl-5 p-md-5 pt-2">
            <div class="login-wrapper ml-5">
                <h2 class="text-center mb-4">
                    <span class="badge badge-light">Step 1</span>
                </h2>
                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                    <div class="form-group">
                        <label for="email">Title</label>
                        <input type="text"  value="<?php echo $row['name'] ?>" name="name" class="form-control" id="email" placeholder="Product Name" required />
                    </div>
                    <div class="form-group">
                        <label for="email">Code</label>
                        <input type="text"  value="<?php echo $row['code'] ?>" name="code" class="form-control" id="email" placeholder=" XYZ-000" required />
                    </div>
                    <div class="form-group mb-4">
                        <label for="password">Section</label>
                        <select id="email" class="form-control" name="cat">
                            <?php
                            $get_cat = "SELECT * FROM section";
                            $run_cat = mysqli_query($connect, $get_cat);
                            while ($row_cat = mysqli_fetch_array($run_cat)) {
                                $id = $row_cat['section_id'];
                                $name = $row_cat['section_name'];

                                echo "<option value='$id'>$name</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="password">Category</label>
                        <select id="email" class="form-control" name="category">
                            <?php
                            $get_category = "SELECT * FROM category";
                            $run_category = mysqli_query($connect, $get_category);
                            while ($row_category = mysqli_fetch_array($run_category)) {
                                $category_id = $row_category['category_id'];
                                $category_name = $row_category['category_name'];
                                echo "<option value='$category_id'>$category_name</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="email">Brand</label>
                        <select class="form-control" name="brand">
                            <?php

                            $get_brand = "SELECT * FROM brand";
                            $run_brand = mysqli_query($connect, $get_brand);
                            while ($row_brand = mysqli_fetch_array($run_brand)) {
                                $brand_id = $row_brand['brand_id'];
                                $brand_title = $row_brand['brand_name'];

                                echo "<option value='$brand_id'>$brand_title</option>";
                            }
                            ?>
                            
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="email">Supplier</label>
                        <select class="form-control" name="supplier">
                            <?php

                            $get_brand = "SELECT * FROM supplier";
                            $run_brand = mysqli_query($connect, $get_brand);
                            while ($row_brand = mysqli_fetch_array($run_brand)) {
                                $supplier_id = $row_brand['supplier_id'];
                                $supplier_title = $row_brand['supplier_name'];

                                echo "<option value='$supplier_id'>$supplier_title</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                    <label for="email">Provide A Description</label>
                    <textarea type="text" name="description" class="form-control" id="email" rows="4" cols="50" required /><?php echo $row['description'] ?></textarea>
                </div>
            </div>
        </div>
        <div class="col-lg-6 login-section-wrapper p-md-5 pt-2">
            <div class="login-wrapper">
                <h2 class="text-center mb-4">
                    <span class="badge  badge-light">Step 2</span>
                </h2>
                <div class="form-group mb-4">
                    <label for="email">Other's Price</label>
                    <input type="number"  value="<?php echo $row['MRP'] ?>" name="MRP" class="form-control" id="email" placeholder="1000" required />
                </div>
                <div class="form-group mb-4">
                    <label for="email">Your's Price</label>
                    <input type="number"  value="<?php echo $row['cost'] ?>" name="cost" class="form-control" id="email" placeholder="750" required />
                </div>
                <div class="form-group mb-4">
                    <label for="email">Total Units In Stock</label>
                    <input type="number" value="<?php echo $row['qty'] ?>" class="form-control" id="email" disabled />
                 </div>
               <file class="main_full">
                    <div class="container-file">
                        <div class="panel">
                        <img class="mb-3" width="200" height="200" src="../uploads/<?php echo $row['file'] ?>" alt="product image">
                        <br>   
                            <div class="button_outer">
                                <div class="btn_upload">
                                    <input type="file" id="upload_file" name="file" />
                                <b> Change Image </b>
                                </div>
                                <div class="processing_bar"></div>
                                <div class="success_box"></div>
                            </div>
                        </div>
                        <div class="error_msg"></div>
                        <div class="uploaded_file_view" id="uploaded_view">
                            <span class="file_remove">X</span>
                        </div>
                    </div>
                </file>
                <input type="submit" name="submit" id="submit login" class="btn btn-block login-btn" value="Update">
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</body>
<script src="https://kit.fontawesome.com/77f6dfd46f.js" crossorigin="anonymous"></script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script src="js/bootbox.min.js"></script>
<script src="js/jquery-3.3.1.js"></script>
<script>
var btnUpload = $("#upload_file"),
		btnOuter = $(".button_outer");
	btnUpload.on("change", function(e){
		var ext = btnUpload.val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
			$(".error_msg").text("Not an Image...");
		} else {
			$(".error_msg").text("");
			btnOuter.addClass("file_uploading");
			setTimeout(function(){
				btnOuter.addClass("file_uploaded");
			},3000);
			var uploadedFile = URL.createObjectURL(e.target.files[0]);
			setTimeout(function(){
				$("#uploaded_view").append('<img src="'+uploadedFile+'" />').addClass("show");
			},3500);
		}
	});
	$(".file_remove").on("click", function(e){
		$("#uploaded_view").removeClass("show");
		$("#uploaded_view").find("img").remove();
		btnOuter.removeClass("file_uploading");
		btnOuter.removeClass("file_uploaded");
	});
</script>

</html>