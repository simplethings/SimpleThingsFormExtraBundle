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
$builder->add('recaptcha', 'recaptcha');
// ...
```

``` yaml
# app/config/config.yml
comways_form_extra:
    recaptcha:
        private_key: "your-private-key"
        public_key:  "your-public-key"
```

When doing functional testing it is not possible to use the real Google Recaptcha API therefor there is
a `Comways\FormExtraBundle\FunctionalTest\Recaptcha` which always returns true.

It can be used by overwriting the DependencyInjection parameter in app/config/config_test.yml

``` yaml
parameters:
    comways_form_extra.service.recaptcha.class: Comways\FormExtraBundle\FunctionalTest\AlwaysValidRecaptcha
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

### HtmlEntitiesTransformer

Converts html code into entites. Also extends `htmlentities` function to auto guess the used charset
if `mbstring` extension is availible.

``` php
<?php
// ...
$builder->get('body')->prependNormTransformer(new HtmlEntitiesTransformer(ENT_COMPAT, true));
// ...
```

### StripTagsTransformer

Provides easy tag stripping capabilities for your forms to reduce xss attacks. You note it is not the
best solution.

``` php
<?php
// ...
// This will allow <p> tags.
$builder->get('body')->prependNormTransformer(new StripTagsTransformer('<p>'));
// ...
```
