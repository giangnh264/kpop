<?php
/**
Aes encryption 128 of mobifone
*/
class MobifoneAES extends AESBase {
	
	public function __construct($key, $iv)
	{
		parent::__construct($key, $iv);
	}
	/**
	 * Encode data
	 * @param string $data
	 * @return string Data after encode
	 */
	public function encrypt($data)
	{
		if(16 !== strlen($this->getKey())) $this->setKey(hash('MD5', $this->getKey(), true));
		if(16 !== strlen($this->getIV())) $this->setIV(hash('MD5', $this->getIV(), true));
		$padding = 16 - (strlen($data) % 16);
		$data .= str_repeat(chr($padding), $padding);
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->getKey(), $data, MCRYPT_MODE_ECB, $this->getIV()));
	}
	
	/**
	 * Decode data
	 * @param string $data
	 * @return string Data after decode
	 */
	public function decrypt($data)
	{
		$data = base64_decode(str_replace(' ', '+', $data));
		if(16 !== strlen($this->getKey())) $this->setKey(hash('MD5', $this->getKey(), true));
		if(16 !== strlen($this->getIV())) $this->setIV(hash('MD5', $this->getIV(), true));
		$data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->getKey(), $data, MCRYPT_MODE_ECB, $this->getIV());
		$padding = ord($data[strlen($data) - 1]);
		return substr($data, 0, -$padding);
	}
}
?>