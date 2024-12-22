<?php

require 'config/function.php';

if(isset($_POST['loginBtn']))
{

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if($email != '' && $password != '')
    {
        $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if ($result)
        {
            if(mysqli_num_rows($result) == 1) 
            {
                $row = mysqli_fetch_assoc($result);
                $storedPassword = $row['password']; // Fetch the stored password (plaintext in this case)

                // Compare the entered password with the stored password directly (plaintext comparison)
                if($password != $storedPassword)
                {
                    redirect('index.php', 'Invalid Email or Password!'); 
                }

                // Set session variables for user details
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_type'] = $row['type'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['img'] = $row['image'];

                // Check user type and redirect accordingly
                if ($row['type'] == 'admin') {
                    // Admin redirect
                    redirect('admin/index.php', 'Logged In Successfully as Admin');
                } else if ($row['type'] == 'user') {
                    // Regular user redirect
                    redirect('user/index.php', 'Logged In Successfully');
                }

                

                redirect('admin/index.php', 'Logged In Successfully');
            }
            else
            {
                redirect('index.php', 'Invalid Email Address!'); 
            }
        }
        else
        {
            redirect('index.php', 'Somthing Went Wrong!');
        }
    }
    else
    {
        redirect('index.php','All feilds are mandetory');
    }

}

?>