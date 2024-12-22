<?php

require '../config/function.php';


$paraResultId = checkParamId('id');

if(is_numeric($paraResultId))
{

    $userId = validate($paraResultId);

    $user = getById('users', $userId);
    if($user['status'] == 200)
    {
        $userDeleteRes = delete('users', $userId);
        if($userDeleteRes)
        {
            
            $deleteImage = "../".$user['data']['image'];
            if(file_exists($deleteImage)){
                unlink($deleteImage);
            }
            redirect('users.php', 'User Deleted Successfully.');
        }
        else
        {
            redirect('users.php', 'Somthing Went Wrong.'); 
        }
    }
    else
    {
        redirect('users.php', $admin['message']);
    }
    //echo $adminId;

}else{
    redirect('users.php', 'Somthing Went Wrong.');
}



?>