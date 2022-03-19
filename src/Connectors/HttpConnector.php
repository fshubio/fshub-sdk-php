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
            'X-Pilot-Token' => $this->apiKey,
            'User-Agent' => 'FsHub-Sdk-Php/1.0',
        ];

        // @todo Make the API request to FsHub (using cURL)


        $connectorResponse->status = 200;
        $connectorResponse->body = "This is where the text body will got..";

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