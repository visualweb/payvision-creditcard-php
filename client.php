<?php

class Payvision_Client
{
	const ENV_TEST = 'test';
	const ENV_LIVE = 'live';

	protected $_environment    = NULL;

    protected $_ca_certificates_file = null;

	protected $_processor_host = array(
			'test' => 'testprocessor.payvisionservices.com',
			'live' => 'processor.payvisionservices.com',
		);

	public function __construct ($environment = self::ENV_LIVE)
	{
		$this->_environment = $environment;

		if ( ! function_exists('curl_init'))
		{
			throw new Payvision_Exception('cURL library is required to run this library');
		}
	}

    public function setCaCertificatesFile ($file)
    {
        if (file_exists($file))
        {
            $this->_ca_certificates_file = $file;
        }

        return false;
    }

	public function call (Payvision_Operation $operation)
	{
		if ($operation->checkRequiredData() !== TRUE)
		{
			throw new Payvision_Exception('Not all required fields are filled');
		}

		if (is_null($operation->getOperationName()) || is_null($operation->getAction()))
		{
			throw new Payvision_Exception('Operation has no Operation Name or Action specified');
		}

		$response = $this->_performRequest($operation);

		// XML to Object
		try
		{
			$simplexml = new SimpleXMLElement($response);
		}
		catch (Exception $e)
		{
			throw new Payvision_Exception('Result from Payvision is not XML (XML parsing failed: ' . $e->getMessage() . ')');
		}

		try
		{
			$operation->processXmlResult($simplexml);
		}
		catch (Payvision_Exception $e)
		{
			throw new Payvision_Exception('Unable to process XML data in ' . get_class($operation) . ' (' . $e->getMessage() . ')');
		}

		return TRUE;
	}

	protected function _performRequest (Payvision_Operation $operation)
	{
		$url  = 'https://' .
			$this->_processor_host[$this->_environment] .
			'/gateway/' . urlencode($operation->getAction()) . '.asmx/' .
			urlencode($operation->getOperationName());

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);

        if ($this->_ca_certificates_file)
        {
            curl_setopt($ch, CURLOPT_CAINFO, $this->_ca_certificates_file);
        }

		if ( ! is_null($operation->getDataAsArray()) && is_array($operation->getDataAsArray()))
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($operation->getDataAsArray()));
		}

		$response = curl_exec($ch);

		return $response;
	}
}