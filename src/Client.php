<?php

namespace Pete\Timeteller;

use GuzzleHttp\Client As GuzzleClient;

use Pete\Timeteller\Providers\WorldTimeApiProvider;
use Pete\Timeteller\ProviderInterface;
use DateTime;

class Client
{
    private $guzzleClient;

    /**
     * Constructor
     * 
     * @param ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider)
    {
        /**
         * Create GuzzleHttpClient
         */
        $this->guzzleClient = new GuzzleClient(
            array('headers' => array('Content-Type' => 'application/json'))
        );

        /**
         * Time provider
         */
        $this->provider = $provider;
    }

    /**
     * Method to fetch datetime 
     * 
     * @param string|null $ip
     * @return DateTime
     * @throws \Exception
     */
    public function fetch(?string $ip): DateTime
    {
        /**
         * Ask provider about time
         */
        $response = $this->guzzleClient->get($this->provider->getUrl($ip));
        
        /**
         * Take datetime string from provider result
         */
        $result = $this->provider->getResult($response);

        /**
         * Return DateTime response
         */
        return new DateTime($result);
    }
}