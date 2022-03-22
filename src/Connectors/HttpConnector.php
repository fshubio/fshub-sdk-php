<?php

namespace FsHub\Sdk\Connectors;

use ErrorException;
use FsHub\Sdk\Contracts\FsHubConnectorInterface;

class HttpConnector implements FsHubConnectorInterface
{

    private readonly string $apiKey;

    /**
     * The FsHub API Base URL
     */
    protected const BASE_API_URL = "https://fshub.io/api/v3/";

    /**
     * Create an instance of the standard HTTP connector.
     * @param string $apiKey An FsHub.io API Key
     * @throws ErrorException
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->checkCurlIsInstalled();
    }

    /**
     * Retrieve data from the FsHub API URI.
     * @param string $resourceIdentifier
     * @return ConnectorResponse
     * @throws \FsHub\Sdk\Exceptions\InvalidApiKeyException
     * @throws \FsHub\Sdk\Exceptions\NoRecordsFoundException
     * @throws \FsHub\Sdk\Exceptions\RateLimitExceededException
     */
    public function get(string $resourceIdentifier): ConnectorResponse
    {
        $connectorResponse = new ConnectorResponse();

        $headers = [
            'X-Pilot-Token: ' . $this->apiKey,
            'User-Agent: FsHub-Sdk-Php/1.0',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::BASE_API_URL . $resourceIdentifier);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $connectorResponse->status = $httpCode;
        $connectorResponse->body = $head;

        // Validate and throw exceptions if there are any issues...
        $connectorResponse->validate();

        return $connectorResponse;

    }

    private function checkCurlIsInstalled()
    {
        if (!extension_loaded("curl")) {
            throw new ErrorException("The FsHub SDK requires cURL to be installed and loaded to work but we could not find it!");
        }
    }
}