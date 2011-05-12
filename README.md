ComwaysFormExtraBundle
----------------------

This bundle contains additional functionality for Symfony2's Form Component.

Currently this Bundle provides the following:

* RecaptchaFieldType for using Google's reCAPTCHA service.
* FieldTypeExtension for allowing setting `attr` when building a Form.

Current this Bundle **does not** provide the following:

* In depth documentation.
* Tests
* Unicorns or other fairytale creatures.

Contributors
============

Thanks to all who have helped make this bundle awesome. For a list of people who have helped you
should visit this page: https://github.com/Comways/ComwaysFormExtraBundle/contributors.

Contributing
============

If **you** want to help create a fork of this repository do some coding and send a Pull Request.

Installing
==========

Fire up a terminal and either clone this repository or add it as a submodule both are shown here
by example.

``` shell
$ git clone git://github.com/Comways/ComwaysFormExtraBundle.git vendor/bundles/Comways/FormExtraBundle
```

``` shell
$ git submodule add git://github.com/Comways/ComwaysFormExtraBundle.git vendor/bundles/Comways/FormExtraBundle
```

the enable to the bundle inside your kernel class normally called `AppKernel.php`

``` php
<?php

public function registerBundles()
{
    // ...
    new Comways\FormExtraBundle\ComwaysFormExtraBundle(),
    // ...
}
```

Usage
=====

### RecaptchaFieldType

``` php
<?php
// ...
$builder->add('recaptcha', 'recaptcha', array(
    'private_key' => 'private_key_here_required',
    'public_key' => 'public_key_here_required',
));
// ...
```

### FieldTypeExtension

A Field Extension contains method called by FormBuilder or createView. Theese applies to all fields
specified in the dic tag alias.

This example will preset the class attribute on the rendered textarea html element.

``` php
<?php
// ...
$builder->add('body', 'textarea', array(
    'attr' => array(
        'class' => 'niceditor',
    )
));
// ...
```
