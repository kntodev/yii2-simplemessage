<?php

namespace kntodev\simplemessage;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * simplemessage module definition class
 */
class Message extends \yii\base\BaseObject
{
    public $receiver ;
    public $subject ;
    public $content ;

    public function create($params = []){
        Message::checkdata($params);
        return new static($params);
    }

    /**
     * Determines if the notification can be sent.
     *
     * @param  \webzop\notifications\Channel $channel
     * @return bool
     */
    public function shouldSend($channel)
    {
        return true;
    }

    
    /**
     * Gets the notification description
     *
     * @return string|null
     */
    public function getDescription(){
        return null;
    }

    /**
     * Gets the notification route
     *
     * @return array|null
     */
    public function getRoute(){
        return null;
    }

    /**
     * Gets notification data
     *
     * @return array
     */
    public function getData(){
        return $this->data;
    }

    /**
     * Sets notification data
     *
     * @return self
     */
    public function setData($data = []){
        $this->data = $data;
        return $this;
    }

    /**
     * Gets the UserId
     *
     * @return array
     */
    public function getUserId(){
        return $this->userId;
    }

    /**
     * Sets the UserId
     *
     * @return self
     */
    public function setUserId($id){
        $this->userId = $id;
        return $this;
    }

    /**
     * Sends this notification to all channels
     *
     * @param string $key The key of the notification
     * @param integer $userId The user id that will get the notification
     * @param array $data Additional data information
     * @throws \Exception
     */
    public function send(){
        Yii::$app->getModule('messages')->send($this);
    }

    public function test(){
        Yii::$app->getModule('messages')->test($this);
    }

    public function checkdata($data = []) {
    	$keys = ['receiver','subject','content'] ;
    	foreach ($keys as $value) {
    		if (!array_key_exists($value, $data)) {
    			throw new NotFoundHttpException('Es ist zwingend notwendig das im Befehl Message::create der Schlüssel '.$value.' existiert');
			}
    	}
    	return $data ;
    }
}
