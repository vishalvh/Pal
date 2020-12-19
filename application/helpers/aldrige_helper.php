<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('aldrige')) {

    function product_list() {
        try {
            $url = 'https://preview.pimber.ly/api/v2/products?limit=16';
            $url = str_replace(" ","%20",$url);
            $data = get_content($url);
            $data2 = json_decode($data);
            return $data2;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }
    function product_detail($id) {
        try {
            $url = "https://preview.pimber.ly/api/v2/products/$id";
            $url = str_replace(" ","%20",$url);
            $data = get_content($url);
            $data2 = json_decode($data);
            $test = (array) $data2;
            $keys = str_replace( ' ', '', array_keys( $test ) );
            $newProduct = array_combine( $keys, array_values( $test ) );
            return $newProduct;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }
}
function get_content($URL){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json',
          'Authorization: a2LvCzGjOA7AV4r5rCuhmdzcFc0rAXSdYOB0ruaKPvLkvBISDZMLXSZKpR2Tp1QL'
        ));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $URL);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
}
?>