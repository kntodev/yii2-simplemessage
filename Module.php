<?php

namespace kntodev\simplemessage;

use Yii;
use yii\base\InvalidParamException;
use yii\i18n\PhpMessageSource; 

class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'kntodev\simplemessage\controllers';
    public $channels = [];

    /**
     * {@inheritdoc}
     */
    public function init()
    {

        if (!isset(Yii::$app->get('i18n')->translations['modules/messages*'])) {
            Yii::$app->get('i18n')->translations['modules/messages*'] = [
                'class' => PhpMessageSource::class,
                'basePath' => '@kntodev/simplemessage/messages',
                'sourceLanguage' => 'en-US'
            ];
        }

        return parent::init();
    }

    public function registerTranslations()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['modules/messages*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@common/modules/simplemessage/messages',
        ];
    }

    public function test () {
        //print_r($this->key);
    }

    /**
     * Send a message to all channels
     *
     * @param Message $message
     * @param array|null $channels
     * @return Channel|null return the channel
     */
    public function send($message, array $channels = null){
        if($channels === null){
            $channels = array_keys($this->channels);
        }
        foreach ((array)$channels as $id) {
            $channel = $this->getChannel($id);
            if(!$message->shouldSend($channel)){
                continue;
            }

            $handle = 'to'.ucfirst($id);
            try {
                if($message->hasMethod($handle)){
                    call_user_func([clone $message, $handle], $channel);
                }
                else {
                    $channel->send(clone $message);
                }
            } catch (\Exception $e) {
                Yii::warning("Nachrichtenversand über Kanal '$id' ist fehlgeschlagen: " . $e->getMessage(), __METHOD__);
            }
        }
    }

    /**
     * Gets the channel instance
     *
     * @param string $id the id of the channel
     * @return Channel|null return the channel
     * @throws InvalidParamException
     */
    public function getChannel($id){
        if(!isset($this->channels[$id])){
            throw new InvalidParamException("Unknown channel '{$id}'.");
        }

        if (!is_object($this->channels[$id])) {
            $this->channels[$id] = $this->createChannel($id, $this->channels[$id]);
        }

        return $this->channels[$id];
    }

    protected function createChannel($id, $config){
        return Yii::createObject($config, [$id]);
    }
}