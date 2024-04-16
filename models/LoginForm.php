<?php

namespace app\models;

use Yii;
use yii\base\Model;
use Firebase\JWT\JWT;


/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;
    public $email;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message' => 'Please Enter Your Email'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect Email or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

    //generate login token with JWT
    private function generateloginToken($userId)
    {
        $currentTime = time();
        $expiryTime = $currentTime + (60 * 60); // Token expires in 1 hour
        $key = 'your_secret_key'; // Replace with a secure key

        $payload = [
            'user_id' => $userId,
            'iat' => $currentTime, // Issued at time
            'exp' => $expiryTime, // Expiry time
        ];

        // Generate JWT
        $jwt = JWT::encode($payload, $key);

        return $jwt;
    }
}
