<?php 
    include 'data_service.php';
    include 'connect.php';

    if(!empty(trim($_POST['user'])) && !empty(trim($_POST['password'])))
    {
        try
        {
            $name = $_POST['user'];
            $password = $_POST['password'];

            $row = selectFrom("SELECT id, username, moderator, password FROM users WHERE username = (:param0)", $name);

            if($name == $row['username'] && password_verify($password, $row['password']))
            {
                // header('Location: ../index.php?invaliduser=1');
                // $_SESSION['user'] = [ 'name' => $name, 'id' => $row['id'], 'mod' =>  $row['moderator'] ];
            }
            else
            {
            }
        }
        catch (Exception $e)
        {
        }
    }
    else
    {
    }
?>