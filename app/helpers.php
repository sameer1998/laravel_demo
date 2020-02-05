<?php
/**
 *
 * All custom helpers are here
 **/

use App\Thumbnails;

if (!function_exists('api_response')) {
    function api_response($msg, $data = array(), $options = array())
    {

        $response_headers = ['400', '401'];

        $respObj = [];
        $respObj['message'] = $msg;
        if (!empty($data)) {
            $respObj['data'] = modifyNullData($data);
        }

        $is_status_exist = false;
        if (!empty($options)) {
            foreach ($options as $key => $value) {
                if ($key == 'status') {
                    $is_status_exist = true;
                } else {
                    $respObj[$key] = $value;
                }
            }
        }
        if ($is_status_exist) {
            if (in_array($options['status'], $response_headers)) {
                return response($respObj, $options['status']);
                exit;
            }
        }
        return response($respObj);
        // return response()->json($respObj, 200, [], JSON_NUMERIC_CHECK);
    }
}


/**
 *
 * All custom helpers are here
 **/

if (!function_exists('modifyNullData')) {
    function modifyNullData($input)
    {
        array_walk_recursive($input, function (&$item) {
            $item = strval($item);
        });
        return $input;
    }
}

if(!function_exists('checkImage')){
    function checkImage($type,$name){
        $folder =  Thumbnails::where('id',$type)->first();
        if(!empty($name)){
            $image  =  url('public/'.$folder->name.'/'.$name);
            return $image;
        }else{
            return url('public/'.$folder->name.'/'.$folder->image);
        }
    }
}

/**
 *
 * All custom helpers are here
 **/

if (!function_exists('sendNotificationAndroid')) {
    function sendNotificationAndroid($token = "", $notification = "")
    {
        $tokens = [];

        $tokens[] = $token;

        $serverKey = config('constants.FIREBASE_KEY');
        $msg = array(
            'body' => $notification,
            'title' => 'Notification',
            'subtitle' => 'This is a subtitle',
        );
        $fields = array(
            'registration_ids' => $tokens,
            'notification' => $msg
        );
        $headers = array(
            'Authorization: key=' . $firebase_api_key,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }


        $result = json_decode($result, true);

        $responseData['android'] = [
            "result" => $result
        ];

        curl_close($ch);
        return $responseData;
    }
}

/**
 *
 * All custom helpers are here
 **/

if (!function_exists('sendNotificationIos')) {
    function sendNotificationIos($token = "", $notification = "")
    {
        $apns_ids = [];

        $apns_ids[] = $token;

        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey = config('constants.FIREBASE_KEY');
        $title = "Thsi is title";
        $body = $notification;
        $notification = array('title' => $title, 'text' => $body, 'sound' => 'default', 'badge' => '1');
        $arrayToSend = array('registration_ids' => $apns_ids, 'notification' => $notification, 'priority' => 'high');
        $json = json_encode($arrayToSend);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Send the request
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }

        //Close request
        curl_close($ch);
        return $result;

    }
}


/**
 *
 * Calculate Distance from latitude and longitude
 **/


/**
 *
 * Return Round figure distance
 **/


/**
 *
 * Return Age
 **/


?>
