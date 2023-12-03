<?php

namespace Jhonoryza\Logdesk\Payloads;

class Payload
{
    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'content' => $this->getContent()
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
