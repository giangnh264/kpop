<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseBusiness
 *
 * @author tienbm
 */
abstract class BaseBusiness {
    protected $params;        
    protected $userSubscribe;
    //protected $userQuota;
    protected $result;
    
    abstract protected function defineBiz();  //define business model later
    function __construct($par) {
    	$this->params = $par;
    	$this->result['error'] = 'success';
        if (isset($par['msisdn']))
        {
            $this->userSubscribe = BmUserSubscribeModel::model()->get($this->params['msisdn']);
        }
    }
    
}

?>
