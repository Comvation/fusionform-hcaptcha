# hCaptcha for Neos.Fusion.Form

Integrates the hCaptcha into any Neos.Fusion.Form.

Inspired by sitegeist/Sitegeist.FusionForm.FriendlyCaptcha.

# Requirements

* Neos
* Composer

## Supported and Tested Versions

Neos from 8.0 up to and including 9.0.x.

## Installation

Add the plugin, and install the dependencies:
```bash
composer require comvation/fusionform-hcaptcha
composer install
```

## Update / Breaking Changes

When you update from v1.1.0 or lower, and you are using a `selector` for
the submit button, you must update your settings to use a `formSelector`
instead.

See [Using a Form Selector](#using-a-form-selector) below.

## Usage

Add the captcha field and validator to your form content and schema,
respectively:
```
prototype(Vendor.Site:RuntimeForm) < prototype(Neos.Fusion.Form:Runtime.RuntimeForm) {
  process {
    content = afx`
      [...your form contents...]
      <!-- field.name value MUST match the schema property below -->
      <Neos.Fusion.Form:FieldContainer field.name="h-captcha-response">
        <Comvation.FusionForm.HCaptcha:HCaptcha />
      </Neos.Fusion.Form:FieldContainer>
    `
    schema {
      [...your schema entries...]
      <!-- This name must be equal to the field.name above -->
      h-captcha-response = ${Form.Schema.string().isRequired()}
      h-captcha-response.@process.captchaValidator = ${value.validator('Comvation.FusionForm.HCaptcha:HCaptcha')}
    }
  }
  action { [no changes required] }
}
```
Add the key and secret, as well as other desired configuration to your
environment specific Settings.yaml.

Note:  Only a few selected configuration options are available in the
settings for now.
```yaml
Comvation:
  FusionForm:
    HCaptcha:
      siteKey: '<your-key>'
      siteSecret: '<your-secret>'
      size: 'invisible' # optional, default is "normal"
      theme: 'dark' # optional, default is "light"
```
See [hCaptcha docs](https://docs.hcaptcha.com/#integration-testing-test-keys)
for details on the available options, as well as test keys.

## Using a Form Selector

By default, the plugin hooks into the first form on the page
using `document.forms[0]`.

If the intended one isn't the first, `formSelector` should be used.
For example:
```
...
<form class="ignore-me">...</form>
...
<form class="i-want-you">...</form>
...
```
To choose the second form, add the matching selector to your settings:
```
Comvation:
  FusionForm:
    HCaptcha:
      formSelector: form.i-want-you
```

Note that the button `selector` setting is no longer supported after v1.1.0.
