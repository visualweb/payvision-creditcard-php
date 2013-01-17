<?php

class Payvision_ThreeDSecureOperations_CheckEnrollment extends Payvision_Operation
{
	protected $_action     = 'threedsecureoperations';
	protected $_operation  = 'CheckEnrollment';
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
		);

	protected $_result_enrollment_id = NULL;
	protected $_result_issuer_url    = NULL;
	protected $_result_payment_authentication_request = NULL;

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

	public function getResultEnrollmentId ()
	{
		return $this->_result_enrollment_id;
	}

	public function getResultIssuerUrl ()
	{
		return $this->_result_issuer_url;
	}

	public function getResultPaymentAuthenticationRequest ()
	{
		return $this->_result_payment_authentication_request;
	}

	public function getRedirectHtmlForm ($return_url, $merchant_data = NULL)
	{
		$html =
			'<html>' . PHP_EOL .
			'	<head>' . PHP_EOL .
			'		<title>Payment - 3D secure redirect</title>' . PHP_EOL .
			'	</head>' . PHP_EOL .
			'	<script type="text/javascript">' . PHP_EOL .
			'		function OnLoadEvent()' . PHP_EOL .
			'		{' . PHP_EOL .
			'			// Make the form post as soon as it has been loaded.' . PHP_EOL .
			'			document.threedsecureform.submit();' . PHP_EOL .
			'		}' . PHP_EOL .
			'	</script>' . PHP_EOL .
			'	<body onload="OnLoadEvent();">' . PHP_EOL .
			'		<p>' . PHP_EOL .
			'			If your browser does not start loading the page, press the button below.' . PHP_EOL .
			'			You will be sent back to this site after you authorize the transaction.' . PHP_EOL .
			'		</p>' . PHP_EOL .
			'		<form name="threedsecureform" method="post" action="' . $this->getResultIssuerUrl() . '" target="_top">' . PHP_EOL .
			'		<button type="submit">Go to 3D secure page</button>' . PHP_EOL .
			'		<input type="hidden" name="PaReq" value="' . $this->getResultPaymentAuthenticationRequest() . '" />' . PHP_EOL .
			'		<input type="hidden" name="TermUrl" value="' . $return_url . '" />' . PHP_EOL .
			'		<input type="hidden" name="MD" value="' . $merchant_data . '" />' . PHP_EOL .
			'		</form>' . PHP_EOL .
			'	</body>' . PHP_EOL .
			'</html>';

		return $html;
	}

	public function processXmlResult (SimpleXMLElement $simplexml)
	{
		parent::processXmlResult($simplexml);

		if (isset($simplexml->EnrollmentId))
		{
			$this->_result_enrollment_id = $simplexml->EnrollmentId->__toString();
		}

		if (isset($simplexml->IssuerUrl))
		{
			$this->_result_issuer_url = $simplexml->IssuerUrl->__toString();
		}

		if (isset($simplexml->PaymentAuthenticationRequest))
		{
			$this->_result_payment_authentication_request = $simplexml->PaymentAuthenticationRequest->__toString();
		}
	}
}