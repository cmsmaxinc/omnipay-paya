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
            'transactionReference'
        );
        
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
        $transactionId = $dom->createElement('TRANSACTION_ID', $this->getTransactionReference());
        $transaction->appendChild($transactionId);
        
        $merchant = $dom->createElement('MERCHANT');
        $terminalId = $dom->createElement('TERMINAL_ID', $this->getTerminalId());
        $merchant->appendChild($terminalId);
        $transaction->appendChild($merchant);
        
        $packet = $dom->createElement('PACKET');
        $identifier = $dom->createElement('IDENTIFIER', $this->getIdentifier());
        $packet->appendChild($identifier);
        
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
