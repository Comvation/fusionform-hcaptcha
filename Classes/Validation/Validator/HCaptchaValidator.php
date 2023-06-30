<?php
declare(strict_types=1);

namespace Comvation\FusionForm\HCaptcha\Validation\Validator;

use GuzzleHttp\Psr7\ServerRequest;
use GuzzleHttp\Psr7\Uri;
use Neos\Flow\Core\Bootstrap;
use Neos\Flow\Http\Client\CurlEngine;
use Neos\Flow\Http\HttpRequestHandlerInterface;
use Neos\Flow\Annotations AS Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;

class HCaptchaValidator extends AbstractValidator
{

    protected function isValid($captcha): void
    {
        $siteSecret = $this->options['siteSecret'] ?: $this->siteSecret;
        $captchaResponse = $captcha ?? false;
        if ($captchaResponse) {
            /** @phpstan-ignore-next-line */
            $client = new CurlEngine();
            $client->setOption(CURLOPT_RETURNTRANSFER, true );
            $response = $client->sendRequest(
                new ServerRequest(
                    'POST',
                    new Uri('https://hcaptcha.com/siteverify'),
                    [
                        'Content-Type' => 'application/json',
                    ],
                    json_encode([
                        'secret' => $siteSecret,
                        'response' => $captchaResponse
                    ])
                )
            );
            if (!json_decode($response->getBody()->getContents() ?: '')->success) {
                $this->addError('Captcha is invalid.', 20230123115302);
            }
            return;
        }
        $this->addError('Der Request konnte nicht gelesen werden.', 1649869170);
    }

}
