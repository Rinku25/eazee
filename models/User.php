<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;


class User extends \yii\db\ActiveRecord  implements IdentityInterface
{
   /* public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;*/
    public static function tableName()
    {
        return 'tbl_user';
    }
 

/*
    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];*/


    public function rules()
    {
        return [
                    [['username', 'password'], 'required'],
                    [['username', 'password'], 'string', 'max' => 100]           

                ];
    }

    public function attributeLabels()
    {

        return [
                
                'username' => 'Username',
                'password' => 'Password'

        ];

    }   



   /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
         $user = self::find()->where(["id" => $id])->one();
         //print_r($user);exit;
    if (!count($user)) {
        return null;
    }
    return new static($user);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = self::find()
            ->where(["accessToken" => $token])
            ->one();
    if (!count($user)) {
        return null;
    }
    return new static($user);

    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = self::find()->where(["username" => $username])->one();
         
    if (!count($user)) {
        return null;
    }
    return new static($user);

    }

   /**
 * @inheritdoc
 */
public function getId() {
    return $this->id;
}

/**
 * @inheritdoc
 */
public function getAuthKey() {
    return $this->authKey;
}

/**
 * @inheritdoc
 */
public function validateAuthKey($authKey) {
    return $this->authKey === $authKey;
}

/**
 * Validates password
 *
 * @param  string  $password password to validate
 * @return boolean if password provided is valid for current user
 */
public function validatePassword($password) {
    return $this->password === sha1($password);
}

}
