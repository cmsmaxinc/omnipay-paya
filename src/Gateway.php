<?php

namespace Omnipay\Paya;

use Omnipay\Common\AbstractGateway;

/**
 * Paya Gateway
 *
 * This gateway supports ACH transactions through Paya's SOAP API
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Paya';
    }

    public function getDefaultParameters()
    {
        return [
            'username' => '',
            'password' => '',
            'terminalId' => '',
            'testMode' => false,
            'productionWsdlUrl' => 'https://paya.com/AuthGateway.xml?WSDL',
            'sandboxWsdlUrl' => 'http://127.0.0.1:8000/paya/SandboxAuthGateway.xml?WSDL',
        ];
    }

    public function getProductionWsdlUrl()
    {
        return $this->getParameter('productionWsdlUrl');
    }

    public function setProductionWsdlUrl($value)
    {
        return $this->setParameter('productionWsdlUrl', $value);
    }

    public function getSandboxWsdlUrl()
    {
        return $this->getParameter('sandboxWsdlUrl');
    }

    public function setSandboxWsdlUrl($value)
    {
        return $this->setParameter('sandboxWsdlUrl', $value);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getTerminalId()
    {
        return $this->getParameter('terminalId');
    }

    public function setTerminalId($value)
    {
        return $this->setParameter('terminalId', $value);
    }
    
    /**
     * Create an ACH purchase request
     *
     * @param array $parameters
     * @return \Omnipay\Paya\Message\PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Paya\Message\PurchaseRequest', $parameters);
    }
    
    /**
     * Create an ACH refund request
     *
     * @param array $parameters
     * @return \Omnipay\Paya\Message\RefundRequest
     */
    public function refund(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Paya\Message\RefundRequest', $parameters);
    }
    
    /**
     * Create an ACH void request
     *
     * @param array $parameters
     * @return \Omnipay\Paya\Message\VoidRequest
     */
    public function void(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Paya\Message\VoidRequest', $parameters);
    }
}