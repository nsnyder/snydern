<?php

namespace App\Http\Services;

use Config;

class LastFmService
{
    const BASE_URL = 'http://ws.audioscrobbler.com';

    /**
     * The base url of the Last.fm api to query
     *
     * @var string
     */
    protected $base_url;

    private function submitRequest(
        array $arguments,
        bool $get_json = true,
        string $path = '/2.0/'
    ) {
        $default_arguments = [
            'api_key' => Config::get('services.lastfm.key'),
            'user' => Config::get('services.lastfm.user')
        ];
        if ($get_json) {
            $default_arguments['format'] = 'json';
        }

        $arguments = array_merge(
            $arguments,
            $default_arguments
        );

        $request_url = $this->base_url . $path . '?' . http_build_query($arguments);

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_URL, $request_url);
        $result = curl_exec($curl_handle);
        curl_close($curl_handle);

        return json_decode($result);
    }

    public function __construct()
    {
        $this->base_url = self::BASE_URL;
    }

    /**
     * Get the last track played on last.fm
     *
     * @return string
     */
    public function getLatestTrack()
    {
        return $this->submitRequest(['method' => 'user.getrecenttracks']);
    }
}