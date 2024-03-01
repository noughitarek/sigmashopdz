<?php

namespace App\Models;

use GIDIX\PushNotifier\SDK\PushNotifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ["icon", "icon_color", "title", "content", "link", "readed", "sent_to"]; 
    public static function Send_notification($content, $link)
    {
        $app = new PushNotifier([
            'api_token'     =>  config("settings.notifications.api_token"),
            'package'       =>  config("settings.notifications.package")
        ]);
        $appToken = $app->login(config("settings.notifications.username"), config("settings.notifications.password"));
        $app = new PushNotifier([
            'api_token'     =>  config("settings.notifications.api_token"),
            'package'       =>  config("settings.notifications.package"),
            'app_token'     =>  $appToken
        ]);
        $devices = $app->getDevices();
        $result = $app->sendNotification($devices, $content, $link);
    }
    public static function Send($data, $permission, $phone=false)
    {
        $users = Admin::all();
        foreach($users as $user){
            if($user->Has_permission($permission)){
                Notification::create([
                    "icon" => $data["icon"],
                    "icon_color" => $data["icon_color"],
                    "title" => $data["title"],
                    "content" => $data["content"],
                    "link" => $data["link"],
                    "sent_to" => $user->id
                ]);
            }
        }
        if($phone){
            self::Send_notification($data["title"]."\n".$data["content"], $data["link"]);
        }
    }
}
