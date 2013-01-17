<?php
	require(__DIR__ . '/../require.php');

	try
	{
		$client = new Payvision_Client();

		$payment = new Payvision_ThreeDSecureOperations_PaymentUsingIntegratedMPI;
		$payment->setMember('1234', 'AAAA-AAAA-AAAA');
		$payment->setCountryId(Payvision_Translator::getCountryIdFromIso('NLD'));

		$payment->setTrackingMemberCode('PaymentUsingIntegratedMPI ' . date('His dmY'));

		$payment->setCardValidationCode('');

		// ID returned in the Enrollment check: $operation->getResultEnrollmentId()
		$payment->setEnrollmentId(1);

		// Tracking Member Code used in the Enrollment check
		$payment->setEnrollmentTrackingMemberCode('');

		// Provided in redirection after 3D secure check: $_POST['PaRes']
		$payment->setPayerAuthenticationResponse('');

		$client->call($payment);
	}
	catch (Payvision_Exception $e)
	{
		echo $e->getMessage();
	}