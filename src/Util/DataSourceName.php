<?php

namespace Trafficgate\Transferer\Util;

class DataSourceName
{
    /** The delimiter between the username and the host. */
    public const USER_DELIMITER = '@';

    /** The delimiter between the host and the file. */
    public const HOST_DELIMITER = ':';

    /**
     * Create the string to connect for SCP file transfer.
     *
     * String should be in the format [[user@][host:]path.
     *
     * @param $path
     * @param null $host
     * @param null $user
     *
     * @return string
     */
    public static function join($path, $host = null, $user = null)
    {
        $dsn = '';
        $dsn .= isset($user, $host, $path) ? $user . static::USER_DELIMITER : '';
        $dsn .= isset($host, $path) ? $host . static::HOST_DELIMITER : '';
        $dsn .= $path;

        return $dsn;
    }

    /**
     * Split a DSN.
     *
     * String should be in the format [[user@]host:]path.
     * Array will be user, host, path.
     *
     * @param $dsn
     * @returns array
     */
    public static function split($dsn)
    {
        $user = null;
        $host = null;
        $path = null;

        // Split the dsn by @ first
        // If any value is found, the array should be 2
        // Remove th first value from the dsn
        $values = explode(static::USER_DELIMITER, $dsn);

        if (count($values) === 2) {
            $user = $values[0];
            $dsn  = $values[1];
        }

        // Split the dsn by : second
        // If any value is found, the array should be 2
        // Remove the first value from the dsn
        $values = explode(static::HOST_DELIMITER, $dsn);

        if (count($values) === 2) {
            $host = $values[0];
            $dsn  = $values[1];
        }

        $path = $dsn;

        return [
            $user,
            $host,
            $path,
        ];
    }
}
