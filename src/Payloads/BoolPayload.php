<?php

namespace Jhonoryza\Logdesk\Payloads;

class BoolPayload extends Payload
{
    /** @var bool */
    protected $bool;

    public function __construct(bool $bool)
    {
        $this->bool = $bool;
    }

    public function getType(): string
    {
        return 'custom';
    }

    public function getContent(): array
    {
        return [
            'values' => $this->bool,
            'label' => 'Boolean',
        ];
    }
}
