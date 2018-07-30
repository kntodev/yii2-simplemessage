<?php

namespace kntodev\simplemessage\channels;

use Yii;
use kntodev\simplemessage\Channel;
use kntodev\simplemessage\Message;
use kntodev\simplemessage\models\Messages ;

class ScreenChannel extends Channel
{
    public function send(Message $message)
    {
        foreach ($message->receiver as $value) {
            $messages = new Messages();
            $messages->readed = 0 ;
            $messages->sender = Yii::$app->user->getId() ;
            $messages->receiver = $value ;
            $messages->subject = $message->subject ;
            $messages->content = $message->content ;
            $messages->route = 'messages/default/view?id=' ;
            $messages->created_at = time() ;
            $messages->save() ;
        }
    }

}
