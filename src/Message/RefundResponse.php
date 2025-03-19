<?php

namespace Omnipay\Paya\Message;

class RefundResponse extends AbstractResponse
{
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
    
    /**
     * Get response type
     *
     * @return string|null
     */
    public function getResponseType()
    {
        return isset($this->data->AUTHORIZATION_MESSAGE->RESPONSE_TYPE) 
            ? (string)$this->data->AUTHORIZATION_MESSAGE->RESPONSE_TYPE 
            : null;
    }
}