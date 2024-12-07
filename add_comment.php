<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "admin/db_conn.php";
    
     if(isset($_POST['comment']))
     {
               $comment=$_POST['comment'];
               $blogid=$_POST['blog_id'];
               $userid=$_POST['user_id'];
                $sql = "INSERT INTO  comment (comment, blogid,commet_by) VALUES ('$comment', '$blogid','$userid')";
                if (mysqli_query($conn, $sql)) {
                echo json_encode(['status' => 'success', 'message' => 'Comment Added successfully!']);
                }
                else
                {
                    echo json_encode(['status' => 'success', 'message' => 'Propblem to Comment add!']); 
                }
    }
     else {
                
                echo json_encode(['status' => 'error', 'message' => 'Failed to comment.']);
            }
        
}
?>
