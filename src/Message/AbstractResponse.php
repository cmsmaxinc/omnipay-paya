<?php

namespace Omnipay\Paya\Message;

use Omnipay\Common\Message\AbstractResponse as OmnipayAbstractResponse;
use Omnipay\Common\Message\RequestInterface;

abstract class AbstractResponse extends OmnipayAbstractResponse
{
    /**
     * @var \SimpleXMLElement
     */
    protected $data;
    
    /**
     * Constructor
     *
     * @param RequestInterface $request
     * @param \SimpleXMLElement $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
        $this->data = $data;
    }
    
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        // Check validation passed
        $validationPassed = isset($this->data->VALIDATION_MESSAGE) && 
                            isset($this->data->VALIDATION_MESSAGE->RESULT) && 
                            $this->data->VALIDATION_MESSAGE->RESULT == 'Passed';
        
        // Check not declined
        $notDeclined = !isset($this->data->AUTHORIZATION_MESSAGE->RESPONSE_TYPE_TEXT) || 
                       $this->data->AUTHORIZATION_MESSAGE->RESPONSE_TYPE_TEXT != 'DECLINED';
        
        return $validationPassed && $notDeclined;
    }
    
    /**
     * Get the transaction reference
     *
     * @return string|null
     */
    public function getTransactionReference()
    {
        return isset($this->data->AUTHORIZATION_MESSAGE->TRANSACTION_ID) 
            ? (string)$this->data->AUTHORIZATION_MESSAGE->TRANSACTION_ID 
            : null;
    }
    
    /**
     * Get the error message
     *
     * @return string|null
     */
    public function getMessage()
    {
        if (isset($this->data->EXCEPTION->MESSAGE)) {
            return (string)$this->data->EXCEPTION->MESSAGE;
        }
        
        if (isset($this->data->VALIDATION_MESSAGE->VALIDATION_ERROR->MESSAGE)) {
            return (string)$this->data->VALIDATION_MESSAGE->VALIDATION_ERROR->MESSAGE;
        }
        
        if (isset($this->data->AUTHORIZATION_MESSAGE->MESSAGE)) {
            return (string)$this->data->AUTHORIZATION_MESSAGE->MESSAGE;
        }
        
        return null;
    }
}