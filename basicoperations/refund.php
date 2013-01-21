<?php

class Payvision_BasicOperations_Refund extends Payvision_Operation
{
	protected $_action     = 'basicoperations';
	protected $_operation  = 'Refund';
	protected $_parameters = array(
			'memberId'            => array(
					'required' => TRUE,
				),
			'memberGuid'          => array(
					'required' => TRUE,
				),
			'transactionId'       => array(
					'required' => TRUE,
				),
			'transactionGuid'       => array(
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
		);

	public function setTransactionIdAndGuid ($transaction_id, $transaction_guid)
	{
		if ($transaction_id && ctype_digit($transaction_id) && $transaction_guid)
		{
			$this->addData('transactionId', $transaction_id);
			$this->addData('transactionGuid', $transaction_guid);
		}
		else
		{
			throw new Payvision_Exception('Transaction ID or GUID not set or invalid');
		}
	}

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
}


