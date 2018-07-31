<?php

namespace kntodev\simplemessage\models;

use Yii;
use kntodev\simplemessage\models\User ;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $readed
 * @property int $sender
 * @property int $receiver
 * @property string $subject
 * @property string $content
 * @property string $route
 * @property int $created_at
 *
 * @property User $receiver0
 * @property User $sender0
 */
class Messages extends \yii\db\ActiveRecord
{

    public $users;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'readed', 'sender', 'receiver', 'created_at'], 'integer'],
            ['users', 'safe'],
            [['subject', 'content'], 'required'],
            [['content'], 'string'],
            [['subject'], 'string', 'max' => 25],
            [['route'], 'string', 'max' => 255],
            [['receiver'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['receiver' => 'id']],
            [['sender'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('modules/messages', 'ID'),
            'readed' => Yii::t('modules/messages', 'Readed'),
            'sender' => Yii::t('modules/messages', 'Sender'),
            'receiver' => Yii::t('modules/messages', 'Receiver'),
            'subject' => Yii::t('modules/messages', 'Subject'),
            'content' => Yii::t('modules/messages', 'Content'),
            'route' => Yii::t('modules/messages', 'Route'),
            'created_at' => Yii::t('modules/messages', 'Created At'),
            'users' => Yii::t('modules/messages', 'Receiver'),
        ];
    }

    public function setReaded($id) {
        $message = Messages::findOne($id);
        if (Yii::$app->user->identity->id == $message->receiver) {
            $message->readed = 1;
            $message->save() ;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver0()
    {
        return $this->hasOne(User::className(), ['id' => 'receiver']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender0()
    {
        return $this->hasOne(User::className(), ['id' => 'sender']);
    }
}
