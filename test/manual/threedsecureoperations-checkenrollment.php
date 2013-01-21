<?php
	require(__DIR__ . '/../payvision_autoload.php');

	try
	{
		$client = new Payvision_Client(Payvision_Client::ENV_TEST);

		$operation = new Payvision_ThreeDSecureOperations_CheckEnrollment;
		$operation->setMember('1234', 'AAAA-AAAA-AAAA');
		$operation->setCountryId(Payvision_Translator::getCountryIdFromIso('NLD'));

		$operation->setCardNumberAndHolder('1234567890123456');
		$operation->setCardExpiry('01', '2013');

		$operation->setAmountAndCurrencyId(5, Payvision_Translator::getCurrencyIdFromIsoCode('EUR'));

		$operation->setTrackingMemberCode('CheckEnrollment ' . date('His dmY'));

		if ($client->call($operation))
		{
			var_dump($operation->getResultState(),
				$operation->getResultCode(),
				$operation->getResultMessage(),
				$operation->getResultTrackingMemberCode(),
				$operation->getResultCdcName(),
				$operation->getResultEnrollmentId(),
				$operation->getResultIssuerUrl(),
				$operation->getResultPaymentAuthenticationRequest());

			echo $operation->getRedirectHtmlForm('https://www.google.com/');
		}
	}
	catch (Payvision_Exception $e)
	{
		echo $e->getMessage();
	}