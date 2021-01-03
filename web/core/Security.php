<?php


class Security
{
    /**
     * Store the cipher method
     * @var string
     */
    private string $ciphering = "AES-128-CBC";
    /**
     * Use OpenSSl Encryption method
     * @var false|int
     */
    private $iv_length = 0;
    /**
     * @var int
     */
    private int $option = 0;


    /**
     * Non-NULL Initialization Vector for encryption
     * @var string
     */
    private string $encryption_iv = 'J^=P4hpsD[Z`N{=z';

    /**
     * Store the encryption key
     * @var string
     */
    private string $encryption_key = ']Fr]>PuCa}R8\'nn`+UeT5R;5N{+a.Y3z';

    /**
     * Security constructor.
     */
    public function __construct()
    {
        $this->iv_length = openssl_cipher_iv_length($this->ciphering);
    }

    /**
     * EncryptionString
     * @param string $string
     * @return false|string
     */
    public function encryptionString(string $string)
    {
        return openssl_encrypt($string,
            $this->ciphering,
            $this->encryption_key,
            $this->option,
            $this->encryption_iv);
    }

    /**
     * Decryption String
     * @param string $encrypted_string
     * @return false|string
     */
    public function decryptionString(string $encrypted_string)
    {
        return openssl_decrypt($encrypted_string,
            $this->ciphering,
            $this->encryption_key,
            $this->option,
            $this->encryption_iv);
    }

    /**
     * Create RememberMe Cookie Value
     * @param $username
     * @param $ip
     * @param $email
     * @return string
     */
    public function rememberMeCookieValue($username, $ip)
    {
        $encrypt_string = $ip . ":" . $username . ":";
        $encrypt_string .= time() + 3600;

        return $username . ":" . $this->encryptionString($encrypt_string);
    }

    /**
     * Validation RememberMe Cookie with username and ip
     * @param $cookie_value
     * @param $ip
     * @return array|false
     */
    public function validationRememberMeCookie($cookie_value, $ip)
    {
        // Explode cookie value
        $cookie_array = explode(":", $cookie_value);

        // Store username in cookie value
        $cookie_name = $cookie_array[0];

        // Decrypt cookie value and explode
        $cookie_decrypt = explode(":", $this->decryptionString($cookie_array[1]));

        //Check cookie username with decrypt username
        if ($cookie_name == $cookie_decrypt[1]) {
            //Check Remote ip with decrypt ip
            if ($ip == $cookie_decrypt[0]) {
                if ($cookie_decrypt[2] > time()) {
                    //Validation success
                    return array("name" => $cookie_name);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $session
     * @param null $server
     * @param null $cookie
     * @return bool
     */
    public function isLogin($session, $server = null, $cookie = null): bool
    {
        if (isset($session['isLogin'])) {
            return true;
        } elseif (isset($cookie['remember_me']) && is_array($this->validationRememberMeCookie($cookie['remember_me'], $server['REMOTE_ADDR']))) {
            return true;
        } else {
            return false;
        }
    }
}