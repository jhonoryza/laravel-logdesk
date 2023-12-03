<?php

namespace Jhonoryza\Logdesk\Concerns;

use Carbon\CarbonInterface;
use Jhonoryza\Logdesk\Payloads\BoolPayload;
use Jhonoryza\Logdesk\Payloads\CarbonPayload;
use Jhonoryza\Logdesk\Payloads\LogPayload;
use Jhonoryza\Logdesk\Payloads\NullPayload;
use Jhonoryza\Logdesk\Payloads\Payload;

class PayloadFactory
{
    /** @var array */
    protected $values;

    public static function createForValues(array $arguments): array
    {
        return (new static($arguments))->getPayloads();
    }

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function getPayloads(): array
    {
        return array_map(function ($value) {
            return $this->getPayload($value);
        }, $this->values);
    }

    protected function getPayload($value): Payload
    {
        if (is_bool($value)) {
            return new BoolPayload($value);
        }

        if (is_null($value)) {
            return new NullPayload();
        }

        if ($value instanceof CarbonInterface) {
            return new CarbonPayload($value);
        }

        $primitiveValue = ArgumentConverter::convertToPrimitive($value);

        return new LogPayload($primitiveValue);
    }
}
