# hCaptcha for Neos.Fusion.Form

Setup inspired by sitegeist/Sitegeist.FusionForm.FriendlyCaptcha

## Installation

Add additional VCS repository to your `composer.json`:

```
  "repositories": [
    {
      "type": "path",
      "url": "./DistributionPackages/*"
    },
    {
      "type": "vcs",
      "url": "git@bitbucket.org:comvation/comvation-neos-hcaptcha.git"
    }
  ],
  ...
```

Add the dependency and update your composer dependencies:

    composer require --no-update "comvation/fusionform-hcaptcha"
    composer update

## Usage

Add custom field and validator to your form content and schema respectively:

```
prototype(Vendor.Site:RuntimeForm) < prototype(Neos.Fusion.Form:Runtime.RuntimeForm) {
    process {
        content = afx`
            ... some fields of yours ...
            <Neos.Fusion.Form:FieldContainer field.name="captchaValidatorField">
                <Comvation.FusionForm.HCaptcha:HCaptcha />
            </Neos.Fusion.Form:FieldContainer>
        `

        schema {
            captchaValidatorField = ${Form.Schema.string()}
            captchaValidatorField.@process.captchaValidator = ${value.validator('Comvation.FusionForm.FriendlyCaptcha:FriendlyCaptcha')}
        }
    }

    action { ... }
}
```

Also check your Settings.yaml for hCaptcha in the following format:

```
Comvation:
  FusionForm:
    HCaptcha:
      siteKey: ''
      siteSecret: '' 
```

Check [hCaptcha docs](https://docs.hcaptcha.com/#integration-testing-test-keys) for more infos and test keys. 

## Release process

We use Semantic Versioning.

Simply create a new git tag to release a stable version:

    git tag -a v0.9.0 -m "First dev release v0.9.0"
    git push origin v0.9.0

