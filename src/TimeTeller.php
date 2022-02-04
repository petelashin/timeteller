<?php

namespace Pete\Timeteller;

use Pete\Timeteller\Providers\WorldTimeApiProvider;

use \DateTime;
use \Exception;
use \TypeError;

/**
 * Feature class
 */
class TimeTeller
{
    const EXCEPTION_ERROR_MESSAGE = '
        TimeTeller: Unfortunatelly, something went wrong during the process. 
        Please contact petelashin@gmail.com to notify about the problem.';

    const IP_VALIDATION_ERROR_MESSAGE = 'TimeTeller: Please use correct IP address format.';

    /**
     * Method to fetch time
     * 
     * @param $ip
     * @return mixed
     */
    public static function tellTime($ip = null): DateTime {

        if ($ip) {
            if (self::validateIp($ip) === false) {
                throw new Exception(self::IP_VALIDATION_ERROR_MESSAGE);
            }
        }

        try {
            return (
                new Client(
                    new WorldTimeApiProvider()
                )
            )->fetch($ip);
        } catch (Exception $e) {
            throw new Exception(self::EXCEPTION_ERROR_MESSAGE);
        } catch (TypeError $e) {
            throw new Exception(self::EXCEPTION_ERROR_MESSAGE);
        }
    }

    /**
     * Method to validate IP 
     * 
     * @param $ip
     * @return bool
     */
    private static function validateIp($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return true;
        } else {
            return false;
        }
    }
}