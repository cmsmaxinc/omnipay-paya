<?php

namespace Omnipay\Paya\Message;

use DOMDocument;

class VoidRequest extends AbstractRequest
{
    public function getRequestId()
    {
        return $this->getParameter('requestId');
    }

    public function setRequestId($value)
    {
        return $this->setParameter('requestId', $value);
    }

    public function setIdentifier($value)
    {
        return $this->setParameter('identifier', $value);
    }

    public function getIdentifier()
    {
        return $this->getParameter('identifier') ?: 'V';
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
            'achAccount'
        );
        
        $achAccount = $this->getAchAccount();
        
        // Validate token for void transactions
        if (!$achAccount->getToken()) {
            throw new \InvalidArgumentException("The token parameter is required for void transactions");
        }
        
        // Validate minimal customer information required for void
        if (!$achAccount->getFirstName() || !$achAccount->getLastName() || 
            !$achAccount->getBillingAddress1() || !$achAccount->getBillingCity() || 
            !$achAccount->getBillingState() || !$achAccount->getBillingPostcode()) {
            throw new \InvalidArgumentException("Customer information (name, billing address) is required");
        }
        
        return $this->buildDataPacket();
    }

    /**
     * Build the XML data packet for the void request
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
        
        $achAccount = $this->getAchAccount();
        
        $account = $dom->createElement('ACCOUNT');
        $account->appendChild($dom->createElement('TOKEN', $achAccount->getToken()));
        $packet->appendChild($account);
        
        $consumer = $dom->createElement('CONSUMER');
        $consumer->appendChild($dom->createElement('FIRST_NAME', $achAccount->getFirstName()));
        $consumer->appendChild($dom->createElement('LAST_NAME', $achAccount->getLastName()));
        $consumer->appendChild($dom->createElement('ADDRESS1', $achAccount->getBillingAddress1()));
        
        if ($achAccount->getBillingAddress2()) {
            $consumer->appendChild($dom->createElement('ADDRESS2', $achAccount->getBillingAddress2()));
        }
        
        $consumer->appendChild($dom->createElement('CITY', $achAccount->getBillingCity()));
        $consumer->appendChild($dom->createElement('STATE', $achAccount->getBillingState()));
        $consumer->appendChild($dom->createElement('ZIP', $achAccount->getBillingPostcode()));
        $packet->appendChild($consumer);
        
        // For void transactions, amount may not be required or should be the original amount
        // Include it if provided
        if ($this->getAmount()) {
            $check = $dom->createElement('CHECK');
            $check->appendChild($dom->createElement('CHECK_AMOUNT', $this->getAmount()));
            $packet->appendChild($check);
        }
        
        $transaction->appendChild($packet);
        $authGateway->appendChild($transaction);
        
        return $dom->saveXML($authGateway);
    }

    /**
     * Create the response object
     *
     * @param \SimpleXMLElement $data
     * @return VoidResponse
     */
    protected function createResponse($data)
    {
        return new VoidResponse($this, $data);
    }
}
