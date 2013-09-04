<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('debug' => true));

require '../../../../wp-load.php';

/** Update the profile data */
$app->post('/user', function() use ($app) {

            $requestBody = $app->request()->getBody();  // <- getBody() of http request
            $json_a = json_decode($requestBody, true);

            $user_id = $json_a['id'];

            //start updating profile data
            foreach ($json_a as $key => $value) {
                if ($key !== 'profileemail') {

                    if ($key == 'user_skills2')
                        $key = 'user_skills';

                    update_user_meta($user_id, $key, $value);
                }
            }

            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('success' => 1));
        });

//update the user avatar
$app->post('/change-avatar', function() use($app) {

            global $user_ID;

            $targetFolder = '/uploads/user-avatars/' . $user_ID; // Relative to the root


            $files = $_FILES['files'];


            if ($files['name']) {
                $file = array(
                    'name' => $files['name'],
                    'type' => $files['type'],
                    'tmp_name' => $files['tmp_name'],
                    'error' => $files['error'],
                    'size' => $files['size']
                );
                if (isset($_FILES['files'])) {
                    $filename = $_FILES['files']['tmp_name'];
                    list($width, $height) = getimagesize($filename);
                    $image_width = $width;
                    $image_height = $height;
                }

                $_FILES = array("upload_attachment" => $file);


                $attach_data = array();


                foreach ($_FILES as $file => $array) {
                    $attach_id = upload_attachment($file, $user_ID);
                    $attachment_id = $attach_id;
                   // $attachment_url = wp_get_attachment_link($attach_id,'medium');
                }
            }

            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('success' => 1, 'image' => $attachment_url, 'image_name' => $files['name'], 'image_height' => $image_height, 'image_width' => $image_width));
        });

$app->post('/resize-user-avatar', function() use($app) {

            global $user_ID;

            $targetFolder = "../../../uploads/user-avatars/" . $user_ID . "/"; // Relative to the root

            if (get_user_role() == 'employer')
                $new_name = "employer" . $user_ID . ".jpg";
            else
                $new_name = "minyawn" . $user_ID . ".jpg";

            $for_user_meta = "user-avatars/" . $user_ID . "/" . $new_name;


            $t_width = 100; // Maximum thumbnail width
            $t_height =100; // Maximum thumbnail height

            extract($_POST);
            $ratio = ($t_width / $w);
            $nw = ceil($w * $ratio);
            $nh = ceil($h * $ratio);
            $nimg = imagecreatetruecolor($nw, $nh);

            if (stripos($image_name, "png") !== false)
                $im_src = imagecreatefrompng($targetFolder . $image_name);
            else
                $im_src = imagecreatefromjpeg($targetFolder . $image_name);


            imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, $nw, $nh, $w, $h);
            imagejpeg($nimg, $targetFolder . $new_name, 90);
            //$attach_id = pn_get_attachment_id_from_url($targetFolder . $new_name);
            $post_data = array(
                'post_author' => get_user_id(),
                'post_content' => '',
                'post_date' => date('Y-m-d H:i:s'),
                'post_date_gmt' => date('Y-m-d H:i:s'),
                'post_excerpt' => '',
                'post_name' => $new_name,
                'post_parent' => 0,
                'post_status' => 'inherit',
                'post_title' => $new_name,
                'post_type' => 'attachment',
                'post_mime_type' => 'image/jpeg',
                'guid' => site_url() . "/wp-content/uploads/user-avatars/" . $user_ID . "/" . $new_name,
            );
            $atach_post_id = wp_insert_post($post_data);
            $attachment_id_photo = update_post_meta($atach_post_id, '_wp_attached_file', $for_user_meta);
            update_user_meta($user_ID, 'avatar_attachment', $atach_post_id);

            $app->response()->header("Content-Type", "application/json");
            echo json_encode(get_user_company_logo($user_ID));
        });

$app->run();

function upload_attachment($file_handler, $user_id) {

    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK)
        __return_false();

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    //add filter

    function change_user_avatar_upload_dir($pathdata) {

        global $user_ID;
        $pathdata['path'] = $pathdata['basedir'] . '/user-avatars/' . $user_ID;
        $pathdata['subdir'] = '/user-avatars/' . $user_ID;
        $pathdata['url'] = $pathdata['baseurl'] . '/user-avatars/' . $user_ID;

        return $pathdata;
    }

    add_filter('upload_dir', 'change_user_avatar_upload_dir');

    $attach_id = media_handle_upload($file_handler, 0);

    remove_filter('upload_dir', 'change_user_avatar_upload_dir');

    update_user_meta($user_id, 'avatar_attachment', $attach_id);
    return $attach_id;
}

function pn_get_attachment_id_from_url($attachment_url = '') {

    global $wpdb;
    $attachment_id = false;

    // If there is no url, return.
    if ('' == $attachment_url)
        return;

    // Get the upload directory paths
    $upload_dir_paths = wp_upload_dir();

    // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
    if (false !== strpos($attachment_url, $upload_dir_paths['baseurl'])) {

        // If this is the URL of an auto-generated thumbnail, get the URL of the original image
        $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);

        // Remove the upload path base directory from the attachment URL
        $attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);

        // Finally, run a custom database query to get the attachment ID from the modified attachment URL
        $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
    }

    return $attachment_url;
}