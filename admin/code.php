<?php

include ('../config/function.php');

if (isset($_POST['saveUser'])) 
{
	$name = validate($_POST['name']);
	$email = validate($_POST['email']);
	$designation = validate($_POST['designation']);
	$password = validate($_POST['password']);
	$type = validate($_POST['type']);

	if($name !='' && $email !='' && $password !=''){

		// Check if email is already used
		$emailCheck = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

		if ($emailCheck && mysqli_num_rows($emailCheck) > 0) 
		{
			redirect('add-users.php', 'Email already used by another user.');
		}

		// Hash password securely
		//$bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

        if($_FILES['image']['size'] > 0)
            {
                $path = "../uploads/profile";
                $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                $filename = time().'.'.$image_ext;

                move_uploaded_file($_FILES['image']['tmp_name'], $path."/".$filename);

                $finalImage = "../uploads/profile/".$filename;
            }
            else
            {
                $finalImage = '';
            }

		// Prepare data for insertion
		$data = [
			'name' => $name,
			'email' => $email,
			'designation' => $designation,
			'password' => $password,
            'image' =>$finalImage,
			'type' => $type
		];

		// Insert into admins table
		$result = insert('users', $data);
		if($result){
			redirect('users.php', 'User created successfully.');
		}else{
			redirect('add-users.php', 'Something went wrong!');
		}

	}else{
		// If required fields are missing
		redirect('add-users.php', 'Please fill required fields.');
	}
}


if(isset($_POST['updateUser']))
{
	$userId = validate($_POST['user_id']);

	$userData = getById('users',$userId);
	if($userData['status'] != 200){
		redirect('users-edit.php?id='.$userId, 'Please fill required fields.');
	}

	$name = validate($_POST['name']);
	$email = validate($_POST['email']);
	$designation = validate($_POST['designation']);
	$password = validate($_POST['password']);
	$type = validate($_POST['type']);
	

	$EmailCheckQuery = "SELECT * FROM users WHERE email='$email' AND id!='$userId'";
	$checkResult = mysqli_query($conn, $EmailCheckQuery);
	if($checkResult){
		if(mysqli_num_rows($checkResult) > 0){
			redirect('users-edit.php?id='.$userId,'Email Already used by another user');
		}
	}

	if($name !='' && $email !='')
	{
        if($_FILES['image']['size'] > 0)
            {
                $path = "../uploads/profile";
                $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                $filename = time().'.'.$image_ext;

                move_uploaded_file($_FILES['image']['tmp_name'], $path."/".$filename);

                $finalImage = "../uploads/profile/".$filename;

                $deleteImage = "../".$userData['data']['image'];
                if(file_exists($deleteImage))
                {
                    unlink($deleteImage);
                }
            }
            else
            {
                $finalImage = $userData['data']['image'];
            }
		
		$data = [
			'name' => $name,
			'email' => $email,
			'designation' => $designation,
			'password' => $password,
            'image' =>$finalImage,
			'type' => $type
		];

		// Insert into admins table
		$result = update('users', $userId, $data);

		if($result){
			redirect('users.php?id='.$userId, 'User Updated Successfully.');
		}else{
			redirect('users-edit.php?id='.$userId, 'Something went wrong!');
		}

	}else{
		// If required fields are missing
		redirect('users-edit.php', 'Please fill required fields.');
	}
}

if (isset($_POST['saveDivision'])) 
{
	$divisioncode = validate($_POST['divisioncode']);
	$divisionname = validate($_POST['divisionname']);

	$data = [
		'division_code' => $divisioncode,
		'division_name' =>$divisionname,
	];

	// Insert into admins table
	$result = insert('divisions', $data);
	if($result){
		redirect('divisions.php', 'Division created successfully.');
	}else{
		redirect('add-divisions.php', 'Something went wrong!');
	}

}

if (isset($_POST['updateDivision'])) {
    $divisionId = validate($_POST['division_id']);

    $divData = getById('divisions', $divisionId);
    if ($divData['status'] != 200) {
        redirect('divisions-edit.php?id=' . $divisionId, 'Please fill required fields.');
    }

    $divisioncode = validate($_POST['divisioncode']);
    $divisionname = validate($_POST['divisionname']);

    // Check for required fields
    if (empty($divisioncode) || empty($divisionname)) {
        redirect('divisions-edit.php?id=' . $divisionId, 'Please fill required fields.');
    }

    // Use prepared statements to prevent SQL injection
    $codecheckQuery = "SELECT * FROM divisions WHERE division_code=? AND id!=?";
    $stmt = $conn->prepare($codecheckQuery);
    $stmt->bind_param('si', $divisioncode, $divisionId);
    $stmt->execute();
    $checkResult = $stmt->get_result();

    if ($checkResult) {
        if ($checkResult->num_rows > 0) {
            redirect('divisions-edit.php?id=' . $divisionId, 'Division Code Already used by another user');
        }
    } else {
        // Handle query execution error
        redirect('divisions-edit.php?id=' . $divisionId, 'Database query failed.');
    }

    $data = [
        'division_code' => $divisioncode,
        'division_name' => $divisionname,
    ];

    // Update the divisions table
    $result = update('divisions', $divisionId, $data);

    if ($result) {
        redirect('divisions.php?id=' . $divisionId, 'User Updated Successfully.');
    } else {
        redirect('divisions-edit.php?id=' . $divisionId, 'Something went wrong!');
    }
}

if (isset($_POST['saveDesignation'])) 
{
	$designationname = validate($_POST['designationname']);
	$description = validate($_POST['description']);

	$data = [
		'designation' => $designationname,
		'description' =>$description,
	];

	// Insert into admins table
	$result = insert('designation', $data);
	if($result){
		redirect('add-designations.php', 'Designation created successfully.');
	}else{
		redirect('add-designations.php', 'Something went wrong!');
	}

}


if (isset($_POST['updateProfile'])) 
{
    $user_id = $_POST['user_id'];
    $new_password = validate( $_POST['password']);

    // Update the password in the database
    $query = "UPDATE users SET password='$new_password' WHERE id='$user_id'";
    
    if (mysqli_query($conn, $query)) {
        // Redirect with success message
		redirect('index.php', 'Password updated successfully!');
        
    } else {
        // Redirect with error message
		redirect('profile.php', 'Failed to update password!');
        
    }
}