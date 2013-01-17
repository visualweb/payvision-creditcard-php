<?php
	require(__DIR__ . '/../require.php');

	try
	{
		$client = new Payvision_Client();

		$payment = new Payvision_BasicOperations_Payment;
		$payment->setMember('1234', 'AAAA-AAAA-AAAA');
		$payment->setCountryId(Payvision_Translator::getCountryIdFromIso('NLD'));

		$payment->setCardNumberAndHolder('1234567890123456');
		$payment->setCardExpiry('01', '2013');
		$payment->setCardValidationCode('123');

		$payment->setAmountAndCurrencyId(5, Payvision_Translator::getCurrencyIdFromIsoCode('EUR'));

		$payment->setTrackingMemberCode('Payment ' . date('His dmY'));

		$client->call($payment);
	}
	catch (Payvision_Exception $e)
	{
		echo $e->getMessage();
	}