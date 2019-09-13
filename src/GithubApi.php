<?php

namespace App;

/**
 * Class GithubApi
 * @package App
 */
class GithubApi
{
    const ENDPOINT_URL = 'https://api.github.com/graphql';

    /**
     * @return string
     */
    protected static function getToken(): string
    {
        return env('GITHUB_TOKEN');
    }

    /**
     * @param array $array
     * @return string
     */
    protected static function convertArrayToQuery(array $array): string
    {
        $query = '';

        foreach ($array as $node => $child) {
            if (is_string($child)) {
                $query .= $child . ',';
            } else {
                $query .= $node . '{';

                $query .= self::convertArrayToQuery($child);

                $query .= '}';
            }
        }

        return $query;
    }

    /**
     * @param string $query
     * @return string
     */
    protected static function escapeQuery(string $query): string
    {
        $query = str_replace("\r\n", '', $query);
        $query = str_replace('"', '\\\\\\"', $query);
        $query = preg_replace('/\s{2,}/', ' ', $query);

        return $query;
    }

    /**
     * @param string $query
     * @param string|null $variables
     * @return string
     */
    protected static function generateCurlCommandLine(string $query, ?string $variables = null): string
    {
        $arg = (!$variables)
            ? '{ \"query\": \"' . self::escapeQuery($query) . '\" }'
            : '{ \"query\": \"' . self::escapeQuery($query) . '\", \"variables\": \"' . self::escapeQuery($variables) . '\" }';

        return 'curl -H "Authorization: bearer ' . self::getToken() . '" -X POST -d "' . $arg . '" ' . self::ENDPOINT_URL;
    }

    /**
     * @param array $query
     * @param array|null $variables
     * @return mixed
     */
    public static function call(array $query, ?array $variables = null)
    {
        $query = self::convertArrayToQuery($query);

        if ($variables) {
            $variables = json_encode($variables);
        }

        $cmd = self::generateCurlCommandLine($query, $variables);

        exec($cmd, $output);

        if (sizeof($output)) {
            $output = json_decode($output[0]);
        }

        return $output;
    }
}