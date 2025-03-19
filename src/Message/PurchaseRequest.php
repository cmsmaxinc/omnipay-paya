<?php

namespace Omnipay\Paya\Message;

use DOMDocument;

class PurchaseRequest extends AbstractRequest
{
    public function getRequestId()
    {
        return $this->getParameter('requestId');
    }
    
    public function setRequestId($value)
    {
        return $this->setParameter('requestId', $value);
    }
    
    public function getTransactionId()
    {
        return $this->getParameter('transactionId');
    }
    
    public function setRoutingNumber($value)
    {
        return $this->setParameter('routingNumber', $value);
    }
    
    public function getRoutingNumber()
    {
        return $this->getParameter('routingNumber');
    }
    
    public function setAccountNumber($value)
    {
        return $this->setParameter('accountNumber', $value);
    }
    
    public function getAccountNumber()
    {
        return $this->getParameter('accountNumber');
    }
    
    public function setAccountType($value)
    {
        return $this->setParameter('accountType', $value);
    }
    
    public function getAccountType()
    {
        return $this->getParameter('accountType') ?: 'Checking';
    }
    
    public function setIdentifier($value)
    {
        return $this->setParameter('identifier', $value);
    }
    
    public function getIdentifier()
    {
        return $this->getParameter('identifier') ?: 'R';
    }
    
    public function setDlState($value)
    {
        return $this->setParameter('dlState', $value);
    }
    
    public function getDlState()
    {
        return $this->getParameter('dlState');
    }
    
    public function setDlNumber($value)
    {
        return $this->setParameter('dlNumber', $value);
    }
    
    public function getDlNumber()
    {
        return $this->getParameter('dlNumber');
    }
    
    public function setCourtesyCardId($value)
    {
        return $this->setParameter('courtesyCardId', $value);
    }
    
    public function getCourtesyCardId()
    {
        return $this->getParameter('courtesyCardId');
    }
    
    /**
     * Get the data for sending to the gateway
     *
     * @return string
     */
    public function getData()
    {
        $this->validate(
            'requestId',
            'transactionId',
            'amount',
            'routingNumber',
            'accountNumber',
            'firstName', 
            'lastName',
            'address1',
            'city',
            'state',
            'postcode'
        );
        
        return $this->buildDataPacket();
    }
    
    /**
     * Build the XML data packet for the request
     *
     * @return string
     */
    protected function buildDataPacket()
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        
        $authGateway = $dom->createElement('AUTH_GATEWAY');
        $authGateway->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $authGateway->setAttribute('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema');
        $authGateway->setAttribute('REQUEST_ID', $this->getRequestId());
        
        $transaction = $dom->createElement('TRANSACTION');
        $transactionId = $dom->createElement('TRANSACTION_ID', $this->getTransactionId());
        $transaction->appendChild($transactionId);
        
        $merchant = $dom->createElement('MERCHANT');
        $terminalId = $dom->createElement('TERMINAL_ID', $this->getTerminalId());
        $merchant->appendChild($terminalId);
        $transaction->appendChild($merchant);
        
        $packet = $dom->createElement('PACKET');
        $identifier = $dom->createElement('IDENTIFIER', $this->getIdentifier());
        $packet->appendChild($identifier);
        
        $account = $dom->createElement('ACCOUNT');
        $account->appendChild($dom->createElement('ROUTING_NUMBER', $this->getRoutingNumber()));
        $account->appendChild($dom->createElement('ACCOUNT_NUMBER', $this->getAccountNumber()));
        $account->appendChild($dom->createElement('ACCOUNT_TYPE', $this->getAccountType()));
        $packet->appendChild($account);
        
        $consumer = $dom->createElement('CONSUMER');
        $consumer->appendChild($dom->createElement('FIRST_NAME', $this->getFirstName()));
        $consumer->appendChild($dom->createElement('LAST_NAME', $this->getLastName()));
        $consumer->appendChild($dom->createElement('ADDRESS1', $this->getAddress1()));
        
        if ($this->getAddress2()) {
            $consumer->appendChild($dom->createElement('ADDRESS2', $this->getAddress2()));
        }
        
        $consumer->appendChild($dom->createElement('CITY', $this->getCity()));
        $consumer->appendChild($dom->createElement('STATE', $this->getState()));
        $consumer->appendChild($dom->createElement('ZIP', $this->getPostcode()));
        
        if ($this->getDlState()) {
            $consumer->appendChild($dom->createElement('DL_STATE', $this->getDlState()));
        }
        
        if ($this->getDlNumber()) {
            $consumer->appendChild($dom->createElement('DL_NUMBER', $this->getDlNumber()));
        }
        
        if ($this->getCourtesyCardId()) {
            $consumer->appendChild($dom->createElement('COURTESY_CARD_ID', $this->getCourtesyCardId()));
        }
        
        $packet->appendChild($consumer);
        
        $check = $dom->createElement('CHECK');
        $check->appendChild($dom->createElement('CHECK_AMOUNT', $this->getAmount()));
        $packet->appendChild($check);
        
        $transaction->appendChild($packet);
        $authGateway->appendChild($transaction);
        
        return $dom->saveXML($authGateway);
    }
    
    /**
     * Create the response object
     *
     * @param mixed $data
     * @return PurchaseResponse
     */
    protected function createResponse($data)
    {
        return new PurchaseResponse($this, $data);
    }
}