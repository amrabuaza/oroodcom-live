<?php

namespace backend\modules\models\UserModels;

use yii\base\Model;

class UserProfile extends Model
{
    public $access_token;
    public $username;
    public $first_name;
    public $last_name;
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['username', 'first_name', 'last_name', 'email'], 'required'],
            [['username', 'first_name', 'last_name', 'email'], 'string'],
            [['email', 'username', 'first_name', 'last_name'], 'safe'],
        ];
    }

    public function update()
    {

        if ($this->validate()) {
            $result = [
                'status' => false,
                "user" => null
            ];
            $user = User::findOne(['access_token' => $this->access_token]);

            $user->username = $this->username;
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->email = $this->email;

            if ($user->save()) {
                $flag = true;
                $user = $this;
            } else {
                $user = $user->errors;
                $flag = false;
            }
            return [
                'status' => $flag,
                "user" => $user
            ];

        }
        return ["status" => false];
    }

    public static function getUserByAccessToken($accessToken)
    {
        $user = User::findOne(["access_token" => $accessToken]);

        if ($user == null) {
            return null;
        }

        $userProfile = new UserProfile();

        $userProfile->username = $user->username;
        $userProfile->first_name = $user->first_name;
        $userProfile->last_name = $user->last_name;
        $userProfile->email = $user->email;
        $userProfile->access_token = $user->access_token;
        return $userProfile;
    }

}
