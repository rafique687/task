<?php  
session_start();
include "admin/db_conn.php";

if (isset($_POST['username']) && isset($_POST['password'])) {

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$username = test_input($_POST['username']);
	$password = test_input($_POST['password']);
	

	if (empty($username)) {
		echo json_encode(['status' => 'error', 'message' => 'User name Requird.']);
	}
    else if (empty($password)) {
		echo json_encode(['status' => 'error', 'message' => 'password requird.']);
	}
    else {

		// Hashing function
		$password = md5($password);
        
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
        	
        	$row = mysqli_fetch_assoc($result);
        	if ($row['password'] === $password && $row['username'] == $username) {
        		$_SESSION['name'] = $row['name'];
        		$_SESSION['user_id'] = $row['id'];
        		$_SESSION['role'] = $row['role'];
        		

        		echo json_encode(['status' => 'success', 'message' => 'login successfull.']);

        	}
        }
        else {
        		
                echo json_encode(['status' => 'error', 'message' => 'User pass not matched.']);
        	}
        }
    }