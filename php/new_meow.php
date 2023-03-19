<?php require_once 'pdo.php';

    $pic_size = $_FILES['post_pic']['size'];
    $pic_error = $_FILES['post_pic']['error'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['form'] == 'meow'){
        if ($_POST['post_title'] != '' && $_POST['post_select'] != '' && $pic_size  < 2097152 && $pic_error <= 0){
            
            $pic_name = $_FILES['post_pic']['name'];
            $pic_tmp = $_FILES['post_pic']['tmp_name'];

            $pic_ex = pathinfo($pic_name, PATHINFO_EXTENSION);
            $pic_ex_lc = strtolower($pic_ex);
            $extension = array("png", "jpg", "gif");

            $new_pic_name = uniqid("PIC", true).'.'.$pic_ex_lc;
            $pic_upload_path = '../post_pic/'.$new_pic_name;
            move_uploaded_file($pic_tmp,$pic_upload_path);

            $data = [
                'send_title' => $_POST['post_title'],
                'send_tag' => $_POST['post_select'],
                'send_content' => $_POST['post_content'],
                'send_pic' => $new_pic_name
            ];
            $request = $database->prepare('INSERT INTO meow (meow_title, meow_tag, meow_pic, meow_content, meow_time)
                                            VALUES (:send_title, :send_tag, :send_pic, :send_content, now())');
            if($request->execute($data)){
                header('Location: ../index.php');
            } else{
                echo 'error';
            };
        } else{
            echo 'Incomplete meow';
        }   
    }
?>