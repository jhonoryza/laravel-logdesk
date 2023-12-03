<?php

namespace Jhonoryza\Logdesk;

class Logdesk
{
    protected static $client;

    public function __construct()
    {
        self::$client = $client ?? self::$client ?? new Client();
    }

    public function die($status = ''): void
    {
        die($status);
    }

    public function send(...$arguments): self
    {
        $payloads = PayloadFactory::createForValues($arguments);

        return $this->sendRequest($payloads);
    }

    public function sendRequest($payloads, array $meta = []): self
    {
        $request = new Request($this->uuid, $payloads, $allMeta);

        self::$client->send($request);

        self::rateLimiter()->hit();

        return $this;
    }
}
