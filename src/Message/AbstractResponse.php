<?php

namespace Omnipay\Paya\Message;

use Omnipay\Common\Message\AbstractResponse as OmnipayAbstractResponse;

abstract class AbstractResponse extends OmnipayAbstractResponse
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        // Check validation message
        $validationPassed = isset($this->data->VALIDATION_MESSAGE) && 
                           isset($this->data->VALIDATION_MESSAGE->RESULT) && 
                           (string)$this->data->VALIDATION_MESSAGE->RESULT === 'Passed';
        
        // Check authorization response type
        $notDeclined = isset($this->data->AUTHORIZATION_MESSAGE) && 
                      isset($this->data->AUTHORIZATION_MESSAGE->RESPONSE_TYPE_TEXT) && 
                      (string)$this->data->AUTHORIZATION_MESSAGE->RESPONSE_TYPE_TEXT !== 'DECLINED';
        
        return $validationPassed && $notDeclined;
    }
    
    /**
     * Get the response message
     *
     * @return string|null
     */
    public function getMessage()
    {
        // Check for validation error
        if (isset($this->data->VALIDATION_MESSAGE) && 
            isset($this->data->VALIDATION_MESSAGE->VALIDATION_ERROR) && 
            isset($this->data->VALIDATION_MESSAGE->VALIDATION_ERROR->MESSAGE)) {
            return (string)$this->data->VALIDATION_MESSAGE->VALIDATION_ERROR->MESSAGE;
        }
        
        // Check for exception message
        if (isset($this->data->EXCEPTION) && isset($this->data->EXCEPTION->MESSAGE)) {
            return (string)$this->data->EXCEPTION->MESSAGE;
        }
        
        // Check for authorization message
        if (isset($this->data->AUTHORIZATION_MESSAGE) && isset($this->data->AUTHORIZATION_MESSAGE->MESSAGE)) {
            return (string)$this->data->AUTHORIZATION_MESSAGE->MESSAGE;
        }
        
        return 'Unknown response';
    }
    
    /**
     * Get the transaction reference
     *
     * @return string|null
     */
    public function getTransactionReference()
    {
        return isset($this->data->AUTHORIZATION_MESSAGE) && 
               isset($this->data->AUTHORIZATION_MESSAGE->TRANSACTION_ID) 
                    ? (string)$this->data->AUTHORIZATION_MESSAGE->TRANSACTION_ID 
                    : null;
    }
}