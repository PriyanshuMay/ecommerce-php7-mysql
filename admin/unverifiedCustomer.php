<?php
require('header.php');
?>
        <div class="container">
            <div class="row">
            <div class="col-lg-9 mx-auto my-4 text-center">
         <h2><span class="badge badge-light">Unverified Accounts</span></h2>
      </div>
                <div class="col-lg-12  mt-5">
                    <div class="table-responsive">
                        <table class='table table-borderless text-center'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th>PHONE</th>
                                    <th>STATUS</th>
                                    <th>REGISTERED</th>
                                    <th>LAST LOGIN</th>
                                    <th>ORDERS</th>
                                    <th>HISTORY</th>
                                    <th>ENABLE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

$per_page = 12;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start_from = ($page-1) * $per_page;
$query = "SELECT * FROM customer WHERE status=0 ORDER BY id DESC LIMIT $start_from, $per_page";
$result = mysqli_query($connect, $query);
while ($row = mysqli_fetch_assoc($result)) {
                                ?>

                                    <tr>
                                        <td>
                                            <span class="badge  badge-light"><?php echo $row['id'] ?></span>
                                        </td>
                                   
                                        <td>
                                            <span class="badge  badge-light"><?php echo $row['name'] ?></span>
                                        </td>
                                        <td>
                                            <span class="badge  badge-light"><?php echo $row['email'] ?></span>
                                        </td>
                                        <td>
                                            <span class="badge  badge-light"><?php echo $row['phone'] ?></span>
                                        </td>
                                        <td>
                                        <?php if ($row['status'] == 0) { ?>
                                        <span class="badge badge-warning">Unverified</span>

                                    <?php } else if ($row['status'] == 1) { ?>
                                        <span class="badge badge-success">Active</span>

                                    <?php } else if ($row['status'] == 2) { ?>
                                        <span class="badge badge-success">Unactive</span>

                                    <?php } else if ($row['status'] == 3) { ?>
                                        <span class="badge badge-info">Disabled</span>

                                    <?php } else {  ?>
                                        <span class="badge badge-danger">Error</span>
                                    <?php  } ?>
                                        </td>
                                        <td>
                                            <span class="badge  badge-light"><?php echo $row['datetym'] ?></span>
                                        </td>
                                        <td>
                                            <span class="badge  badge-light"><?php echo $row['last_login'] ?></span>
                                        </td>
                                        <td>
                                        <a style="color:#F67E29;" href="customerOrder.php?id=<?php echo $row['id']?>" >
                                         <i class="fas fa-info-circle"></i></a>
                                        </td>
                                        <td>
                                        <a style="color:#F67E29;" href="customerHistory.php?id=<?php echo $row['id']?>" >
                                         <i class="fas fa-info-circle"></i></a>
                                        </td>
                                        <td>
                                            <a style="color: red; " class='enable' id='enable_<?= $row['id'] ?>'>
                                              lk  <i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php

                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('pagination.php'); ?>
    
</body>
<script src="https://kit.fontawesome.com/77f6dfd46f.js" crossorigin="anonymous"></script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script src="js/bootbox.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('.enable').click(function() {
            var el = this;
            var id = this.id;
            var splitid = id.split("_");
            var deleteid = splitid[1];
            bootbox.confirm({
                message: "Do you really want to activate this account ?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function(result) {

                    if (result) {

                        $.ajax({
                            url: 'enableCustomer.php',
                            type: 'POST',
                            data: {
                                id: deleteid
                            },
                            success: function(response) {


                                if (response == 1) {
                                    $(el).closest('tr').css('background', 'green');
                                    $(el).closest('tr').fadeOut(800, function() {
                                        $(this).remove();
                                    });
                                } else {
                                    bootbox.alert('Error ! Record not deleted');
                                }

                            }
                        });
                    }

                }
            });

        });


    });
</script>
</html>