<?php
function sendGCM($message, $id) {


    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array (
        'registration_ids' =>$id,
        'notification' => $message
    );
    $fields = json_encode ( $fields );

    $headers = array (
        'Authorization: key=' . "AAAA2XX1IPU:APA91bFJxN2szuIalVQ09kkcs1MJ6-O4IdQG_g2_O9DsDw-lBmJMNmOinX2R7lWtmIhRzsE3OGva0xjvlFu2EmBz20QKYfGSmW5cFuJNpFZHTr-HErU4XxcqUAbM1nHcaeZaGdUjjzYv",
        'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
    echo $result;
    curl_close ( $ch );
}
$to = 'c1-nAePoQYKV3vjbJ-4gZL:APA91bERvujz9havsjma1lgas22a-HGpBnYwjZ4ILwcJydPPH1JA2GFpILgA6qAfuzDF1gIqt68nbqBbZEo4RvnRotRsQaxi0rPltQ-fPi5Rt9uzt0rqJKneDGym0KDhDHASZdHoLe-n';
$to2 = 'd4T3-qU6RRKcS6h7d1Ofgo:APA91bHJWfW5nkCX6hOhxUUtIcHZPaiJyVtkrpaw3tcfp79gUECcT46vXN4N9d2mBmz8QpsVIIw6IOmhAnikMmI-NysCwL9Xq2NU-uu0mfkOCcZXBIhLE13008GKXwavnaXsThvP-c5B';
$data = array(
    "title"=>"New",
    "body"=>"API"
);

$id = array($to,$to2);
print_r(sendGCM($data,$id));
