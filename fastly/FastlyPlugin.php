<?php

namespace Craft;

class FastlyPlugin extends BasePlugin
{
    /**
     * Initialize the plugin
     */
    public function init()
    {
        // Whenever an entry is saved, bust the Fastly cache
        craft()->entries->onSaveEntry = function (Event $event) {
            craft()->fastly->purgeFastlyCache();
        };
    }

    /**
     * Define plugins name
     *
     * @return mixed
     */
    public function getName()
    {
        return Craft::t('Fastly');
    }

    /**
     * Define the version
     *
     * @return string
     */
    public function getVersion()
    {
        return '0.1';
    }

    /**
     * Define the schema version
     * 
     * @return string
     */
    public function getSchemaVersion()
    {
        return '0.1';
    }

    /**
     * The Developer
     *
     * @return string
     */
    public function getDeveloper()
    {
        return 'One Design Company';
    }

    /**
     * Developers website
     *
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'http://onedesigncompany.com';
    }

    /**
     * Define the plugins settings
     *
     * @return array
     */
    protected function defineSettings()
    {
        return array(
            'fastlyApiKey' => array(
                'type' => AttributeType::String,
                'label' => 'Fastly API Key'
            ),
            'fastlyServiceId' => array(
                'type' => AttributeType::String,
                'label' => 'Fastly ServiceId'
            ),
        );
    }

    /**
     * Get the settings template
     *
     * @return mixed
     */
    public function getSettingsHtml()
    {
        return craft()->templates->render('fastly/_settings', array(
            'settings' => $this->getSettings()
        ));
    }
}
