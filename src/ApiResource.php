<?php

namespace MambuSRL\Spoki;

/**
 * Shared client dependency and URL construction for a documentation resource folder.
 */
abstract class ApiResource
{
    /**
     * Bind this resource to a client shared with other resource instances.
     *
     * @param Client $client HTTP client containing authentication, timeout and transport settings.
     * @example $contacts = new Api\Contacts(new Client((string) getenv('SPOKI_API_KEY')));
     */
    public function __construct(protected readonly Client $client)
    {
    }

    /**
     * Build an API resource path and URL-encode the resource identifier.
     *
     * Internal helper: the resource and action are library-defined path fragments.
     *
     * @param string $resource Library-defined resource path, e.g. contacts or channel/phone.
     * @param int|string $id Identifier of the resource to operate on; not empty.
     * @param string $action Optional library-defined action name, without a trailing slash.
     * @return string Encoded resource path with a trailing slash.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $path = $this->resource('contacts', 123, 'add_operator');
     */
    protected function resource(string $resource, int|string $id, string $action = ''): string
    {
        if ((string) $id === '' || in_array((string) $id, ['.', '..'], true)) {
            throw new \InvalidArgumentException('A resource identifier is required.');
        }
        return '/api/1/' . $resource . '/' . rawurlencode((string) $id) . '/' . ($action === '' ? '' : $action . '/');
    }
}
