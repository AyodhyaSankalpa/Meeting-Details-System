<?php

include ('../config/function.php');

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

if (isset($_POST['saveMeeting'])) {
    // Fetch the values from the form
    $userId = validate($_POST['userid']);
    $date = validate($_POST['date']);
    $division = validate($_POST['division']);
    $topic = validate($_POST['topic']);
    $present_names = $_POST['present_name']; // Array of present attendees' names
    $designations = $_POST['designation']; // Array of present attendees' designations
    $descriptions = $_POST['description']; // Array of descriptions
    $options = $_POST['option']; // Array of selected options
    
    // Insert the meeting details into the 'details' table
    $meetingQuery = "INSERT INTO details (date, division, topic, description, userid) VALUES ('$date', '$division', '$topic', '', '$userId')";
    
    if (mysqli_query($conn, $meetingQuery)) {
        $meetingId = mysqli_insert_id($conn); // Get the last inserted meeting ID
        
        // Insert attendees into 'meeting_attendees' table
        if (!empty($present_names) && !empty($designations)) {
            for ($i = 0; $i < count($present_names); $i++) {
                $attendeeName = validate($present_names[$i]);
                $attendeeDesignation = validate($designations[$i]);

                if (!empty($attendeeName) && !empty($attendeeDesignation)) {
                    $attendeeQuery = "INSERT INTO meeting_attendees (meeting_id, name, designation) VALUES ('$meetingId', '$attendeeName', '$attendeeDesignation')";
                    mysqli_query($conn, $attendeeQuery);
                }
            }
        }

        // Insert descriptions and options into 'meeting_description_options' table
        if (!empty($descriptions) && !empty($options)) {
            for ($i = 0; $i < count($descriptions); $i++) {
                $descriptionText = validate($descriptions[$i]);
                $optionSelected = validate($options[$i]);

                if (!empty($descriptionText) && !empty($optionSelected)) {
                    $descriptionQuery = "INSERT INTO meeting_description_options (meeting_id, description, option_selected) VALUES ('$meetingId', '$descriptionText', '$optionSelected')";
                    mysqli_query($conn, $descriptionQuery);
                }
            }
        }

        // Redirect with success message
        redirect('meeting.php', 'Meeting added successfully!');
    } else {
        // Redirect with error message if something goes wrong
        redirect('add-meeting.php', 'Failed to add meeting.');
    }
}


if (isset($_POST['updateMeeting'])) {
    $detailsId = validate($_POST['details_id']); // The ID of the meeting to update
    $userId = validate($_POST['userid']);
    $date = validate($_POST['date']);
    $division = validate($_POST['division']);
    $topic = validate($_POST['topic']);
    $description = validate($_POST['description']);
    
    // Update the 'details' table
    $updateMeetingQuery = "UPDATE details SET date = '$date', division = '$division', topic = '$topic', description = '$description', userid = '$userId' WHERE id = '$detailsId'";
    
    if (mysqli_query($conn, $updateMeetingQuery)) {
        
        // Update attendees in 'meeting_attendees' table
        $present_names = $_POST['present_name'];
        $designations = $_POST['designation'];

        // First, delete all previous attendees for the meeting
        $deleteAttendeesQuery = "DELETE FROM meeting_attendees WHERE meeting_id = '$detailsId'";
        mysqli_query($conn, $deleteAttendeesQuery);

        // Insert new attendees
        for ($i = 0; $i < count($present_names); $i++) {
            $attendeeName = validate($present_names[$i]);
            $attendeeDesignation = validate($designations[$i]);

            if (!empty($attendeeName) && !empty($attendeeDesignation)) {
                $attendeeQuery = "INSERT INTO meeting_attendees (meeting_id, name, designation) VALUES ('$detailsId', '$attendeeName', '$attendeeDesignation')";
                mysqli_query($conn, $attendeeQuery);
            }
        }

        // Update descriptions and options in 'meeting_description_options' table
        $descriptions = $_POST['description'];
        $options = $_POST['option'];

        // First, delete all previous description for the meeting
        $deleteDescriptionQuery = "DELETE FROM meeting_description_options WHERE meeting_id = '$detailsId'";
        mysqli_query($conn, $deleteDescriptionQuery);

        // Delete previous descriptions and options
        $descriptions = $_POST['description'];
        $options = isset($_POST['option']) ? $_POST['option'] : [];
        
        for ($i = 0; $i < count($descriptions); $i++) {
            $descriptionText = validate($descriptions[$i]);
            $optionSelected = isset($options[$i]) ? validate($options[$i]) : ''; // Handle missing radio button value
        
            if (!empty($descriptionText) && !empty($optionSelected)) {
                $descriptionQuery = "INSERT INTO meeting_description_options (meeting_id, description, option_selected) VALUES ('$detailsId', '$descriptionText', '$optionSelected')";
                mysqli_query($conn, $descriptionQuery);
            }
        }
        

        // Redirect with success message
        redirect('meeting.php?id='.$detailsId, 'Meeting details updated successfully.');
    } else {
        redirect('edit-meeting.php?id=' . $detailsId, 'Something went wrong!');
    }
}

