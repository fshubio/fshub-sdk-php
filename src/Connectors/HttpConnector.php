<?php

namespace FsHub\Sdk\Connectors;

use ErrorException;
use FsHub\Sdk\Contracts\FsHubConnectorInterface;

class HttpConnector implements FsHubConnectorInterface
{

    private readonly string $apiKey;

    private const BASE_API_URL = "https://fshub.io/api/v3/";

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->checkCurlIsInstalled();
    }


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