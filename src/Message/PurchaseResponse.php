<?php

namespace Omnipay\Paya\Message;

class PurchaseResponse extends AbstractResponse
{
    /**
     * Get the token for future transactions
     *
     * @return string|null
     */
    public function getToken()
    {
        return isset($this->data->AUTHORIZATION_MESSAGE->Token) 
            ? (string)$this->data->AUTHORIZATION_MESSAGE->Token 
            : null;
    }
    
    /**
     * Get response code
     *
     * @return string|null
     */
    public function getCode()
    {
        return isset($this->data->AUTHORIZATION_MESSAGE->CODE) 
            ? (string)$this->data->AUTHORIZATION_MESSAGE->CODE 
            : null;
    }
}