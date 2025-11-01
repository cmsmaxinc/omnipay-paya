<?php

namespace Omnipay\Paya\Message;

class VoidResponse extends AbstractResponse
{
    /**
     * Get the response code
     *
     * @return string|null
     */
    public function getCode()
    {
        return isset($this->data->AUTHORIZATION_MESSAGE) && 
               isset($this->data->AUTHORIZATION_MESSAGE->CODE) 
                    ? (string)$this->data->AUTHORIZATION_MESSAGE->CODE 
                    : null;
    }
    
    /**
     * Get the response type
     *
     * @return string|null
     */
    public function getResponseType()
    {
        return isset($this->data->AUTHORIZATION_MESSAGE) && 
               isset($this->data->AUTHORIZATION_MESSAGE->RESPONSE_TYPE) 
                    ? (string)$this->data->AUTHORIZATION_MESSAGE->RESPONSE_TYPE 
                    : null;
    }
    
    /**
     * Get the response type text
     *
     * @return string|null
     */
    public function getResponseTypeText()
    {
        return isset($this->data->AUTHORIZATION_MESSAGE) && 
               isset($this->data->AUTHORIZATION_MESSAGE->RESPONSE_TYPE_TEXT) 
                    ? (string)$this->data->AUTHORIZATION_MESSAGE->RESPONSE_TYPE_TEXT 
                    : null;
    }
}
