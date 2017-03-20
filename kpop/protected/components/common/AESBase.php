<?php
/**
Aes encryption
*/
abstract class AESBase {
	
	/**
	 * Key used to decode and encode AES
	 * @var string
	 */
	private $_key;
	/**
	 * Iv used to decode and encode AES
	 * @var string
	 */
	private $_iv;
	
	/**
	 * Construct the key that used to encode or decode
	 * @param string $key
	 * @throws Exception
	 */
	public function __construct($key, $iv)
	{
		$this->setKey($key);
		$this->setIV($iv);
	}
	
	/**
	 * Set AES key
	 * @param string $key
	 */
	protected function setKey($key)
	{
		$this->_key = $key;
		if(!$this->_key)
			$this->_key = 'U8hQPJQm5hqBiiIl';
	}
	
	/**
	 * Get AES key
	 * @return string
	 */
	protected function getKey()
	{
		return $this->_key;
	}
	
	/**
	 * Set AES iv
	 * @param string $iv
	 */
	protected function setIV($iv)
	{
		$this->_iv = $iv;
	}
	/**
	 * Get AES iv
	 * @return string
	 */
	protected function getIV()
	{
		return $this->_iv;
	}
	
	/**
	 * Encode data
	 * @param string $data
	 * @return string Data after encode
	 */
	abstract public function encrypt($data);
	
	/**
	 * Decode data
	 * @param string $data
	 * @return string Data after decode
	 */
	abstract public function decrypt($data);
}
?>