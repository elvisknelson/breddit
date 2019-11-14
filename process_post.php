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
                        $newfilename = $username.'_'.$nRows.'.'.pathinfo($image_filename, PATHINFO_EXTENSION);

                        move_uploaded_file($temporary_image_path, './img-posts/'.$newfilename);

                        $image = new ImageResize('./img-posts/'.$newfilename);
                        $image->resizeToWidth(75);
                        $image->save('./img-posts/'.$username.'_'.$nRows.'_thumbnail.'.pathinfo($image_filename, PATHINFO_EXTENSION));
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
                    $statement->bindValue(':content', $content);
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

            if(trim($content) != "" && !empty($content))
            {
                $query     = "INSERT INTO comments (content, userid, votes, postid) VALUES (:content, :userid, 1, :postid)";
                $statement = $db->prepare($query);
                $statement->bindValue(':content', $content);
                $statement->bindValue(':userid', $userid);
                $statement->bindValue(':postid', $postid);
                $statement->execute();
            }

            header('Location: post.php?id='.$postid.'');
        }

        if($_POST['command'] == 'LoadMore')
        {
            $_SESSION['page'] = $_SESSION['page'] + 1;
            header('Location: index.php');
        }

        if($_POST['command'] == 'Login')
        {
            if(!empty(trim($_POST['name'])) && !empty(trim($_POST['password'])))
            {
                try
                {
                    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $password = $_POST['password'];
    
                    $query = "SELECT id, username, moderator, password FROM users WHERE username = (:user)";
                    $values = $db->prepare($query);
                    $values->bindValue(':user', $name);
                    $values->execute();
                    $row = $values->fetch();
    
                    if($name == $row['username'] && password_verify($password, $row['password']))
                    {
                        $_SESSION['user'] = [ 'name' => $name, 'id' => $row['id'], 'mod' =>  $row['moderator'] ];
                    }
                    else
                    {
                        header('Location: index.php?invaliduser');
                    }

                    header('Location: index.php');
                }
                catch (Exception $e)
                {
                    header('Location: index.php?invaliduser');
                }
            }
            else
            {
                header('Location: index.php?invaliduser');
            }
        }

        if($_POST['command'] == 'Create_User')
        {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];
            $ismod = false;

            if($username == 'elfishpro' || $username == 'admin')
            {
                $ismod = true;
            }

            $query     = "INSERT INTO users (username, password, moderator) values (:name, :password, :moderator)";
            $statement = $db->prepare($query);
            $statement->bindValue(':name', $username);
            $statement->bindValue(':password', password_hash($password2, PASSWORD_BCRYPT));
            $statement->bindValue(':moderator', $ismod);
            $statement->execute();

            $query = "SELECT id FROM users WHERE username = (:user)";
            $values = $db->prepare($query);
            $values->bindValue(':user', $username);
            $values->execute();
            $row = $values->fetch();
            $_SESSION['user'] = [ 'name' => $username, 'id' => $row['id'],'mod' => $ismod ];

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

                $delquery = "SELECT imagename, thumbnail FROM content WHERE id = :id";
                $delvalues = $db->prepare($delquery);
                $delvalues->bindValue(':id', $id);
                $delvalues->execute();
                $delrow = $delvalues->fetch();

                $query = "DELETE FROM content WHERE id = :id";
                $statement = $db->prepare($query);
                $statement->bindValue(':id', $id, PDO::PARAM_INT);
                $statement->execute();
                $file1 = 'img-posts/'.$delrow['imagename'];
                $file2 = 'img-posts/'.$delrow['thumbnail'];
                unlink ($file1);
                unlink ($file2);
                
                header('Location: index.php');
            } else 
            {
                header('Location: index.php');
            }    
            
        }
    }
    else
    {
        if(isset($_POST['vote']))
        {
            $postid = $_POST['vote'];
            $votetype = $_POST['votetype'];

            if($votetype == 1)
            {
                $query = "UPDATE content SET votes = (votes + 1) WHERE id = :id";
            }
            if($votetype == 2)
            {
                $query = "UPDATE content SET votes = (votes - 1) WHERE id = :id";
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

