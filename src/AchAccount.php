<?php

namespace Omnipay\Paya;

use Omnipay\Common\Helper;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * ACH Account class
 *
 * This class defines and encapsulates ACH bank account details and account holder information
 */
class AchAccount
{
    /**
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    protected $parameters;

    /**
     * Create a new ACH Account object
     *
     * @param array $parameters An array of parameters to load
     */
    public function __construct($parameters = null)
    {
        $this->initialize($parameters);
    }

    /**
     * Initialize this ACH account object
     *
     * @param array $parameters An array of parameters to load
     * @return AchAccount
     */
    public function initialize($parameters = null)
    {
        $this->parameters = new ParameterBag();

        Helper::initialize($this, $parameters);

        return $this;
    }

    /**
     * Get all parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters->all();
    }

    /**
     * Get one parameter
     *
     * @param string $key Parameter key
     * @return mixed
     */
    protected function getParameter($key)
    {
        return $this->parameters->get($key);
    }

    /**
     * Set one parameter
     *
     * @param string $key Parameter key
     * @param mixed $value Parameter value
     * @return AchAccount
     */
    protected function setParameter($key, $value)
    {
        $this->parameters->set($key, $value);

        return $this;
    }

    /**
     * Get the routing number
     *
     * @return string
     */
    public function getRoutingNumber()
    {
        return $this->getParameter('routingNumber');
    }

    /**
     * Set the routing number
     *
     * @param string $value
     * @return AchAccount
     */
    public function setRoutingNumber($value)
    {
        return $this->setParameter('routingNumber', $value);
    }

    /**
     * Get the account number
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->getParameter('accountNumber');
    }

    /**
     * Set the account number
     *
     * @param string $value
     * @return AchAccount
     */
    public function setAccountNumber($value)
    {
        return $this->setParameter('accountNumber', $value);
    }

    /**
     * Get the account type
     *
     * @return string
     */
    public function getAccountType()
    {
        return $this->getParameter('accountType') ?: 'Checking';
    }

    /**
     * Set the account type
     *
     * @param string $value
     * @return AchAccount
     */
    public function setAccountType($value)
    {
        return $this->setParameter('accountType', $value);
    }

    /**
     * Get the bank name
     *
     * @return string
     */
    public function getBankName()
    {
        return $this->getParameter('bankName');
    }

    /**
     * Set the bank name
     *
     * @param string $value
     * @return AchAccount
     */
    public function setBankName($value)
    {
        return $this->setParameter('bankName', $value);
    }

    /**
     * Get the bank account token (for tokenized operations)
     *
     * @return string
     */
    public function getToken()
    {
        return $this->getParameter('token');
    }

    /**
     * Set the bank account token
     *
     * @param string $value
     * @return AchAccount
     */
    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }

    // Personal & Billing Details

    /**
     * Get the first name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->getParameter('firstName');
    }

    /**
     * Set the first name
     *
     * @param string $value
     * @return AchAccount
     */
    public function setFirstName($value)
    {
        return $this->setParameter('firstName', $value);
    }

    /**
     * Get the last name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->getParameter('lastName');
    }

    /**
     * Set the last name
     *
     * @param string $value
     * @return AchAccount
     */
    public function setLastName($value)
    {
        return $this->setParameter('lastName', $value);
    }

    /**
     * Get the billing address line 1
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->getParameter('address1');
    }

    /**
     * Set the billing address line 1
     *
     * @param string $value
     * @return AchAccount
     */
    public function setAddress1($value)
    {
        return $this->setParameter('address1', $value);
    }

    /**
     * Get the billing address line 2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->getParameter('address2');
    }

    /**
     * Set the billing address line 2
     *
     * @param string $value
     * @return AchAccount
     */
    public function setAddress2($value)
    {
        return $this->setParameter('address2', $value);
    }

    /**
     * Get the billing city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->getParameter('city');
    }

    /**
     * Set the billing city
     *
     * @param string $value
     * @return AchAccount
     */
    public function setCity($value)
    {
        return $this->setParameter('city', $value);
    }

    /**
     * Get the billing state
     *
     * @return string
     */
    public function getState()
    {
        return $this->getParameter('state');
    }

    /**
     * Set the billing state
     *
     * @param string $value
     * @return AchAccount
     */
    public function setState($value)
    {
        return $this->setParameter('state', $value);
    }

    /**
     * Get the billing postal code
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->getParameter('postcode');
    }

    /**
     * Set the billing postal code
     *
     * @param string $value
     * @return AchAccount
     */
    public function setPostcode($value)
    {
        return $this->setParameter('postcode', $value);
    }

    /**
     * Get the billing phone number
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->getParameter('phone');
    }

    /**
     * Set the billing phone number
     *
     * @param string $value
     * @return AchAccount
     */
    public function setPhone($value)
    {
        return $this->setParameter('phone', $value);
    }

    /**
     * Get the driver's license state
     *
     * @return string
     */
    public function getDlState()
    {
        return $this->getParameter('dlState');
    }

    /**
     * Set the driver's license state
     *
     * @param string $value
     * @return AchAccount
     */
    public function setDlState($value)
    {
        return $this->setParameter('dlState', $value);
    }

    /**
     * Get the driver's license number
     *
     * @return string
     */
    public function getDlNumber()
    {
        return $this->getParameter('dlNumber');
    }

    /**
     * Set the driver's license number
     *
     * @param string $value
     * @return AchAccount
     */
    public function setDlNumber($value)
    {
        return $this->setParameter('dlNumber', $value);
    }

    /**
     * Get the courtesy card ID
     *
     * @return string
     */
    public function getCourtesyCardId()
    {
        return $this->getParameter('courtesyCardId');
    }

    /**
     * Set the courtesy card ID
     *
     * @param string $value
     * @return AchAccount
     */
    public function setCourtesyCardId($value)
    {
        return $this->setParameter('courtesyCardId', $value);
    }
}