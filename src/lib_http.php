<?php

function post_http_request ($url, $header, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);
    if( $response === FALSE ) {
        return null;
    } else {
        return $response;    
    }
}

function get_http_request ($url, $header, $data) {
    if (is_array($data)) {
        $query = http_build_query($data);
    } elseif(is_string($data)) {
        $query = $data;
    } else {
        $query = '';
    }
    $url = $url . '?' . $query;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $response = curl_exec($ch);
    curl_close($ch);
    if( $response === FALSE ) {
        return null;
    } else {
        return $response;    
    }
}

function put_http_request ($url, $header, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);
    if( $response === FALSE ) {
        return null;
    } else {
        return $response;    
    }
}

function execute_http ($url, $method, $header, $contents) {
    if ($method === 'POST') {
        $contents = post_http_request ($url, $header, $contents);
    } else if ($method === 'GET') {
        $contents = get_http_request ($url, $header, $contents);
    } else if ($method === 'PUT') {
        $contents = put_http_request ($url, $header, $contents); 
    }else {
        return NULL;
    }
    return $contents;
}
