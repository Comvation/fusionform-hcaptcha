<?php declare(strict_types=1);

namespace Comvation\FusionForm\HCaptcha\Validation\Validator;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;

class HCaptchaValidator extends AbstractValidator
{
    /**
     * @Flow\InjectConfiguration(path="siteSecret")
     */
    protected string $siteSecret;

    protected $supportedOptions = [
        'siteSecret' => [null, 'siteSecret', 'string', false]
    ];

    protected function isValid($captcha): void
    {
        $siteSecret = $this->options['siteSecret'] ?: $this->siteSecret;
        $captchaResponse = $captcha ?? false;
        $data = array(
            'secret' => $siteSecret,
            'response' => $captchaResponse
        );
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        $responseData = json_decode($response);
        if($responseData->success) {
            return;
        } else {
            $this->addError('Captcha is invalid.', 20230123115302);
        }
        $this->addError('Der Request konnte nicht gelesen werden.', 1649869170);
    }
}
