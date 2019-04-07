<?php 
//function check_url(){
    // $url = 'https://www.durian.in';

    // if(!$url || !is_string($url) || ! preg_match('/^http(s)?:\/\/[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(\/.*)?$/i', $url)){
    //     return false;
    // }

function call_by_curl($http_url) {
	$ch = curl_init($http_url);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
    curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT,1000);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
    
    $output = curl_exec($ch);

    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $last_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);      
    curl_close($ch);

    $temp['status'] = $httpcode; 
    $temp['output'] = $output;

    $headers = preg_split("/(\n\s\n){1,}|(\n){1,}|(\r\n){1,}/", @trim(substr($output, 0, $header_size)));
    $temp['title'] = $headers[0];

    unset($headers[0]);
    $temp_data = array();
    foreach ($headers as $key => $header) {
    	if (!empty($header)) {
            $temp_arr = explode(": ", $header);
            $temp_data['name'] = $temp_arr[0];
            if (!empty($temp_arr[1])) {
                $temp_data['details'] = $temp_arr[1];
            }
            $temp['header_details'][] = $temp_data;
        }
    }
    //echo "<pre>"; print_r($temp); exit;

    return $temp;
}

function get_url($url, $return_arr){
   	$temp = call_by_curl($url);
    $return_arr[] = $temp;
    if ($temp['status'] == 301 || $temp['status'] == 302) {
    	$temp_arr_to_push = array();
        list($httpheader) = explode("\r\n\r\n", $temp['output'], 2);
        $matches = array();
        preg_match('/(Location:|URI:)(.*?)\n/', $httpheader, $matches);
        $nurl = trim(array_pop($matches));
        $url_parsed = parse_url($nurl);

        $temp_arr_to_push[] = get_url($nurl, $return_arr);

        return $temp_arr_to_push[0];
    }     
    return $return_arr;
}
    //echo "<pre>"; print_r($_POST); exit;
    $urls = explode("\n", $_POST['all_urls']);
    //echo "<pre>"; print_r($urls); exit;
    $response = array();

    foreach ($urls as $key => $url) {
        $all_lists = array();
        $all_urls = get_url($url, $all_lists);
        //echo "<pre>"; print_r($all_urls); exit;
        $response[$key]['url'] = $url;
        $response[$key]['header'] = $all_urls;
    }
    //echo "<pre>"; print_r($response); exit;
    echo json_encode($response, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); exit;
//}
//check_url();
?>