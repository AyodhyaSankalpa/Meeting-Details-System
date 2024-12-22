<?php 
session_start();
require 'dbcon.php';

// // input field validation
// function validate($inputData)
// {
// 	global $conn;
// 	$validateData = mysqli_real_escape_string($conn, $inputData);
// 	return trim($validateData);
// }

function validate($data) {
    global $conn;
    
    if (is_array($data)) {
        // If data is an array, validate each element
        return array_map('validate', $data);
    } else {
        // If data is a string, trim and escape it
        return mysqli_real_escape_string($conn, trim($data));
    }
}


// redirect from one page to another page with a message
function redirect($url, $status)
{
	$_SESSION['status'] = $status;
	header('Location: '.$url);
	exit(0);
}

// display messages or status after any process
function alertMessage()
{
	if (isset($_SESSION['status'])) {
	    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		    	<h6>'.$_SESSION['status'].'</h6>
		   		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		    </div>';
		unset($_SESSION['status']);
	}
}

// insert record using this function
function insert($tableName, $data)
{
	global $conn;

	$table = validate($tableName);

	$columns = array_keys($data);
	$values = array_values($data);

	$finalColumn = implode(',', $columns);
	$finalValue = "'" .implode("', '", $values). "'";

	$query = "INSERT INTO $table ($finalColumn) VALUES ($finalValue)";
	$result = mysqli_query($conn, $query);

	return $result;
}

// update data using this function
function update($tableName, $id, $data)
{
	global $conn;

	$table = validate($tableName);
	$id = validate($id);

	$updateDataString = "";

	foreach ($data as $column => $value) {
		$updateDataString .= $column.'='."'$value',";
	}

	$finalUpdateData = substr(trim($updateDataString),0,-1);

	$query = "UPDATE $table SET $finalUpdateData WHERE id='$id'";
	$result = mysqli_query($conn, $query);

	return $result;
}

// retrieve all records from a table
function getAll($tableName, $status = NULL)
{
	global $conn;

	$table = validate($tableName);
	$status = validate($status);

	if ($status == 'status') 
	{
		$query = "SELECT * FROM $table WHERE status='0'";
	} else 
	{
		$query = "SELECT * FROM $table";
	}

	return mysqli_query($conn, $query);
}

// retrieve record by id
function getById($tableName, $id)
{
	global $conn;

	$table = validate($tableName);
	$id = validate($id);

	$query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	if ($result) {
		if (mysqli_num_rows($result) == 1) {

			$row = mysqli_fetch_assoc($result);
			$response = [
				'status' => 200,
				'data' => $row,
				'message' => 'Record Found'
			];
			return $response;

		} else {

			$response = [
				'status' => 404,
				'message' => 'No Data Found'
			];
			return $response;

		}
	} else {

		$response = [
			'status' => 500,
			'message' => 'Something Went Wrong'
		];
		return $response;
		
	}
}

// delete data from database using id
function delete($tableName, $id)
{
	global $conn;

	$table = validate($tableName);
	$id = validate($id);

	$query = "DELETE FROM $table WHERE id='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	return $result;
}

function checkParamId($type)
{
	if(isset($_GET[$type]))
	{
		if($_GET[$type] !='')
		{
			return $_GET[$type];
		}
		else
		{
			return '<h5>No Id Found</h5>';
		}

	}
	else
	{
		return '<h5>No Id Given</h5>';
	}

}

function logoutSession()
{
	unset($_SESSION['loggedIn']);
	unset($_SESSION['loggedInUser']);
}

function selectAll($table, $condition = "")
{
    global $conn;
    $query = "SELECT * FROM $table";
    if ($condition != "") {
        $query .= " WHERE $condition";
    }
    return mysqli_query($conn, $query);
}

// additional update function for meeting details
function getAttendeesByMeetingId($meetingId) {
    global $conn; // Assuming you're using a global connection variable

    $query = "SELECT * FROM meeting_attendees WHERE meeting_id = '$meetingId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return false;
    }
}

function getDescriptionsByMeetingId($meetingId) {
    global $conn; // Use the global connection variable if it's declared elsewhere

    $query = "SELECT * FROM meeting_description_options WHERE meeting_id = '$meetingId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return false;
    }
}



// additional delete function for meeting details
function deleteByCondition($table, $column, $value) {
    global $conn;
    $query = "DELETE FROM $table WHERE $column = '$value'";
    return mysqli_query($conn, $query);
}

function beginTransaction() {
    global $conn;
    mysqli_begin_transaction($conn);
}

function commitTransaction() {
    global $conn;
    mysqli_commit($conn);
}

function rollbackTransaction() {
    global $conn;
    mysqli_rollback($conn);
}



?>
