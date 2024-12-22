<?php

require '../config/function.php';


$paraResultId = checkParamId('id');

if(is_numeric($paraResultId))
{

    $desId = validate($paraResultId);

    $designation = getById('designation', $desId);

    if($designation['status'] == 200)
    {
        $response = delete('designation', $desId);
        if($response)
        {
            redirect('designations.php', 'Designation Deleted Successfully.');
        }
        else
        {
            redirect('designations.php', 'Somthing Went Wrong.'); 
        }
    }
    else
    {
        redirect('designations.php', $division['message']);
    }

}else{
    redirect('designations.php', 'Somthing Went Wrong.');
}



?>