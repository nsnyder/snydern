<?php

namespace App\Http\Services;

use Config;
use Illuminate\Support\Collection;

class LastFmService
{
    const BASE_URL = 'http://ws.audioscrobbler.com';

    /**
     * The base url of the Last.fm api to query
     *
     * @var string
     */
    protected $base_url;

    /**
     * Send the request to Last.fm
     *
     * @param array $arguments
     * Arguments to put in the query string for the request
     * @param bool $get_json
     * Whether or not to return a json object. If false, returns XML
     * @param string $path
     * The path is really just the api version right now
     *
     * @return object
     */
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
        return $this->getRecentTracks(1)->first();
    }

    /**
     * Get the most recent tracks from Last.fm
     *
     * @param int $number
     * @param int $page
     * @param bool $extended
     *
     * @return Collection
     */
    public function getRecentTracks(int $number, int $page = 1, bool $extended = false)
    {
        return new Collection($this->submitRequest([
            'method' => 'user.getrecenttracks',
            'limit' => $number,
            'page' => $page,
            'extended' => $extended ? 1 : 0
        ])->recenttracks->track);
    }
}