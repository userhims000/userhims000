<?php
function rokit_ajaxify_comments($comment_ID, $comment_status){
    if(rokit_is_ajax()){
        switch($comment_status){
            case "0":
                wp_send_json_success(['state' => 'success']);
            break;
            case "1": //Approved comment
                wp_send_json_success(['state' => 'success']);
                break;
            default:
                wp_send_json_error(['state' => 'error']);
        }
        exit;
    }
}

add_action('comment_post', 'rokit_ajaxify_comments', 20, 2);
