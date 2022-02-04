<?php

namespace Pete\Timeteller\Providers;

use Pete\Timeteller\ProviderInterface;
use GuzzleHttp\Psr7\Response;

/**
 * WorldTimeApiProvider class
 */
class WorldTimeApiProvider implements ProviderInterface
{
    /**
     * Endpoint to connect to WorldTimeApi
     */
    const API_URL = 'http://worldtimeapi.org/api';

    /**
     * Method to get WorldTimeApi url to get date time by IP 
     * 
     * @param $ip
     * @return string
     */
    public function getUrl(?string $ip): string
    {
        return self::API_URL . '/ip' . $this->ipAsUrlParameter($ip);
    }

    /**
     * Method to add optional ip parameter to API url
     * 
     * @param string|null $ip
     * @return string|void
     */
    private function ipAsUrlParameter(string $ip = null): string
    {
        if ($ip) {
            return '/' . $ip . '.txt';
        }
        
        return '';
    }

    /**
     * Method to get datetime string from Response
     * 
     * @param Response $response
     * @return string|null
     */
    public function getResult(Response $response): string
    {
        $responseContent = $response->getBody()->getContents();

        $jsonObject = json_decode($responseContent);

        if (!is_object($jsonObject)) {

            /**
             * Parsing plaintext response
             *
             * 1. Remove part of string before datetime
             * 2. From substringed text get datetime value (it's content part of string before "day_of_week")
             */
            $needle = 'datetime: ';
            $position = strpos($responseContent, $needle);

            $substr = substr($responseContent,
                $position + strlen($needle),
                strlen($responseContent)
            );

            return trim(substr($substr, 0, strpos($substr, 'day_of_week')));
        } else {
            return $jsonObject->datetime;
        }
    }
}