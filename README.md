# Fastly integration plugin for Craft

This plugin helps integrate [Fastly](http://www.fastly.com) caching with Craft.

## What it does

- Adds the neccessary headers to your pages to enable Fastly caching.
- Listens for Entries to be saved and tells your Fastly app to invalidate its caches.

## Installation

To install, follow these steps:

1. Upload the fastly/ folder to your craft/plugins/ folder.
2. Go to Settings > Plugins from your Craft control panel and enable the Fastly plugin.
3. Open the settings for the plugin and add your Fastly account details
4. You'll likely also need to make some updates to your server and Fastly settings as outlined [in this document](https://gist.github.com/cmalven/1a36d9062e9a8c733c1d). 

## Templating

To add the necessary headers to your templates, just add the following to the very top of your `_layout.html` template:

```jinja
{{ craft.fastly.headers }}
```

