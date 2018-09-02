# PhotonOsmConnectorBundle
Allows to easily use the [Photon API](https://photon.komoot.de/) in your symphony project.

## Installation

### Step 1: Download the Bundle


Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require schoenef/photon-osm-connector-bundle:~1.0
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Schoenef\PhotonOsmConnectorBundle\SchoenefPhotonOsmConnectorBundle(), // geo coding service wrapper
        );

        // ...
    }

    // ...
}
```

### Step 3: Configure the Bundle

Add the following configuration to your ```app/config/config.yml```:
```yml
schoenef_photon_osm_connector:
  timeout: 20
  lang: de
```

### Usage

To use the connector, you can use the following inside of symfony controllers:

```php
$connector = $this->get('photon_osm.connector');
$results = $connector->searchLocation('berlin');
```

