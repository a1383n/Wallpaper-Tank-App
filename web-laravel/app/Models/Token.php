<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class Token extends Model
{
    use HasFactory;

    /**
     * @param Request $request
     * @return false|string
     * @throws \Exception
     */
    public static function store(Request $request){
        $token = new Token();
        $value = bin2hex(random_bytes(16));

        $token->value = $value;
        $token->push_token = $request->input('push_notification_token');

        return ($token->save()) ? $value : false;
    }

    public static function verified($token_value){
        $token = Token::where('value',$token_value)->get();
        return $token->count() > 0;
    }
}
