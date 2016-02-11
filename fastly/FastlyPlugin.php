<?php
namespace Craft;

class FastlyPlugin extends BasePlugin
{

  public function init()
  {
    // Whenever an entry is saved, bust the Fastly cache
    craft()->entries->onSaveEntry = function(Event $event) {
      craft()->fastly->purgeFastlyCache();
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
}
