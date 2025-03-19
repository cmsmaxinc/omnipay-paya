<?php

namespace Omnipay\Paya\Message;

use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;
use SoapClient;
use SoapHeader;
use DOMDocument;

abstract class AbstractRequest extends OmnipayAbstractRequest
{
    protected $endpoint = 'http://tempuri.org/GETI.eMagnus.WebServices/AuthGateway';
    
    /**
     * Get the WSDL URL
     *
     * @return string
     */
    protected function getWsdlUrl()
    {
        return $this->getTestMode()
            ? $this->getSandboxWsdlUrl()
            : $this->getProductionWsdlUrl();
    }

    /**
     * Get production WSDL URL
     *
     * @return string
     */
    public function getProductionWsdlUrl()
    {
        return $this->getParameter('productionWsdlUrl');
    }
    
    /**
     * Set production WSDL URL
     *
     * @param string $value
     * @return AbstractRequest
     */
    public function setProductionWsdlUrl($value)
    {
        return $this->setParameter('productionWsdlUrl', $value);
    }
    
    /**
     * Get sandbox WSDL URL
     *
     * @return string
     */
    public function getSandboxWsdlUrl()
    {
        return $this->getParameter('sandboxWsdlUrl');
    }
    
    /**
     * Set sandbox WSDL URL
     *
     * @param string $value
     * @return AbstractRequest
     */
    public function setSandboxWsdlUrl($value)
    {
        return $this->setParameter('sandboxWsdlUrl', $value);
    }
    
    /**
     * Get SOAP client
     *
     * @return SoapClient
     */
    protected function getSoapClient()
    {
        $soapClient = new SoapClient(
            $this->getWsdlUrl(),
            [
                'trace' => $this->getTestMode(),
                'exception' => true
            ]
        );
        
        $headerData = [
            'UserName' => $this->getUsername(),
            'Password' => $this->getPassword(),
            'TerminalID' => $this->getTerminalId(),
        ];
        
        $header = new SoapHeader(
            $this->endpoint, 
            'AuthGatewayHeader', 
            $headerData
        );
        
        $soapClient->__setSoapHeaders($header);
        
        return $soapClient;
    }
    
    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }
    
    /**
     * Set username
     *
     * @param string $value
     * @return AbstractRequest
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }
    
    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }
    
    /**
     * Set password
     *
     * @param string $value
     * @return AbstractRequest
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }
    
    /**
     * Get terminal ID
     *
     * @return string
     */
    public function getTerminalId()
    {
        return $this->getParameter('terminalId');
    }
    
    /**
     * Set terminal ID
     *
     * @param string $value
     * @return AbstractRequest
     */
    public function setTerminalId($value)
    {
        return $this->setParameter('terminalId', $value);
    }
    
    /**
     * Get the method and result property names based on test mode
     *
     * @return array
     */
    protected function getMethodAndResultProperty()
    {
        $method = $this->getTestMode() 
            ? 'ProcessSingleCertificationCheckWithToken' 
            : 'ProcessSingleCheckWithToken';
        
        $resultProperty = $this->getTestMode() 
            ? 'ProcessSingleCertificationCheckWithTokenResult' 
            : 'ProcessSingleCheckWithTokenResult';
        
        return [$method, $resultProperty];
    }
    
    /**
     * Send data to the gateway
     *
     * @param mixed $data
     * @return mixed
     */
    public function sendData($data)
    {
        $soapClient = $this->getSoapClient();
        list($method, $resultProperty) = $this->getMethodAndResultProperty();
        
        $body = [
            'DataPacket' => $data
        ];
        
        $result = $soapClient->__soapCall($method, [$body]);
        $xmlResponse = simplexml_load_string($result->{$resultProperty});
        
        return $this->createResponse($xmlResponse);
    }
    
    /**
     * Create the appropriate response object
     *
     * @param \SimpleXMLElement $data
     * @return AbstractResponse
     */
    abstract protected function createResponse($data);
}