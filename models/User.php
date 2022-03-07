<?php

namespace app\models;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 *
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{


    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
       return [
           [['id'], 'integer'],
            [['username', 'password'], 'string', 'max' => 45 ],
       ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Name',
            'password' => 'Password',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return User|array|\yii\db\ActiveRecord|null
     */
    public static function findByUsername($username)
    {
        return User::find()->where(['username' => $username])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return null;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password == $password;
    }
}
