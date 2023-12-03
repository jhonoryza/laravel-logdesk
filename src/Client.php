<?php

namespace Jhonoryza\Logdesk;

class Client
{
    protected static $cache = [];

    /** @var int */
    protected $portNumber;

    /** @var string */
    protected $host;

    /** @var string */
    protected $fingerprint;

    /** @var mixed */
    protected $curlHandle = null;

    public function __construct(int $portNumber = 33555, string $host = 'localhost')
    {
        $this->fingerprint = $host . ':' . $portNumber;

        $this->portNumber = $portNumber;

        $this->host = $host;
    }

    public function __destruct()
    {
        if ($this->curlHandle) {
            curl_close($this->curlHandle);
            $this->curlHandle = null;
        }
    }

    public function serverIsAvailable(): bool
    {
        // purge expired entries from the cache
        static::$cache = array_filter(static::$cache, function ($data) {
            return microtime(true) < $data[1];
        });

        if (! isset(static::$cache[$this->fingerprint])) {
            $this->performAvailabilityCheck();
        }

        return static::$cache[$this->fingerprint][0] ?? true;
    }

    public function performAvailabilityCheck(): bool
    {
        try {
            $curlHandle = $this->getCurlHandleForUrl('get', '_availability_check');

            curl_exec($curlHandle);
            //dd(curl_errno($curlHandle));

            $success = curl_errno($curlHandle) === CURLE_HTTP_NOT_FOUND;

            // expire the cache entry after 30 sec
            $expiresAt = microtime(true) + 30.0;

            static::$cache[$this->fingerprint] = [$success, $expiresAt];
        } finally {
            return $success ?? false;
        }
    }

    public function send(Request $request): void
    {
        if (! $this->serverIsAvailable()) {
            return;
        }

        $curlHandle = $this->getCurlHandleForUrl('post', 'api/echo');

        $curlError = null;

        curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, $request->toJson());
        curl_exec($curlHandle);

        if (curl_errno($curlHandle)) {
            $curlError = curl_error($curlHandle);
        }

        if ($curlError) {
            // do nothing for now
        }
    }

    protected function getCurlHandleForUrl(string $method, string $url)
    {
        return $this->getCurlHandle($method, "http://{$this->host}:{$this->portNumber}/{$url}");
    }

    protected function getCurlHandle(string $method, string $fullUrl)
    {
        if (! $this->curlHandle) {
            $this->curlHandle = curl_init();
        }

        curl_reset($this->curlHandle);
        curl_setopt($this->curlHandle, CURLOPT_URL, $fullUrl);

        curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, array_merge([
            'Accept: application/json',
            'Content-Type: application/json',
        ]));

        curl_setopt($this->curlHandle, CURLOPT_USERAGENT, 'Ray 1.0');
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curlHandle, CURLOPT_TIMEOUT, 2);
        curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($this->curlHandle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($this->curlHandle, CURLOPT_ENCODING, '');
        curl_setopt($this->curlHandle, CURLINFO_HEADER_OUT, true);
        curl_setopt($this->curlHandle, CURLOPT_FAILONERROR, true);

        if ($method === 'post') {
            curl_setopt($this->curlHandle, CURLOPT_POST, true);
        }

        return $this->curlHandle;
    }

}
