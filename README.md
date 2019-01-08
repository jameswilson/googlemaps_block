Google Maps Block
=================

This module for Drupal 8 creates a Block type called 'Google Map' that can be
used to create a simple themed embedded map with a single Map Marker and an
Info Window either opened or closed at load. The bulk of the logic is directly
in the template file googlemaps-block.html.twig which you can override and
modify in your own theme to your needs, for example, to modify the default
[Blue theme][1] from SnazzyMaps.

This is a dead simple implementation for the most basic needs, only core Drupal
Block API is supported. If your needs are more complicated, please evaluate the
[Geofield Map][2], which also uses the Info Window feature and supports
multiple markers and the [Styled Google Map][3] modules which leverages the
infobubble.js API. Both of these modules have dependencies on the Geofield
module and GeoPHP PHP library.


Requirements
============

Unlike Geofield Map and Styled Google Map modules, this module has no other
Drupal or PHP dependencies.

However a project must be created in Google Cloud Platform, and you must
enable the Google Maps Javascript API and generate an API Key. Please see
the [Maps Javascript API documentation][4] for further details.


Installation
============

1.  Install this just like any other Drupal module hosted on Github.

    Add googlemaps_block to the "repositories" section of your project's
    main composer.json file:

        "jameswilson/filename_transliteration": {
            "type": "vcs",
            "url":  "git@github.com:jameswilson/googlemaps_block.git"
        }

    Then require the module with composer and install with drush:

        $ composer require jameswilson/googlemaps_block
        $ drush en googlemaps_block

2.  Navigate to /admin/structure/block, click the "Place block" button find the
    "Google Maps block" option.

3.  Fill in the various fields including the API Key, the lat/long coordinates,
    the min/max/default zoom levels; provide an info window title, and the body
    text for the info window.

4.  Save the block, visit the front-end of your site to verify the map is
    working.

5.  Optionally, if your site is multi-lingual, the Info Window's title and body
    fields will be translatable.



[1]: https://snazzymaps.com/style/237761/blue
[2]: https://www.drupal.org/project/geofield_map
[3]: https://www.drupal.org/project/styled_google_map
[4]: https://developers.google.com/maps/documentation/javascript/tutorial

