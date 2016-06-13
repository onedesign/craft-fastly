<?php

namespace Craft;

class FastlyService extends BaseApplicationComponent
{
    /**
     * The plugins settings
     *
     * @var
     */
    protected $settings;

    /**
     * FastlyService constructor.
     */
    public function __construct()
    {
        $this->settings = craft()->plugins->getPlugin('fastly')->getSettings();
    }

    /**
     * Purge the fastly cache
     * 
     * @return bool
     */
    public function purgeFastlyCache()
    {
        $fastlyKey = $this->settings->fastlyApiKey;
        $serviceId = $this->settings->fastlyServiceId;

        $client = new \Guzzle\Http\Client();

        $url = 'https://api.fastly.com/service/' . $serviceId . '/purge_all';

        $headers = [
            'Fastly-Key' => $fastlyKey,
            'Accept' => 'application/json',
        ];

        $request = new \Guzzle\Http\Message\Request('POST', $url, $headers);

        try {
            $response = $client->send($request);
        } catch (\Exception $e) {
            $statusCode = $e->getResponse()->getInfo()['http_code'];

            FastlyPlugin::log('Fastly API returned a non-successful response: ' . $statusCode, LogLevel::Error);

            return false;
        }

        if ($response->getStatusCode() == 200) {
            return true;
        }
    }
}