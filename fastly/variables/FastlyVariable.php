<?php

namespace Craft;

class FastlyVariable
{
    /**
     * Get header for fastly code
     *
     * @return string
     */
    public function headers()
    {   
        $headerTemplate = '
            {% set expiry = now|date_modify(\'+30 days\') %}
            {% header "Cache-Control: max-age=" ~ expiry.timestamp %}
            {% header "Pragma: cache" %}
            {% header "Expires: " ~ expiry|date(\'D, d M Y H:i:s\', \'GMT\') ~ " GMT" %}
        ';
        return craft()->templates->renderString($headerTemplate);
    }
}
