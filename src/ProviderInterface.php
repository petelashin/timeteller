<?php

namespace Pete\Timeteller;

use GuzzleHttp\Psr7\Response;

/**
 * Provider interface
 */
interface ProviderInterface
{
    /**
     * @param string|null $ip
     * @return string
     */
    public function getUrl(?string $ip): string;

    /**
     * @param Response $response
     * @return mixed
     */
    public function getResult(Response $response);
}