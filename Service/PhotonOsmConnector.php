<?php

namespace Aldaflux\AldafluxPhotonOsmConnectorBundle\Service;


use GuzzleHttp\Client;
use Aldaflux\AldafluxPhotonOsmConnectorBundle\DependencyInjection\Configuration;

class PhotonOsmConnector 
{

    private $config;

    private $client;
    private $clientReverse;

    private $lang;

    public function __construct(array $connectorConfig){
        $this->config = $connectorConfig;
        $this->client = new Client([
            'base_uri' => $this->config[Configuration::KEY_API_HOST],
            'timeout'  => $this->config[Configuration::KEY_TIMEOUT],
        ]);
        
        $this->clientReverse = new Client([
            'base_uri' => $this->config[Configuration::KEY_API_HOST_REVERSE],
            'timeout'  => $this->config[Configuration::KEY_TIMEOUT],
        ]);
        

        $this->lang = $this->config[Configuration::KEY_LANG];
    }


    /**
     * @param $name
     * @param array $filter the filter allows to reduce the results to certain types
     * @return array
     */
    public function searchLocation ($name, $filter = []) {
        $options = [];

        if ($this->lang) {
            $options['lang'] = $this->lang;
        }

        $options['q'] = $name;

        $response = $this->client->request('GET', '',['query' => $options]);

    
        if ($response->getStatusCode() == '200') {
            return $this->filterResult(json_decode($response->getBody()->getContents(), true)['features'], $filter);
        }

        return [];
    }
    
    
    
    /**
     * @param $name
     * @param array $filter the filter allows to reduce the results to certain types
     * @return array
     */
    public function searchOneLocation ($name) {
        $options = [];

        if ($this->lang) {
            $options['lang'] = $this->lang;
        }
        $options['q'] = $name;
        $response = $this->client->request('GET', '',['query' => $options]);
        if ($response->getStatusCode() == '200') {

            $result=json_decode($response->getBody()->getContents(), true);
            if (count($result['features']))
            {
                $result=$result['features'][0];
                return($result);
            }
        }

        return [];
    }
    
    
    
    
    public function reverseCoord($lon,$lat) 
    {
        $options = [];
        $options['lon'] = $lon;
        $options['lat'] = $lat;
        if ($this->lang) {
            $options['lang'] = $this->lang;
        }
        $response = $this->clientReverse->request('GET', '',['query' => $options]);

        if ($response->getStatusCode() == '200') 
        {
            $result=json_decode($response->getBody()->getContents(), true);
            if (count($result['features']))
            {
                $result=$result['features'][0]["properties"];
                return($result);
            }
        }

        return [];
    }
    
    
            


    public function filterResult ($featuresArray, $filter = []) {


        foreach ($filter as $key => $allowedValues) {
            $filteredResult = [];
            foreach ($featuresArray as $entry) {
                if (array_key_exists($key, $entry['properties']) && in_array($entry['properties'][$key], $allowedValues)) {
                    $filteredResult[] = $entry;
                }
            }

            $featuresArray = $filteredResult;
        }

        return $featuresArray;
    }

}
