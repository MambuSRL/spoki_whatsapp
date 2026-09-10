<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Automations documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->automations();
 */
final class Automations extends ApiResource
{

    /**
     * Start an automation for one contact using its API Url trigger UUID and secret.
     *
     * POST /wh/ap/{{uuid}}/
     *
     * Authentication uses the trigger secret in the body, not the account API key.
     * The explicit secret and phone arguments override fields with the same names in data.
     *
     * Payload fields and types (as documented for this operation):
     * first_name: string.
     * last_name: string.
     * email: string.
     * language: string.
     * custom_fields: array<string, string>.
     * metadata: array<string, mixed>.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param string $uuid API Url trigger UUID, not the numeric automation ID.
     * @param string $secret Secret of the same API Url trigger; not the account API key.
     * @param string $phone International phone number as a string, including the + country prefix.
     * @param array<string, mixed> $data Optional contact fields, custom_fields and metadata.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $automations->startAutomation($uuid, $secret, '+393331234567', ['custom_fields' => ['ORDER_ID' => '42']]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function startAutomation(string $uuid, string $secret, string $phone, array $data = []): string
    {
        if ($uuid === '' || $secret === '') {
            throw new \InvalidArgumentException('Automation UUID and secret are required.');
        }
        return $this->client->request('POST', '/wh/ap/' . rawurlencode($uuid) . '/', array_merge($data, ['secret' => $secret, 'phone' => $phone]), [], false);
    }

    /**
     * Start the same automation for multiple contacts using its API Url trigger.
     *
     * POST /wh/ap/{{uuid}}/bulk/
     *
     * Authentication uses the trigger secret in the body, not the account API key.
     * Each contact needs a phone string. Optional fields: first_name, last_name, email,
     * language (string), custom_fields (array<string, string>) and metadata (array<string, mixed>).
     * Outer array keys are discarded so contacts is always encoded as a JSON list.
     *
     * @param string $uuid API Url trigger UUID, not the numeric automation ID.
     * @param string $secret Secret of the same API Url trigger; not the account API key.
     * @param array<array-key, array<string, mixed>> $contacts Contact records with phone and the optional fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $automations->startAutomationBulk($uuid, $secret, [['phone' => '+393331234567']]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function startAutomationBulk(string $uuid, string $secret, array $contacts): string
    {
        if ($uuid === '' || $secret === '') {
            throw new \InvalidArgumentException('Automation UUID and secret are required.');
        }
        return $this->client->request('POST', '/wh/ap/' . rawurlencode($uuid) . '/bulk/', ['secret' => $secret, 'contacts' => array_values($contacts)], [], false);
    }

    /**
     * List automations.
     *
     * GET /api/1/automations/
     *
     * Supported query fields:
     * search: string. You can search by: name, webhook link
     * webhook_platform: string. Api, Active Campaign, Woocommerce, Magento, Prestashop, Shopify, Zapier, Qapla', BrainLead, HubSpot, Klaviyo, Zoho, Sendinblue, WPNotif, Connectif, IFTTT, Pipedrive, Meta, Zendesk
     * is_active: bool. true, false
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $automations->listAutomations();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listAutomations(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/automations/', null, $query);
    }

    /**
     * Retrieve an existing automation.
     *
     * GET /api/1/automations/{{id}}/
     *
     * @param int|string $id Identifier of the automation to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $automations->getAutomation(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getAutomation(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('automations', $id));
    }

    /**
     * Create a new automation using the supplied fields.
     *
     * POST /api/1/automations/
     *
     * name is required. Other root fields are optional.
     * Each steps item requires a string step_type. Other fields depend on that step type.
     * For example Delay accepts delay_seconds (int); TemplateMessage requires template (int).
     * Trigger arrays contain objects whose required fields depend on the trigger type.
     * See the linked Step Types and Trigger Types references for each complete nested schema.
     *
     * Payload fields and types (as documented for this operation):
     * name: string.
     * description: string.
     * category: string.
     * is_active: bool.
     * is_favorite: bool.
     * automation_groups: list<int>.
     * steps: list<array<string, mixed>>.
     * steps[].step_type: string.
     * steps[].position: int.
     * steps[].note: string.
     * steps[].reference: string.
     * steps[].key: string.
     * steps[].delay_seconds: int.
     * steps[].step_set: list<mixed> (items depend on the selected component or trigger).
     * webhook_set: list<mixed> (items depend on the selected component or trigger).
     * onfirstmessagestarter_set: list<mixed> (items depend on the selected component or trigger).
     * fieldconditionstarter_set: list<mixed> (items depend on the selected component or trigger).
     * onopeninghoursstarter_set: list<mixed> (items depend on the selected component or trigger).
     * onclosinghoursstarter_set: list<mixed> (items depend on the selected component or trigger).
     * onholidayhoursstarter_set: list<mixed> (items depend on the selected component or trigger).
     * metaadsconditionstarter_set: list<mixed> (items depend on the selected component or trigger).
     * onticketcreatestarter_set: list<mixed> (items depend on the selected component or trigger).
     * onticketstatuschangestarter_set: list<mixed> (items depend on the selected component or trigger).
     * accountpaymentrequeststarter_set: list<mixed> (items depend on the selected component or trigger).
     * oninboundmessageorderstarter_set: list<mixed> (items depend on the selected component or trigger).
     * oninboundmessageproductstarter_set: list<mixed> (items depend on the selected component or trigger).
     * onmarketingacceptancestatuschangestarter_set: list<mixed> (items depend on the selected component or trigger).
     * googlesheetstrigger_set: list<mixed> (items depend on the selected component or trigger).
     * ondealcreatestarter_set: list<mixed> (items depend on the selected component or trigger).
     * ondealupdatestarter_set: list<mixed> (items depend on the selected component or trigger).
     * ondealcontactupdatedstarter_set: list<mixed> (items depend on the selected component or trigger).
     * ondealstagechangestarter_set: list<mixed> (items depend on the selected component or trigger).
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $automations->createAutomation(['name' => 'Order updates', 'steps' => [['step_type' => 'Delay', 'delay_seconds' => 60]]]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createAutomation(array $data): string
    {
        return $this->client->request('POST', '/api/1/automations/', $data);
    }

    /**
     * Retrieve the contact fields and custom placeholders used by an automation.
     *
     * GET /api/1/automations/{{id}}/custom-fields-used/
     *
     * @param int|string $id Identifier of the automation to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $automations->getAutomationCustomFieldsUsed(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getAutomationCustomFieldsUsed(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('automations', $id, 'custom-fields-used'));
    }
}
