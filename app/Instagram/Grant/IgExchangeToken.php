<?php

namespace League\OAuth2\Client\Grant;

class IgExchangeToken extends AbstractGrant
{

    protected function getName(): string
    {
        return 'ig_exchange_token';
    }

    protected function getRequiredRequestParameters(): array
    {

        return [
            'access_token',
        ];
    }

    public function __toString()
    {
        return $this->getName();
    }
}
