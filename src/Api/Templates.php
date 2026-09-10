<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Templates documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->templates();
 */
final class Templates extends ApiResource
{

    /**
     * List message templates.
     *
     * GET /api/1/templates/
     *
     * Supported query fields:
     * search: string. You can search by: 'id', 'name', 'text'
     * channel_id: int. Filter by an active WhatsApp channel ID.
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $templates->listTemplates(['channel_id' => 17]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listTemplates(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/templates/', null, $query);
    }

    /**
     * Create a new message template using the supplied fields.
     *
     * POST /api/1/templates/
     *
     * Payload fields and types (as documented for this operation):
     * name: string.
     * category: string.
     * subcategory: string.
     * templatelocalization_set: list<array<string, mixed>>.
     * templatelocalization_set[].language: string.
     * templatelocalization_set[].status: int.
     * templatelocalization_set[].header_template_component: array<string, mixed>.
     * templatelocalization_set[].header_template_component.component_type: string.
     * templatelocalization_set[].header_template_component.parameters: list<mixed> (items depend on the selected component or trigger).
     * templatelocalization_set[].header_template_component.format: string.
     * templatelocalization_set[].header_template_component.text: string.
     * templatelocalization_set[].body_template_component: array<string, mixed>.
     * templatelocalization_set[].body_template_component.component_type: string.
     * templatelocalization_set[].body_template_component.parameters: list<mixed> (items depend on the selected component or trigger).
     * templatelocalization_set[].body_template_component.format: mixed|null (the example supplies null; depends on the component).
     * templatelocalization_set[].body_template_component.text: string.
     * templatelocalization_set[].footer_template_component: array<string, mixed>.
     * templatelocalization_set[].footer_template_component.component_type: string.
     * templatelocalization_set[].footer_template_component.parameters: list<mixed> (items depend on the selected component or trigger).
     * templatelocalization_set[].footer_template_component.format: mixed|null (the example supplies null; depends on the component).
     * templatelocalization_set[].footer_template_component.text: string.
     * templatelocalization_set[].templatebuttoncomponent_set: list<array<string, mixed>>.
     * templatelocalization_set[].templatebuttoncomponent_set[].component_type: mixed|null (the example supplies null; depends on the component).
     * templatelocalization_set[].templatebuttoncomponent_set[].text: string.
     * templatelocalization_set[].templatebuttoncomponent_set[].order: int.
     * templatelocalization_set[].templatebuttoncomponent_set[].button_type: string.
     * templatelocalization_set[].templatebuttoncomponent_set[].phone_number: mixed|null (the example supplies null; depends on the component).
     * templatelocalization_set[].templatebuttoncomponent_set[].form_id: mixed|null (the example supplies null; depends on the component).
     * templatelocalization_set[].templatebuttoncomponent_set[].url: string.
     * templatelocalization_set[].templatebuttoncomponent_set[].send_as_shortlink: bool.
     * templatelocalization_set[].example_custom_fields: array<string, string>.
     * templatelocalization_set[].example_header_media: mixed|null (the example supplies null; depends on the component).
     * templatelocalization_set[].default_header_media: mixed|null (the example supplies null; depends on the component).
     * templatelocalization_set[].templatecarouselcomponent_set: mixed|null (the example supplies null; depends on the component).
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $templates->createTemplate(['name' => 'order_update', 'category' => 'UTILITY', 'subcategory' => 'CLASSIC', 'templatelocalization_set' => $localizations]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createTemplate(array $data): string
    {
        return $this->client->request('POST', '/api/1/templates/', $data);
    }

    /**
     * Clone an existing template into an independent draft using the documented GET action.
     *
     * GET /api/1/templates/{{id}}/clone/
     *
     * Although the HTTP verb is GET, this action creates a new draft template.
     * The original template remains unchanged. Do not retry blindly after an uncertain response.
     *
     * No specific query fields are listed in the referenced example; pass [] by default.
     * Additional filters must be supported by the server. This method does not fetch all pages.
     *
     * @param int|string $id Identifier of the message template to operate on; not empty.
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $templates->cloneTemplate(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function cloneTemplate(int|string $id, array $query = []): string
    {
        return $this->client->request('GET', $this->resource('templates', $id, 'clone'), null, $query);
    }

    /**
     * Update an existing message template.
     *
     * PATCH /api/1/templates/{{id}}/
     *
     * Payload fields and types (as documented for this operation):
     * name: string.
     * category: string.
     * subcategory: string.
     * template_groups: list<int>.
     * templatelocalization_set: list<array<string, mixed>>.
     * templatelocalization_set[].id: int.
     * templatelocalization_set[].language: string.
     * templatelocalization_set[].status: int.
     * templatelocalization_set[].header_template_component: array<string, mixed>.
     * templatelocalization_set[].header_template_component.component_type: string.
     * templatelocalization_set[].header_template_component.parameters: list<mixed> (items depend on the selected component or trigger).
     * templatelocalization_set[].header_template_component.format: string.
     * templatelocalization_set[].header_template_component.text: string.
     * templatelocalization_set[].body_template_component: array<string, mixed>.
     * templatelocalization_set[].body_template_component.component_type: string.
     * templatelocalization_set[].body_template_component.parameters: list<mixed> (items depend on the selected component or trigger).
     * templatelocalization_set[].body_template_component.format: mixed|null (the example supplies null; depends on the component).
     * templatelocalization_set[].body_template_component.text: string.
     * templatelocalization_set[].footer_template_component: array<string, mixed>.
     * templatelocalization_set[].footer_template_component.component_type: string.
     * templatelocalization_set[].footer_template_component.parameters: list<mixed> (items depend on the selected component or trigger).
     * templatelocalization_set[].footer_template_component.format: mixed|null (the example supplies null; depends on the component).
     * templatelocalization_set[].footer_template_component.text: string.
     * templatelocalization_set[].templatebuttoncomponent_set: list<array<string, mixed>>.
     * templatelocalization_set[].templatebuttoncomponent_set[].component_type: mixed|null (the example supplies null; depends on the component).
     * templatelocalization_set[].templatebuttoncomponent_set[].text: string.
     * templatelocalization_set[].templatebuttoncomponent_set[].order: int.
     * templatelocalization_set[].templatebuttoncomponent_set[].button_type: string.
     * templatelocalization_set[].templatebuttoncomponent_set[].phone_number: mixed|null (the example supplies null; depends on the component).
     * templatelocalization_set[].templatebuttoncomponent_set[].form_id: mixed|null (the example supplies null; depends on the component).
     * templatelocalization_set[].templatebuttoncomponent_set[].url: string.
     * templatelocalization_set[].templatebuttoncomponent_set[].send_as_shortlink: bool.
     * templatelocalization_set[].example_custom_fields: array<string, string>.
     * templatelocalization_set[].example_header_media: mixed|null (the example supplies null; depends on the component).
     * templatelocalization_set[].default_header_media: mixed|null (the example supplies null; depends on the component).
     * templatelocalization_set[].templatecarouselcomponent_set: list<mixed> (items depend on the selected component or trigger).
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the message template to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $templates->updateTemplate(123, ['name' => 'order_update', 'templatelocalization_set' => $localizations]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function updateTemplate(int|string $id, array $data): string
    {
        return $this->client->request('PATCH', $this->resource('templates', $id), $data);
    }

    /**
     * Submit a template for provider approval.
     *
     * POST /api/1/templates/{{id}}/submit/
     *
     * The documented example defines no body fields. Pass [] unless the API documents
     * additional fields for your operation or account configuration.
     *
     * @param int|string $id Identifier of the message template to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above; defaults to an empty object.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $templates->submitTemplate(123, []);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function submitTemplate(int|string $id, array $data = []): string
    {
        return $this->client->request('POST', $this->resource('templates', $id, 'submit'), $data);
    }

    /**
     * Return a template to draft so that it can be edited and submitted again.
     *
     * POST /api/1/templates/{{id}}/back_to_draft/
     *
     * The documented example defines no body fields. Pass [] unless the API documents
     * additional fields for your operation or account configuration.
     *
     * @param int|string $id Identifier of the message template to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above; defaults to an empty object.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $templates->templateBackToDraft(123, []);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function templateBackToDraft(int|string $id, array $data = []): string
    {
        return $this->client->request('POST', $this->resource('templates', $id, 'back_to_draft'), $data);
    }

    /**
     * Retrieve an existing message template.
     *
     * GET /api/1/templates/{{id}}/
     *
     * This helper accepts only the template ID. To use the documented optional channel_id
     * query, call request('GET', '/api/1/templates/123/', null, ['channel_id' => 17]).
     *
     * @param int|string $id Identifier of the message template to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $templates->getTemplate(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getTemplate(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('templates', $id));
    }

    /**
     * Delete an existing message template.
     *
     * DELETE /api/1/templates/{{id}}/
     *
     * @param int|string $id Identifier of the message template to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $templates->deleteTemplate(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function deleteTemplate(int|string $id): string
    {
        return $this->client->request('DELETE', $this->resource('templates', $id));
    }
}
