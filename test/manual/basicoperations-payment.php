<?php
	require(__DIR__ . '/../payvision_autoload.php');

	try
	{
		$client = new Payvision_Client(Payvision_Client::ENV_TEST);

		$payment = new Payvision_BasicOperations_Payment;
		$payment->setMember('1234', 'AAAA-AAAA-AAAA');
		$payment->setCountryId(Payvision_Translator::getCountryIdFromIso('NLD'));

		$payment->setCardNumberAndHolder('1234567890123456');
		$payment->setCardExpiry('01', '2013');
		$payment->setCardValidationCode('123');

		$payment->setAmountAndCurrencyId(5, Payvision_Translator::getCurrencyIdFromIsoCode('EUR'));

		$payment->setTrackingMemberCode('Payment ' . date('His dmY'));

		$client->call($payment);

		var_dump(
			$payment->getResultState(),
			$payment->getResultCode(),
			$payment->getResultMessage(),
			$payment->getResultTransactionId(),
			$payment->getResultTransactionGuid(),
			$payment->getResultTransactionDateTime(),
			$payment->getResultTrackingMemberCode(),
			$payment->getResultCdcData()
		);
	}
	catch (Payvision_Exception $e)
	{
		echo $e->getMessage();
	}