<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\ServiceAccount;

class PushNotification extends Controller
{
    /**
     * Get Messaging service
     * @return \Kreait\Firebase\Messaging
     */
    public function getMessaging(){
        return (new Factory())->withServiceAccount(storage_path()."/firebase_credentials.json")->createMessaging();
    }

    public function sendMessage($topic,$title,$body,$image_url){
        $message = CloudMessage::withTarget('topic',$topic)->withNotification(Notification::create($title,$body,$image_url));
        $this->getMessaging()->send($message);
    }
}
