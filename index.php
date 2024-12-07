<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Post</title>
    <!-- Bootstrap CSS link (Make sure to include this in your HTML head) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!---comment pop up library------------------------------------>
    <!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>    
    <!-----------end pop --------------------------------------------->
</head>
<body> <input type="hidden" value="<?php if(isset($_SESSION['user_id'])){ echo $_SESSION['user_id'];} ?>" id="user_session">
    <?php
    include ("admin/db_conn.php");
    $records_per_page = 10;
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = (int) $_GET['page'];
    } 
    else {
    $current_page = 1;
    }
    $start_from = ($current_page - 1) * $records_per_page;
    $sql = "SELECT * FROM blog LIMIT $start_from, $records_per_page";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {?>
    <div class="container mt-5">
        <div class="row">
             <div class="col-12">
                <h1 class="text-center"><?php echo $row['title'];?></h1>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <img src="blogimage/<?php echo $row['image'];?>" alt="Blog Image" class="img-fluid rounded">
            </div>

           
            <div class="col-md-6">
                <p>
                   <?php echo $row['short_description'];?>
                   <p style="float:right"> Publish On : <?php echo date("Y-m-d", strtotime($row['publish_date']));
                   ?></p> 
                </p>

                <h5>Comment</h5>
                <table>
                <button type="button" class="btn btn-primary openModal" id="openModal" data-id="<?php echo $row['id'];?>">
                 Comment
                </button>
        </br>
                <ul>
                    <?php $comment_qry="select comment from comment where blogid=".$row['id']." AND status=1";
                          $result_of_comment=mysqli_query($conn,$comment_qry);
                          if ($result_of_comment) {
                            while ($cmt = mysqli_fetch_assoc($result_of_comment)) {?>
                            <li><?php echo $cmt['comment']?></li>
                    <?php } }?>
            </ul>
   
                </table>
                
            </div>
        </div>
    </div>
    <?php } } ?>
   
   <?php
$sql_total = "SELECT COUNT(*) FROM blog";
$result_total = mysqli_query($conn, $sql_total);
$row_total = mysqli_fetch_row($result_total);
$total_records = $row_total[0];
$total_pages = ceil($total_records / $records_per_page);

echo "<div class='pagination justify' style='padding-left:25%'>";
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $current_page) {
        // Current page is highlighted
        echo "<span class='current'>$i</span> ";
    } else {
        echo "<a href='?page=$i'><b>$i</b></a> ";
    }
}
echo "</div>";
?>
    <!-------------end-->

    <!-----------------------------pop up for comment---------------->
    <!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Comment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="blog_id" id="blog_id">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'];?>" id="user_id">
        <textarea class="form-control" row="2" cols="10" id="comment_text"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Closedd</button>
        <button type="button" class="btn btn-primary" id="add_commnet">Add Comments</button>
      </div>
    </div>
  </div>
</div>

<!----------------------login popup----------------------------------------->
<div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">User Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="" >
            <div class="form-group">
            <label>USER</label>
            <input type="text" name="user" class="form-control" placeholder="Enter User" id="username">
            </div>
            <div class="form-group">
            <label>PASSWORD</label>
            <input type="password" class="form-control" name="pass" placeholder="Enter User" id="userpass">
            </div>
               </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="user_login">Login</button>
      </div>
    </div>
  </div>
</div>
<!-------login end------------------------------------------------>

    <!-----------------------------end pop up of comment-------------->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>





    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Button Click to Show ID in Modal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- Button that will open the modal and pass ID -->






<script>
  $(document).ready(function () { 
    $('.openModal').on('click', function() { 
      var id = $(this).data('id');
      var user=$("#user_session").val();
      if (user.trim() === "") {
        $('#login').modal('show');
      }
      else
      {

      $('#blog_id').val(id);
      $('#exampleModal').modal('show');
      }
    });


    $('#user_login').on('click', function (e) { 
        e.preventDefault(); 
      var username=$("#username").val();
      var password=$("#userpass").val();
         

        $.ajax({
            url: 'user_login.php',
            type: 'POST',
            data: {'username':username,'password':password},
            success: function(response) { 
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    alert('login  successfully!');
                    window.location.href = "index.php";
                    
                } else {
                    $('#error-message').text(data.message).show();
                }
            },
            error: function() {
                $('#error-message').text('There was an error with the request. Please try again.').show();
            }
        });
    });


    $('#add_commnet').on('click', function (e) { 
        e.preventDefault();  
      var blog_id=$("#blog_id").val();
      var user_id=$("#user_id").val();
      var comment=$("#comment_text").val();
     
      

        $.ajax({
            url: 'add_comment.php',
            type: 'POST',
            data: {'blog_id':blog_id,'user_id':user_id,'comment':comment},
            success: function(response) { 
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    alert('comment added successfully!');
                    window.location.href = "index.php";
                    
                } else {
                    $('#error-message').text(data.message).show();
                }
            },
            error: function() {
                $('#error-message').text('There was an error with the request. Please try again.').show();
            }
        });
    });
  });
</script>

</body>
</html>

</body>
</html>



