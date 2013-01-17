<?php

class Payvision_ThreeDSecureOperations_PaymentUsingIntegratedMPI extends Payvision_Operation
{
	protected $_action     = 'threedsecureoperations';
	protected $_operation  = 'PaymentUsingIntegratedMPI';
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
			'trackingMemberCode'  => array(
					'required' => TRUE,
				),
			'cardCvv'             => array(),
			'merchantAccountType' => array(
					'required'      => TRUE,
					'default_value' => 1 // E-commerce
				),
			'dynamicDescriptor'   => array(),
			'avsAddress'          => array(),
			'avsZip'              => array(),
			'enrollmentId'  => array(
					'required' => TRUE,
				),
			'enrollmentTrackingMemberCode' => array(
					'required' => TRUE,
				),
			'payerAuthenticationResponse' => array(
					'required' => TRUE, // Required if you would really want this to be a 3dsecure payment
			),
		);

	public function setCardValidationCode ($card_vc)
	{
		$this->addData('cardCvv', $card_vc);
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

	public function setEnrollmentId ($enrollment_id)
	{
		$this->addData('enrollmentId', $enrollment_id);
	}

	public function setEnrollmentTrackingMemberCode ($enrollment_tracking_member_code)
	{
		$this->addData('enrollmentTrackingMemberCode', $enrollment_tracking_member_code);
	}

	public function setPayerAuthenticationResponse ($payer_authentication_response)
	{
		$this->addData('payerAuthenticationResponse', $payer_authentication_response);
	}
}