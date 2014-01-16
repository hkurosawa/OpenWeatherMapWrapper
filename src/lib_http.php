<?php

function post_http_request ($url, $header, $data) {
    $options = array("http"=>array(
        'method'    =>  'POST',
        'header'    =>  implode("\r\n",$header),
        'content'   =>  http_build_query($data, "", "&"),
        'ignore_errors'=>true
        ));
    $context  = stream_context_create($options);
    $contents = file_get_contents($url, false, $context);
    if ($contents===FALSE) {
        return null;
    } else {
        return $contents;
    }
}

function get_http_request ($url, $header, $data) {
    $url = $url . '?' . http_build_query($data);
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
    /*
    $options = array('http' =>
        array(
            'method' => 'GET',
            'ignore_errors' => true,
            'header'  => implode("\r\n", $header), 
        )
    );
    $url = $url . '?' . http_build_query($data);
    $contents = file_get_contents($url, false, stream_context_create($options));
    if ($contents===FALSE) {
        return null;
    } else {
        return $contents;        
    }
     * 
     */
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
    /*
    $options = array("http"=>array(
        'method'    =>  'PUT',
        'header'    =>  implode("\r\n",$header),
        'content'   =>  $data,//http_build_query($data, "", "&"),
        'ignore_errors'=>true
        ));
    $context  = stream_context_create($options);
    $contents = file_get_contents($url, false, $context);
    if ($contents===FALSE) {
        return null;
    } else {
        return $contents;
    }
     * *
     */
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
