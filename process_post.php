<?php
    require 'connect.php';
    include 'ImageResize.php';
    include 'ImageResizeException.php';
    use Gumlet\ImageResize;

    $error = false;
    session_start();

    if(isset($_POST['action']))
    {
        if($_POST['command'] == 'Create')
        {
            $nRows = $db->query('select count(*) from content')->fetchColumn(); 
            $username = $_SESSION['user']['name'];

            if(!empty(trim($_POST['title'])))
            {
                function file_upload_path($original_filename, $upload_subfolder_name = 'img-posts') {
                    $current_folder = dirname(__FILE__);
                    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
                    return join(DIRECTORY_SEPARATOR, $path_segments);
                }

                function file_is_an_image($temporary_path, $new_path) {
                    $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
                    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
                    
                    $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
                    $actual_mime_type        = mime_content_type($temporary_path);
            
                    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
                    $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
                    
                    return $file_extension_is_valid && $mime_type_is_valid;
                }

                $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
                $valid = false;

                if ($image_upload_detected) {
                    $image_filename       = $_FILES['image']['name'];
                    $temporary_image_path = $_FILES['image']['tmp_name'];
                    $new_image_path       = file_upload_path($image_filename);

                    if (file_is_an_image($temporary_image_path, $new_image_path)) 
                    { 
                        move_uploaded_file($temporary_image_path, $new_image_path);

                        $image = new ImageResize($new_image_path);
                        $image->resizeToWidth(75);
                        $image->save('./img-posts/'.$username.'_'.$nRows.'_thumbnail.'.pathinfo($image_filename, PATHINFO_EXTENSION));

                        $image = new ImageResize($new_image_path);
                        $image->save('./img-posts/'.$username.'_'.$nRows.'.'.pathinfo($image_filename, PATHINFO_EXTENSION));
                        $valid = true;
                    }
                }

                $query = "SELECT id FROM users WHERE username = :username";
                $values = $db->prepare($query);
                $values->bindValue(':username', $_SESSION['user']['name']);        
                $values->execute();
                $row = $values->fetch();

                if(!isset($_FILES['image']))
                {
                    $subbreddit = filter_input(INPUT_POST, 'subbreddit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $title      = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $content    = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $query     = "INSERT INTO content (title, post, userid, posttype, imagename, thumbnail, votes, downvotes, subbreddit) values (:title, :content, :user, 't', '', 'text.png', 1, 0, :subbreddit)";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':title', $title);
                    $statement->bindValue(':user', $row['id']);
                    $statement->bindValue(':content', htmlspecialchars($content, ENT_QUOTES));
                    $statement->bindValue(':subbreddit', $subbreddit);
                    $statement->execute();
                }
                else
                {
                    if($valid)
                    {
                        $subbreddit = filter_input(INPUT_POST, 'subbreddit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $title      = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $query     = "INSERT INTO content (title, post, userid, posttype, imagename, thumbnail, votes, downvotes, subbreddit) values (:title, 'null', :user, 'l', :fileN, :thumbnail, 1, 0, :subbreddit)";
                        $statement = $db->prepare($query);
                        $statement->bindValue(':title', $title);
                        $statement->bindValue(':user', $row['id']);
                        $statement->bindValue(':fileN', $username.'_'.$nRows.'.'.pathinfo($image_filename, PATHINFO_EXTENSION));
                        $statement->bindValue(':thumbnail', $username.'_'.$nRows.'_thumbnail.'.pathinfo($image_filename, PATHINFO_EXTENSION));
                        $statement->bindValue(':subbreddit', $subbreddit);
                        $statement->execute();
                    }
                }
                
                header('Location: index.php');
            }
            else
            {
                $error = true;
            }
        }

        if($_POST['command'] == 'Comment')
        {
            $postid = filter_input(INPUT_GET, 'postid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $userid = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $query     = "INSERT INTO comments (content, userid, votes, postid) VALUES (:content, :userid, 1, :postid)";
            $statement = $db->prepare($query);
            $statement->bindValue(':content', $content);
            $statement->bindValue(':userid', $userid);
            $statement->bindValue(':postid', $postid);
            $statement->execute();

            header('Location: post.php?id='.$postid.'');
        }

        if($_POST['command'] == 'Login')
        {
            if(!empty(trim($_POST['name'])) && !empty(trim($_POST['password'])))
            {
                try
                {
                    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $password = $_POST['password'];
    
                    $query = "SELECT id, username, password FROM users WHERE username = (:user)";
                    $values = $db->prepare($query);
                    $values->bindValue(':user', $name);
                    $values->execute();
                    $row = $values->fetch();
    
                    if($name == $row['username'] && password_verify($password, $row['password']))
                    {
                        $_SESSION['user'] = [ 'name' => $name, 'password' => $password, 'id' => $row['id'], 'mod' => true ];
                    }
                    else
                    {
                        header('Location: index.php?invaliduser=1');
                    }

                    header('Location: index.php');
                }
                catch (Exception $e)
                {
                    header('Location: index.php?invaliduser=1');
                }
            }
            else
            {
                header('Location: index.php?invaliduser=1');
            }
        }

        if($_POST['command'] == 'Create_User')
        {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];

            $query     = "INSERT INTO users (username, password) values (:name, :password)";
            $statement = $db->prepare($query);
            $statement->bindValue(':name', $username);
            $statement->bindValue(':password', password_hash($password2, PASSWORD_BCRYPT));
            $statement->execute();
            $_SESSION['user'] = [ 'name' => $username, 'password' => $password1,'mod' => true ];

            header('Location: index.php');
           
        }

        if($_POST['command'] == 'Logout')
        {
            session_destroy();
            header('Location: index.php');
        }
        
        if($_POST['command'] == 'Update')
        {   
            if (filter_var($_POST['action'], FILTER_VALIDATE_INT)) 
            {
                if(!empty(trim($_POST['title'])) && !empty(trim($_POST['content'])))
                {
                    $title     = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $content   = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $id        = $_POST['action'];

                    $query     = "UPDATE posts SET title = :title, post = :content WHERE id = :id";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':title', $title);        
                    $statement->bindValue(':content', $content);
                    $statement->bindValue(':id', $id, PDO::PARAM_INT);
                    
                    $statement->execute();
                    header('Location: index.php');
                }
                else
                {
                    $error = true;
                }
            } else 
            {
                header('Location: index.php');
            }
        }

        if($_POST['command'] == 'Delete')
        {        
            if (filter_var($_POST['action'], FILTER_VALIDATE_INT)) 
            {
                $id = $_POST['action'];
                $query = "DELETE FROM posts WHERE id = :id";
                $statement = $db->prepare($query);
                $statement->bindValue(':id', $id, PDO::PARAM_INT);
                $statement->execute();

                header('Location: index.php');
            } else 
            {
                header('Location: index.php');
            }    
            
        }
    }
    else
    {
        if(isset($_GET['vote']))
        {
            $postid = $_GET['postid'];

            if($_GET['vote'] == 1) {
                $query     = "UPDATE content SET votes = (votes + 1) WHERE id = :id";
            } else {
                $query     = "UPDATE content SET downvotes = (downvotes + 1) WHERE id = :id";
            }

            $statement = $db->prepare($query);
            $statement->bindValue(':id', $postid);
            $statement->execute();
            header('Location: index.php');
        } 
        else if(isset($_GET['delete']))
        {
            $postid = $_GET['postid'];

            $query = "DELETE FROM content WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':id', $postid, PDO::PARAM_INT);
            $statement->execute();
            header('Location: index.php');
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

</body>
</html>

