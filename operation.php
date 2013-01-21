<?php

class Payvision_Operation
{
	protected $_action     = NULL;
	protected $_operation  = NULL;

	protected $_parameters = array();
	protected $_data       = array();

	protected $_result_object   = NULL;
	protected $_result_code     = NULL;
	protected $_result_message  = NULL;
	protected $_result_tracking_member_code = NULL;
	protected $_result_transaction_id       = NULL;
	protected $_result_transaction_guid     = NULL;
	protected $_result_transaction_datetime = NULL;
	protected $_result_cdc_name = NULL;
	protected $_result_cdc_data = array();

	public function __construct ()
	{
		$this->_generateDefaultData();
	}

	public function getOperationName ()
	{
		return $this->_operation;
	}

	public function getAction ()
	{
		return $this->_action;
	}

	public function getDataAsArray ()
	{
		return $this->_data;
	}

	public function addData ($name, $value)
	{
		if (isset($this->_data[$name]))
		{
			return $this->_data[$name] = $value;
		}
		else {
			throw new Payvision_Exception("Variable '{$name}' is not available'");
		}
	}

	public function setMember ($member_id, $member_guid)
	{
		$this->addData('memberId',   $member_id);
		$this->addData('memberGuid', $member_guid);
	}

	public function setCountryId ($country_id)
	{
		$this->addData('countryId', $country_id);
	}

	public function setTrackingMemberCode ($tracking_member_code)
	{
		$this->addData('trackingMemberCode', $tracking_member_code);
	}

	public function getResultState ()
	{
		return ($this->_result_code === '0');
	}

	public function getResultCode ()
	{
		return $this->_result_code;
	}

	public function getResultMessage ()
	{
		return $this->_result_message;
	}

	public function getResultTrackingMemberCode ()
	{
		return $this->_result_tracking_member_code;
	}

	public function getResultTransactionId ()
	{
		return $this->_result_transaction_id;
	}

	public function getResultTransactionGuid ()
	{
		return $this->_result_transaction_guid;
	}

	public function getResultTransactionDateTime ()
	{
		return $this->_result_transaction_datetime;
	}

	public function getResultCdcName ()
	{
		return $this->_result_cdc_name;
	}

	public function getResultCdcData ($key = NULL)
	{
		if (is_null($key))
		{
			return $this->_result_cdc_data;
		}
		elseif (isset($this->_result_cdc_data[$key]))
		{
			return $this->_result_cdc_data[$key];
		}

		return NULL;
	}

	protected function _generateDefaultData ()
	{
		foreach ($this->_parameters as $name => $settings)
		{
			$this->_data[$name] = (isset($settings['default_value']) ? $settings['default_value'] :'');
		}
	}

	public function checkRequiredData ()
	{
		foreach ($this->_parameters as $name => $settings)
		{
			// Check if required field is set (not empty)
			if (isset($settings['required']) && $settings['required'] === TRUE
				&& $this->_data[$name] == '')
			{
				return FALSE;
			}
		}

		return TRUE;
	}

	/**
	 * Save generic information in object from XML object returned by Payvision
	 *
	 * @param SimpleXMLElement $simplexml
	 */
	public function processXmlResult (SimpleXMLElement $simplexml)
	{
		if (isset($simplexml->Result))
		{
			$this->_result_code = $simplexml->Result->__toString();
		}

		if (isset($simplexml->Message))
		{
			$this->_result_message = $simplexml->Message->__toString();
		}

		if (isset($simplexml->TrackingMemberCode))
		{
			$this->_result_tracking_member_code = $simplexml->TrackingMemberCode->__toString();
		}

		if (isset($simplexml->TransactionId))
		{
			$this->_result_transaction_id = $simplexml->TransactionId->__toString();
		}

		if (isset($simplexml->TransactionGuid))
		{
			$this->_result_transaction_guid = $simplexml->TransactionGuid->__toString();
		}

		if (isset($simplexml->TransactionDateTime))
		{
			$this->_result_transaction_datetime = $simplexml->TransactionDateTime->__toString();
		}

		if (isset($simplexml->Cdc))
		{
			if (isset($simplexml->Cdc->CdcEntry->Name))
			{
				$this->_result_cdc_name = $simplexml->Cdc->CdcEntry->Name->__toString();
			}

			if (isset($simplexml->Cdc->CdcEntry->Items))
			{
				foreach($simplexml->Cdc->CdcEntry->Items->CdcEntryItem as $item)
				{
					$key = $item->Key->__toString();
					$this->_result_cdc_data[$key] = $item->Value->__toString();
				}
			}
		}
	}
}