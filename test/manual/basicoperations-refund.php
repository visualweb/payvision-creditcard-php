<?php
	require(__DIR__ . '/../payvision_autoload.php');

	try
	{
		$client = new Payvision_Client(Payvision_Client::ENV_TEST);

		$operation = new Payvision_BasicOperations_Refund();
		$operation->setMember('1234', 'AAAA-AAAA-AAAA');

		$operation->setTransactionIdAndGuid('5678', 'BBBB-BBBB-BBBB');
		$operation->setAmountAndCurrencyId(5, Payvision_Translator::getCurrencyIdFromIsoCode('EUR'));

		$operation->setTrackingMemberCode('Refund ' . date('His dmY'));

		$client->call($operation);

		var_dump(
			$operation->getResultState(),
			$operation->getResultCode(),
			$operation->getResultMessage(),
			$operation->getResultTransactionId(),
			$operation->getResultTransactionGuid(),
			$operation->getResultTransactionDateTime(),
			$operation->getResultTrackingMemberCode(),
			$operation->getResultCdcData()
		);
	}
	catch (Payvision_Exception $e)
	{
		echo $e->getMessage();
	}