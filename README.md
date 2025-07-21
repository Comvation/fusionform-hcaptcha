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
Settings.yaml.

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

## Using a Custom Button

By default, the plugin presumes that the form uses a standard form
submit button.

If that isn't the case, specify a selector attribute that exclusively
matches your button.

For example, this one
```
footer = afx`
  <button class="my-submit">Send</button>
`
```
may be used by adding the selector attribute
```
<Comvation.FusionForm.HCaptcha:HCaptcha
  selector={'button[class=my-submit]'}
/>
```
