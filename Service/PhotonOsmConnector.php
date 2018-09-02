<?php

namespace Schoenef\PhotonOsmConnectorBundle\Service;


use GuzzleHttp\Client;
use Schoenef\PhotonOsmConnectorBundle\DependencyInjection\Configuration;

class PhotonOsmConnector {

    private $config;

    private $client;

    private $lang;

    public function __construct(array $connectorConfig){
        $this->config = $connectorConfig;

        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $this->config[Configuration::KEY_API_HOST],
            // You can set any number of default request options.
            'timeout'  => $this->config[Configuration::KEY_TIMEOUT],
        ]);

        $this->lang = $this->config[Configuration::KEY_LANG];
    }


    /**
     * @param $name
     * @param array $filter
     * @return array
     */
    public function searchLocation ($name, $filter = []) {
        $options = [];

        if ($this->lang) {
            $options['lang'] = $this->lang;
        }

        $options['q'] = $name;

        $response = $this->client->request('GET', '/', ['query' => $options]);

        if ($response->getStatusCode() == '200') {
            print_r($response->getBody());
        }

        return [];
    }

}