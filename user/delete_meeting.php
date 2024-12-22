<?php

require '../config/function.php';

// Check if a valid 'id' parameter is passed
$paraResultId = checkParamId('id');

if (is_numeric($paraResultId)) {

    // Validate the passed ID
    $detailsID = validate($paraResultId);

    // Get the meeting details by ID
    $details = getById('details', $detailsID);

    if ($details['status'] == 200) {
        
        // Start a transaction to ensure atomic operations
        beginTransaction();

        // Delete associated data from 'meeting_attendees' table
        $deleteAttendees = deleteByCondition('meeting_attendees', 'meeting_id', $detailsID);

        // Delete associated data from 'meeting_description_options' table
        $deleteDescriptions = deleteByCondition('meeting_description_options', 'meeting_id', $detailsID);

        // Delete the main meeting record from 'details' table
        $deleteDetails = delete('details', $detailsID);

        // Check if all deletions were successful
        if ($deleteAttendees && $deleteDescriptions && $deleteDetails) {
            commitTransaction(); // Commit the transaction
            redirect('meeting.php', 'Meeting  record deleted successfully.');
        } else {
            rollbackTransaction(); // Rollback in case of any error
            redirect('meeting.php', 'Something went wrong during deletion.');
        }

    } else {
        // Redirect if the meeting details are not found
        redirect('meeting.php', $details['message']);
    }

} else {
    // Redirect if the passed ID is not valid
    redirect('meeting.php', 'Something went wrong.');
}

?>
