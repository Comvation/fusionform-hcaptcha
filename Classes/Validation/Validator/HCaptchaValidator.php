<?php declare(strict_types=1);

namespace Comvation\FusionForm\HCaptcha\Validation\Validator;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;

class HCaptchaValidator extends AbstractValidator
{
    #[Flow\InjectConfiguration(path: "siteSecret")]
    protected string $siteSecret;

    protected $supportedOptions = [
        'siteSecret' => [null, 'siteSecret', 'string', false]
    ];

    protected function isValid($captchaResponse): void
    {
        $siteSecret = $this->options['siteSecret'] ?: $this->siteSecret;
        // The required field is marked as an error anyway
        if (!$captchaResponse) {
            return;
        }
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query([
            'secret' => $siteSecret,
            'response' => $captchaResponse,
        ]));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        // May return false
        $response = curl_exec($verify);
        if (!$response) {
            $this->addError('Failed to verify the captcha response.', 0);
            return;
        }
        $responseData = json_decode($response);
        if ($responseData?->success) {
            return;
        }
        $this->addError('The captcha is invalid.', 0);
    }
}
