<?php

namespace Jhonoryza\Logdesk;

use Jhonoryza\Logdesk\Payloads\Payload;

class Request
{
    protected $payloads;

    public function __construct(array $payloads)
    {
        $this->payloads = $payloads;
    }

    public function toArray(): array
    {
        $payloads = array_map(function (Payload $payload) {
            return $payload->toArray();
        }, $this->payloads);

        return [
            'payloads' => $payloads,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
