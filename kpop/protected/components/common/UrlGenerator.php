<?php
class UrlGenerator
{
	/**
	 * Base url
	 * @var string
	 */
	const BASE_URL = 'http://dangky.mobifone.com.vn/wap/html/sp/confirm.jsp';
	/**
	 * SP id
	 * @var string
	 */
	private $_spId;
	/**
	 * Transaction id
	 * @var string
	 */
	private $_transactionId;
	/**
	 * Package name
	 * @var string
	 */
	private $_packageName;
	/**
	 * Price
	 * @var int
	 */
	private $_price;
	/**
	 * Back url
	 * @var string
	 */
	private $_backUrl;
	/**
	 * Information
	 * @var string
	 */
	private $_information;

    /**
     * freeCircle
     * @var string
     */
    private $_freeCircle;

    /**
     * circle
     * @var int
     */
    private $_circle;

    /**
     * customerCare
     * @var string
     */
    protected $_customerCare = '9090';

    /**
     * priceCustomerCare
     * @var int
     */
    protected $_priceCustomerCare = 200;

	/**
	 * Set sp id and check constraint
	 * @param int $spId
	 * @throws Exception
	 */
	protected function setSpId($spId)
	{
		$this->_spId = $spId;
		if(!$this->_spId)
			throw new Exception("Invalid param");
	}
	
	/**
	 * Get sp id
	 * @return string
	 */
	protected function getSpId()
	{
		return $this->_spId;
	}
	
	/**
	 * Set transaction id, uique Id
	 */
	protected function setTransactionId($transactionId)
	{
		$this->_transactionId = $transactionId;
		if(!$this->_transactionId)
			throw new Exception("Invalid param");
	}
	
	/**
	 * Get transaction id
	 * @return string
	 */
	protected function getTransactionId()
	{
		return $this->_transactionId;
	}
	
	/**
	 * Set package name
	 * @param string $packageName
	 * @throws Exception
	 */
	protected function setPackageName($packageName)
	{
		$this->_packageName = $packageName;
		if(!$this->_packageName)
			throw new Exception("Invalid param");
	}
	
	/**
	 * Get package name
	 * @return string
	 */
	protected function getPackageName()
	{
		return $this->_packageName;
	}
	
	/**
	 * Set price
	 * @param number $price
	 * @throws Exception
	 */
	protected function setPrice($price)
	{
		$this->_price = $price;
		if($this->_price == null)
			$this->_price = 0;
	}
	
	/**
	 * Get price
	 * @return number
	 */
	protected function getPrice()
	{
		return $this->_price;
	}
	
	/**
	 * Set back url
	 * @param string $backUrl
	 * @throws Exception
	 */
	protected function setBackUrl($backUrl)
	{
		$this->_backUrl = $backUrl;
		if(!$this->_backUrl)
			throw new Exception("Invalid param");
	}
	
	/**
	 * Get back url
	 * @return string
	 */
	protected function getBackUrl()
	{
		return $this->_backUrl;
	}
	
	/**
	 * Set information
	 * @param string $information
	 */
	protected function setInformation($information)
	{
		$this->_information = $information;
		if(!$this->_information)
			throw new Exception("Invalid param");
	}
	
	/**
	 * Get information
	 * @return string
	 */
	protected function getInformation()
	{
		return $this->_information;
	}

    /**
     * Set free cicle a
     * @param number $free_circle
     * @throws Exception
     */
    protected function setFreeCircle($free_circle)
    {
        $this->_freeCircle = $free_circle;
        if(!$this->_freeCircle)
            $this->_freeCircle = 0;
    }

    /**
     * Get freeCircle
     * @return int
     */
    protected function getFreeCircle()
    {
        return $this->_freeCircle;
    }

    /**
     * @param number $circle
     * @throws Exception
     */
    protected function setCircle($circle){
        $this->_circle = $circle;
        if(!$this->_circle)
            $this->_circle = 0;
    }

    /**
     * @return int
     */
    protected function getCircle(){
        return $this->_circle;
    }
	
	/**
	 * Url generator construct
	 * @param string $spId
	 * @param string $packageName
	 * @param int $price
	 * @param string $backUrl
	 * @param string $information
	 */
	public function __construct($spId, $transactionId, $packageName, $price, $backUrl, $information, $free_circle, $circle)
	{
		$this->setSpId($spId);
		$this->setTransactionId($transactionId);
		$this->setPackageName($packageName);
		$this->setPrice($price);
		$this->setBackUrl($backUrl);
		$this->setInformation($information);
        $this->setCircle($circle);
        $this->setFreeCircle($free_circle);
	}
	
	/**
	 * Generate url
	 * @param AESBase $aes
	 * @return string
	 */
	public function generateUrl($aes)
	{
            if(!$aes || !($aes instanceof AESBase))
			throw new Exception('Invalid param');

        $link = $this->getTransactionId().'&'.$this->getPackageName().'&'.$this->getFreeCircle().'&'.$this->getPrice().'&'.$this->getCircle().'&'.$this->_customerCare.'&'.$this->_priceCustomerCare.'&'.$this->getBackUrl();
        $link = $aes->encrypt($link);
        return self::BASE_URL . '?sp_id='.$this->getSpId().'&link='.$link;

	}
}