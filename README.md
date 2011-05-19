ComwaysFormExtraBundle
----------------------

This bundle contains additional functionality for Symfony2's Form Component.

Currently this Bundle provides the following:

* RecaptchaFieldType for using Google's reCAPTCHA service.
* ImageType for showing the previously uploaded image
* FileSet for showing a list of previously uplaoded files
* FieldTypeExtension for allowing setting `attr` when building a Form.

Current this Bundle **does not** provide the following:

* In depth documentation.
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
    comways_form_extra.service.recaptcha.class: Comways\FormExtraBundle\FunctionalTest\Recaptcha
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
$builder->add('newAttachment', 'fileset', array(
    'type' => 'file',
));
```

There are optional parameters 'delete_route' and 'delete_id' which are then used with twigs path
method to generate a route with parameters "id" and "file", to delete the listed file. If the information
passed is not enough you should overwrite the twig template with your own logic to implement
deleting.

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
