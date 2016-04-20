Aws4AuthBundle
==============

[![Build Status](https://travis-ci.org/pculka/aws4-auth-bundle.png?branch=master)](https://travis-ci.org/pculka/aws4-auth-bundle)

## Installation

Installation is a quick 5 steps process:

1. Download AWS4AuthBundle
2. Enable the Bundle in your Kernel
3. Extend your model class
4. Configure your application's security.yml
5. Configure the AWS4AuthBundle


### Step 1: Install AWS4AuthBundle

The preferred way to install this bundle is via [Composer](http://getcomposer.org).
Check on [Packagist](https://packagist.org/packages/pculka/aws4-auth-bundle) the version you want to install and add it to your `composer.json`:

``` js
{
    "require": {
        // ...
        "pculka/aws4-auth-bundle": "dev-master"
    }
}
```

### Step 2: Enable the Bundle in your Kernel

To enable the bundle in the kernel, just add it to your `registerBundles()` function:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new PC\Aws4AuthBundle\PCAws4AuthBundle(),
    );
}
```

### Step 3: Extend your model class
### Step 4: Configure your application's security.yml
The bundle provides a security layer. This layer works as a sole authentication provider and **cannot be chained!**

Creation of a chainable interface is still to be done and is planned for a future release.

```yml
security:
    firewalls:
        aws4fw:
            pattern: ^/amazon-like-api/
            stateless: true
            aws4auth: true
```

### Step 5: Configure the AWS4AuthBundle

```yml
# app/config/config.yml

pc_aws4_auth:
    user_class: \Acme\Bundle\Entity\User

```