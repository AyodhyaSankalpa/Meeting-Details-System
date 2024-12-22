<?php

require '../config/function.php';


$paraResultId = checkParamId('id');

if(is_numeric($paraResultId))
{

    $divisionId = validate($paraResultId);

    $division = getById('divisions', $divisionId);

    if($division['status'] == 200)
    {
        $response = delete('divisions', $divisionId);
        if($response)
        {
            redirect('divisions.php', 'Division Deleted Successfully.');
        }
        else
        {
            redirect('divisions.php', 'Somthing Went Wrong.'); 
        }
    }
    else
    {
        redirect('divisions.php', $division['message']);
    }

}else{
    redirect('divisions.php', 'Somthing Went Wrong.');
}



?>