<?php

/*
* This file is part of the IAKPress package.
*
* (c) IAKPress <contact@iakpress.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace App\Joosorol\IAKPress\IAPost;

class Cryptor {
    const CIPHERING = 'AES-128-CTR';

     /**
     * @var Cryptor The single instance of the class
     */
    private static $sInstance = null;

    var $secureKey = null;

    /**
     * Cryptor Constructor.
     */
    private function __construct()
    {
    }

    /**
     * Main Cryptor Instance
     *
     * Ensures only one instance of Cryptor is loaded or can be loaded.
     *
     * @static
     * @return Cryptor - Main instance
     */
    public static function getInstance()
    {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new self();
        }
        return self::$sInstance;
    }

    public function getSecureKey() {
        $key = get_option(Constants::IAKPRESS_SECURE_KEY, '');

        if (empty($key)) {
            $iv_num_bytes = openssl_cipher_iv_length(self::CIPHERING);
            $key = wp_generate_password($iv_num_bytes);

            update_option(Constants::IAKPRESS_SECURE_KEY, $key, true);
        }

        return $key;
    }


    /**
     * @param string $key the encryption key
     * @param string $str a given string to encrypt
     */
    public function encrypt($key, $str) {
        $secureKey = $this->getSecureKey();

        // Use OpenSSl Encryption method 
        openssl_cipher_iv_length(self::CIPHERING); 
        $options = 0; 

        // Use openssl_encrypt() function to encrypt the data 
        return openssl_encrypt($str, self::CIPHERING, $key, $options, $secureKey); 
    }

    /**
     * @param string $key the encryption key
     * @param string $str a given string to decrypt
     */
    public function decrypt($key, $str) {
        $secureKey = $this->getSecureKey();

        // Use OpenSSl Encryption method 
        openssl_cipher_iv_length(self::CIPHERING); 
        $options = 0; 

       // Use openssl_decrypt() function to decrypt the data
        return openssl_decrypt ($str, self::CIPHERING, $key, $options, $secureKey); 
    }
}