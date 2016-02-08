<?php
namespace Craft;

class FastlyPlugin extends BasePlugin
{

  public function init()
  {
    // Whenever an entry is saved, bust the Fastly cache
    craft()->entries->onSaveEntry = function(Event $event) {
      $this->purgeFastlyCache();
    };
  }

  protected function defineSettings()
  {
      return array(
        'fastlyApiKey' => array(
            AttributeType::String, 'label' => 'Fastly API Key'
        ),
        'fastlyServiceId' => array(
            AttributeType::String, 'label' => 'Fastly ServiceId'
        ),
      );
  }

	function getName()
	{
		return Craft::t('Fastly');
	}

	function getVersion()
	{
		return '0.1';
	}

	function getDeveloper()
	{
		return 'One Design Company';
	}

	function getDeveloperUrl()
	{
		return 'http://onedesigncompany.com';
	}

  public function getSettingsHtml()
  {
     return craft()->templates->render('fastly/_settings', array(
         'settings' => $this->getSettings()
     ));
  }

  public function purgeFastlyCache()
  {
    $fastlyKey = $this->getSettings()->fastlyApiKey;
    $serviceId = $this->getSettings()->fastlyServiceId;

    $client = new \Guzzle\Http\Client();

    $url = 'https://api.fastly.com/service/' . $serviceId . '/purge_all';

    $headers = [
      'Fastly-Key' => $fastlyKey,
      'Accept' => 'application/json',
    ];

    $request = new \Guzzle\Http\Message\Request('POST', $url, $headers);

    $response = $client->send($request);

    if ($response->getStatusCode() == 200) {
      return $response;
    }

    return 'Something went wrong.';
  }
}
