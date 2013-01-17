<?php

class Payvision_BasicOperations_Payment extends Payvision_Operation
{
	protected $_action     = 'basicoperations';
	protected $_operation  = 'Payment';
	protected $_parameters = array(
			'memberId'            => array(
					'required' => TRUE,
				),
			'memberGuid'          => array(
					'required' => TRUE,
				),
			'countryId'           => array(
					'required' => TRUE,
				),
			'amount'              => array(
					'required' => TRUE,
				),
			'currencyId'          => array(
					'required' => TRUE,
				),
			'trackingMemberCode'  => array(
					'required' => TRUE,
				),
			'cardNumber'          => array(
					'required' => TRUE,
				),
			'cardHolder'          => array(),
			'cardExpiryMonth'     => array(
					'required' => TRUE,
				),
			'cardExpiryYear'      => array(
					'required' => TRUE,
				),
			'cardCvv'             => array(),
			'cardType'            => array(),
			'issueNumber'         => array(),
			'merchantAccountType' => array(
					'required'      => TRUE,
					'default_value' => 1 // E-commerce
				),
			'dynamicDescriptor'   => array(),
			'avsAddress'          => array(),
			'avsZip'              => array(),
		);

	public function setAmountAndCurrencyId ($amount, $currency_id)
	{
		if (is_numeric($amount) && $amount > 0 && ctype_digit($currency_id))
		{
			$this->addData('amount',     $amount);
			$this->addData('currencyId', $currency_id);
		}
		else
		{
			throw new Payvision_Exception('Amount or Currency ID not set or invalid');
		}
	}

	public function setCardNumberAndHolder ($card_number, $card_holder = NULL)
	{
		$this->addData('cardNumber', $card_number);

		if ($card_holder)
			$this->addData('cardHolder', $card_holder);
	}

	public function setCardExpiry ($expiry_month, $expiry_year)
	{
		$this->addData('cardExpiryMonth', $expiry_month);
		$this->addData('cardExpiryYear',  $expiry_year);
	}

	public function setCardValidationCode ($card_vc)
	{
		$this->addData('cardCvv', $card_vc);
	}

	public function setCardType ($card_type)
	{
		$this->addData('cardType', $card_type);
	}

	public function setDynamicDescriptor ($descriptor)
	{
		$this->addData('dynamicDescriptor', $descriptor);
	}

	public function setAvsAddress ($avs_address, $avs_zip)
	{
		$this->addData('avsAddress', $avs_address);
		$this->addData('avsZip',     $avs_zip);
	}
}


