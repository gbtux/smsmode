Mumbee SMSModeBundle
--------------------

This bundle is made by [Mumbee](https://mumbee.fr)

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require "mumbee/smsmode-bundle" "dev-master"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

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
	    new Mumbee\SmsModeBundle\MumbeeSmsModeBundle(),
	    // ....
        );

        // ...
    }

    // ...
}
```

Step 3: Configuration
------------------------

This bundle is default configured for the 1.6 SMSMode API.

You can watch the defaut configured URL in the DependencyInjection\Configuration class.

By the way, you can override this in your project (the famous app/config.yml).

```
mumbee_sms_mode:
    url_envoi_sms: https://smsmode.com/thenewurl.do
```

Step 4: Test integration
------------------------

You can test with your own number with an integrated test command :

```
php bin/console mumbee:sms:send <SMSMode_pseudo> <SMSMode_password> <phonenumber(s) with space separator>
```
 
Other commands
--------------

All the feature is covered by a simple command :


### Get a "compte-rendu":

```
php bin/console mumbee:sms:compte_rendu <SMSMode_pseudo> <SMSMode_password> <SMS_ID>
```

### Get the account balance

```
php bin/console mumbee:sms:solde <SMSMode_pseudo> <SMSMode_password>
```

### Create a sub account

```
php bin/console mumbee:sms:compte:create <SMSMode_pseudo> <SMSMode_password> <newPseudo> <newPassword> <optionnalReference>
```

### Delete a sub account

```
php bin/console mumbee:sms:compte:delete <SMSMode_pseudo> <SMSMode_password> <pseudoToDelete>
```

### Transferring credits

```
php bin/console mumbee:sms:transfert <SMSMode_pseudo> <SMSMode_password> <targetPseudo> <nbCredits>
```

