<?php

class PushServer {

    private $googleApiKey = 'AAAAjACAUls:APA91bGZVs64Jt9XCSdoJxGKelf1kq_Ggnqt63lQqSr8RJNXYceWQNiDTCDhQMW65ZbUhExIlbG3VhL63-ZtTgoCicskw236R5t9YChhsbUdK4Tu8kQitnN-69DPOpzZWoP1X9hatoYr';
    private $googleApiUrl = 'https://fcm.googleapis.com/fcm/send';
    public function pushToGoogle($regId, $title, $message,$type,$id) {
        $registrationIds = $regId;
        $fields = array(
             'registration_ids' => $registrationIds,
            'priority' => 'high',
            //'notification' => array("title" => "hello world","notification"=>"this is ggg","sound"=>"default")
            'notification' => array(
                'title' => $title,
                'body' => $message,
                'type' => $type,
                'id' => $id),
            'data' => array(
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'id' => $id)
        );

        $headers = array(
            'Authorization: key=' . $this->googleApiKey,
            'Content-Type: application/json'
        );

        $test = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->googleApiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);

        // Close connection

        curl_close($ch);
        return $result;
    }

}

?>