<?php

namespace Jhonoryza\Logdesk;

use Jhonoryza\Logdesk\Concerns\PayloadFactory;

class Logdesk
{
    protected static $client;

    public function __construct()
    {
        self::$client = $client ?? self::$client ?? new Client(host: '192.168.18.228', portNumber: 3000);
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

    public function sendRequest($payloads): self
    {
        $request = new Request($payloads);
//dd($request->toArray());
        self::$client->send($request);

        return $this;
    }
}
