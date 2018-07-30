<?php

namespace kntodev\simplemessage\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property int $confirmed_at
 * @property string $unconfirmed_email
 * @property int $blocked_at
 * @property string $registration_ip
 * @property int $created_at
 * @property int $updated_at
 * @property int $flags
 * @property int $last_login_at
 *
 * @property Messages[] $messages
 * @property Messages[] $messages0
 * @property Profile $profile
 * @property SocialAccount[] $socialAccounts
 * @property Token[] $tokens
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash', 'auth_key', 'created_at', 'updated_at'], 'required'],
            [['confirmed_at', 'blocked_at', 'created_at', 'updated_at', 'flags', 'last_login_at'], 'integer'],
            [['username', 'email', 'unconfirmed_email'], 'string', 'max' => 255],
            [['password_hash'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32],
            [['registration_ip'], 'string', 'max' => 45],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    static public function getCreatedUsersList()
    {
        $users = User::find()->all();
        $actualUser = Yii::$app->user->identity->id ;
        $usersArray = array();

        foreach ($users as $key => $user)
            if ($user->id != $actualUser) {
                $usersArray["$user->id"] = $user->username;
            }

        return $usersArray;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('modules/messages', 'ID'),
            'username' => Yii::t('modules/messages', 'Username'),
            'email' => Yii::t('modules/messages', 'Email'),
            'password_hash' => Yii::t('modules/messages', 'Password Hash'),
            'auth_key' => Yii::t('modules/messages', 'Auth Key'),
            'confirmed_at' => Yii::t('modules/messages', 'Confirmed At'),
            'unconfirmed_email' => Yii::t('modules/messages', 'Unconfirmed Email'),
            'blocked_at' => Yii::t('modules/messages', 'Blocked At'),
            'registration_ip' => Yii::t('modules/messages', 'Registration Ip'),
            'created_at' => Yii::t('modules/messages', 'Created At'),
            'updated_at' => Yii::t('modules/messages', 'Updated At'),
            'flags' => Yii::t('modules/messages', 'Flags'),
            'last_login_at' => Yii::t('modules/messages', 'Last Login At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['receiver' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Messages::className(), ['sender' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialAccounts()
    {
        return $this->hasMany(SocialAccount::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(Token::className(), ['user_id' => 'id']);
    }
}
