<?php

namespace Jhonoryza\Logdesk\Payloads;

class NullPayload extends Payload
{
    /** @var bool */
    protected $bool;

    public function getType(): string
    {
        return 'custom';
    }

    public function getContent(): array
    {
        return [
            'content' => null,
            'label' => 'Null',
        ];
    }
}
