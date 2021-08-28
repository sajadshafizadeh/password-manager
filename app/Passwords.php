<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passwords extends Model
{

	private $SALT = "Snapp!"; 

    protected $fillable = [
        'username', 'password', 'user_id', 'type_id',
    ];

    /* 
     * Accessor - To en the password while showing it
     */
    public function getPasswordAttribute($value)
    {
        return $this->decrypt($value);
    }

    /* 
     * Mutator - To encrypt the password while storing it
     */
    public function setPasswordAttribute($value)
    {
        return $this->encrypt($value);
    }

    /**
     * Encrypt the given password
     *
     * @param  string $password
     * @return \Illuminate\Http\Response
     */
    private function encrypt($password){
    	$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
  		$encrypted = openssl_encrypt($password, 'aes-256-cbc', $this->SALT, 0, $iv);
 		return base64_encode($encrypted . '::' . $iv);
    }

    /**
     * Decrypt the encrypted password
     *
     * @param  string $password
     * @return \Illuminate\Http\Response
     */
    private function decrypt($password){
	    list($encrypted_data, $iv) = explode('::', base64_decode($password), 2);
	    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $this->SALT, 0, $iv);
    }

}
