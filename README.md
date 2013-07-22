SimpleThingsFormExtraBundle
----------------------

[![Build Status](https://secure.travis-ci.org/simplethings/SimpleThingsFormExtraBundle.png)](http://travis-ci.org/simplethings/SimpleThingsFormExtraBundle)

This bundle contains additional functionality for Symfony2's Form Component.

Currently this Bundle provides the following:

* RecaptchaFieldType for using Google's reCAPTCHA service.
* ImageType for showing the previously uploaded image
* FileSet for showing a list of previously uploaded files
* FieldTypeExtension for allowing setting `attr` when building a Form.

Current this Bundle **does not** provide the following:

* In depth documentation.
* Unicorns or other fairytale creatures.

Contributors
============

Thanks to all who have helped make this bundle awesome. For a list of people who have helped you
should visit this page: https://github.com/SimpleThings/SimpleThingsFormExtraBundle/contributors.

Contributing
============

If **you** want to help create a fork of this repository do some coding and send a Pull Request.

Installing
==========

Fire up a terminal and either clone this repository or add it as a submodule both are shown here
by example.

``` shell
$ git clone git://github.com/simplethings/SimpleThingsFormExtraBundle.git vendor/bundles/SimpleThings/FormExtraBundle
```

``` shell
$ git submodule add git://github.com/simplethings/SimpleThingsFormExtraBundle.git vendor/bundles/SimpleThings/FormExtraBundle
```

for symfony 2.0 use the deps file by adding this in it and running php bin/vendors install

``` ini
[FormExtraBundle]
    git=https://github.com/simplethings/SimpleThingsFormExtraBundle.git
    target=bundles/SimpleThings/FormExtraBundle
    version=v0.1
```

or for symfony 2.1 add this to your composer.json and run composer install

``` json
{
    "require": {
        "simplethings/form-extra-bundle": "1.0.*"
    }
}
```

the enable to the bundle inside your kernel class normally called `AppKernel.php`

``` php
<?php

public function registerBundles()
{
    // ...
    new SimpleThings\FormExtraBundle\SimpleThingsFormExtraBundle(),
    // ...
}
```

Usage
=====

### RecaptchaFieldType

``` php
<?php
// ...
$builder->add('recaptcha', 'formextra_recaptcha');
// ...
```

``` yaml
# app/config/config.yml
simple_things_form_extra:
    recaptcha:
        private_key: "your-private-key"
        public_key:  "your-public-key"
```

When doing functional testing it is not possible to use the real Google Recaptcha API therefor there is
a `SimpleThings\FormExtraBundle\FunctionalTest\Recaptcha` which always returns true.

It can be used by overwriting the DependencyInjection parameter in app/config/config_test.yml

``` yaml
parameters:
    simple_things_form_extra.service.recaptcha.class: SimpleThings\FormExtraBundle\FunctionalTest\Recaptcha
```

The `formextra_recaptcha` form type takes a `widget_options` setting which is encoded as json and set to the configuration
javascript variable Recaptcha needs. This allows you to change the theme for the widget or roll your own. For more information
about what is possible check here http://code.google.com/apis/recaptcha/docs/customization.html.

``` php
<?php
// ...
$builder->add('recaptcha', 'formextra_recaptcha', array(
    'widget_options' => array(
        'theme' => 'white', // blackglass, clean, red is the predefined themes.
    ),
));
// ...
```

## PlainType

Sometimes it is needed to show the value of a field without having it be an input box. This is where
PlainType comes in handy. It will render a simple p tags with the fields value and also prevent that
field from being bound if the form is tampered with.

``` php
<?php
// ...
$builder->add('username', 'formextra_plain');
// ...
```

## FileSetType

`FileSetType` allows you to incrementally add more files to a collection of files by extending
the `FileType`. It renders an unordered list of all the previously uploaded base filenames.

Instead of returning the previously added file you return an array of all file names
from the fields getter method and in the setter method you append the newly uploaded file to the collection:

``` php
<?php
class Document
{
    // temporary field, used in the form, to move new attachments to persistence
    private $newAttachment;
    // persistent array with all attachments.
    private $attachments;

    public function getNewAttachment()
    {
        $files = array();
        foreach ($this->attachments AS $attachment) {
            $files[] = $attachment->getFilename();
        }
        return $files;
    }

    public function setNewAttachment(File $newAttachment = null)
    {
        $this->newAttachment = $newAttachment;
    }

    public function moveNewAttachment()
    {
        // code to move file and include in the attachments field.
    }
}
```

Using the builder to create a field for this type would then look like:

``` php
<?php
$builder->add('newAttachment', 'formextra_fileset', array(
    'type' => 'file',
));
```

There are optional parameters 'delete_route' and 'delete_id' which are then used with twigs path
method to generate a route with parameters "id" and "file", to delete the listed file. If the information
passed is not enough you should overwrite the twig template with your own logic to implement
deleting.

### TranslationDomainExtension

This field extension provides the forward compatibility for the support of translation domains
added in Symfony 2.1. So activating it is useful only when using Symfony 2.0 (activating it in
Symfony 2.1 will add useless overhead)

To use it, you need to activate it and to register the form theme using the translation domain.

``` yaml
# app/config/config.yml
simple_things_form_extra:
    translation_domain_forward_compat: true

twig:
    form:
        resources:
            - SimpleThingsFormExtraBundle:Form:translation_domain.html.twig
            # eventually other themes here
```

You can now provide the translation domain used for labels and choice options when building the form:

``` php
<?php
// ...
$builder->add('body', 'textarea', array(
    'label' => 'some message',
    'translation_domain' => 'form_extra',
));
// ...
```

### HelpExtension

This field extension provides help message option.

To use it, you need to activate it and to register the form theme using the translation domain.

``` yaml
# app/config/config.yml
simple_things_form_extra:
    help_extension: true

twig:
    form:
        resources:
            - SimpleThingsFormExtraBundle:Form:field_type_help.html.twig
```

You can also load the help extension form theme into your own form theme.

```
{% use 'SimpleThingsFormExtraBundle:Form:field_type_help.html.twig' %}
```

You can now provide the help message for field when building the form:

``` php
<?php
// ...
$builder->add('body', 'textarea', array(
    'label' => 'some message',
    'help'  => 'some usefull help message'
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
