<?php
    if (!function_exists('wpApiCall')) {
        function wpApiCall($apiUrl, $body, $header = NULL)
        {
            $header = (($header != NULL) ? $header : array());
            $args = array(
                'body' => $body,
                'timeout' => '5',
                'redirection' => '5',
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => $header,
                'cookies' => array(),
            );
            $response = wp_remote_post($apiUrl, $args);
            $response = json_decode($response['body']);
            return $response;
        }
    }
    if (!function_exists('IsBase64')) {
        function IsBase64($data)
        {
            $decoded_data = base64_decode($data, true);
            $encoded_data = base64_encode($decoded_data);
            if ($encoded_data != $data)
                return false;
            else if (!ctype_print($decoded_data))
                return false;
            return true;
        }
    }
    if (!function_exists('exitWithSuccess')) {
        function exitWithSuccess($data = null)
        {
            echo json_encode(['status' => (bool)true, 'data' => (array)$data, 'message' => (string)'OK']);
            exit;
        }
    }
    if (!function_exists('exitWithDanger')) {
        function exitWithDanger($error = null)
        {
            echo json_encode(['status' => (bool)false, 'data' => (array)[], 'message' => (string)(($error != '') ? $error : 'Oh snap! Something went wrong.')]);
            exit;
        }
    }
    if (!function_exists('d')) {
        function d($data = 'NONE')
        {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        }
    }
    if (!function_exists('dd')) {
        function dd($data = 'NONE')
        {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            die;
        }
    }
    if (!function_exists('convertObjectToArray')) {
        function convertObjectToArray($data)
        {
            $data = json_encode($data);
            return json_decode($data, true);
        }
    }