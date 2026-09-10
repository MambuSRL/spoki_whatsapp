# Spoki WhatsApp PHP

PHP 8.3+ client for the HTTP operations in the
[Spoki documentation](https://documenter.getpostman.com/view/21611004/UzBqnPvF),
reviewed on September 10, 2026: 123 request examples and 115 distinct endpoints.
Includes message variants, deprecated partner operations still listed in the reference,
and V2 webhook signature verification. A documented endpoint may have been retired;
check the method's deprecation notes before using it.

## Installation

Requires PHP 8.3+ with `curl`, `json` and `ctype`. No external PHP dependencies.
Both Composer PSR-4 and standalone autoloading are supported:

```php
require '/path/to/spoki_whatsapp/autoload.php';

use MambuSRL\Spoki\Spoki;
use MambuSRL\Spoki\SpokiException;

$spoki = new Spoki((string) getenv('SPOKI_API_KEY'));
```

For Composer, configure the appropriate VCS/path repository and require
`mambusrl/spoki-whatsapp`, then load `vendor/autoload.php`.
The package does not need to be published on Packagist.

## Resource Classes

Each callable documentation folder has its own class under `MambuSRL\Spoki\Api`.
Partner subfolders use the nested `MambuSRL\Spoki\Api\Partners` namespace.
`Client` owns authentication and HTTP transport; `ApiResource` shares client access
and URL construction without exposing unrelated API operations on each resource.

Use the classes directly when your application needs only a few resources:

```php
use MambuSRL\Spoki\Client;
use MambuSRL\Spoki\Api\Contacts;
use MambuSRL\Spoki\Api\Messages;

$client = new Client((string) getenv('SPOKI_API_KEY'));
$contacts = new Contacts($client);
$messages = new Messages($client);

$contacts->syncContact(['phone' => '+393331234567', 'first_name' => 'Alex']);
$messages->sendMessageText('+393331234567', 'Your order is ready.');
```

Alternatively, `Spoki` provides typed accessors and caches resource instances:

```php
$spoki = new Spoki((string) getenv('SPOKI_API_KEY'));
$contacts = $spoki->contacts()->listContacts(['page' => 1]);
$spoki->messages()->sendMessageText('+393331234567', 'Hello');
$spoki->automations()->startAutomation($uuid, $secret, '+393331234567');
```

All resources created from the same client share its API key, timeout and transport.
Changing the key with `setApiKey()` also affects existing resource instances.

| Documentation folder | Class | Accessor |
| --- | --- | --- |
| Accounts | [Api\Accounts](src/Api/Accounts.php) | `accounts()` |
| Agencies | [Api\Agencies](src/Api/Agencies.php) | `agencies()` |
| Automations | [Api\Automations](src/Api/Automations.php) | `automations()` |
| Campaigns | [Api\Campaigns](src/Api/Campaigns.php) | `campaigns()` |
| Contacts | [Api\Contacts](src/Api/Contacts.php) | `contacts()` |
| Custom Fields | [Api\CustomFields](src/Api/CustomFields.php) | `customFields()` |
| Embedding via iframe | [Api\Embedding](src/Api/Embedding.php) | `embedding()` |
| Invitations | [Api\Invitations](src/Api/Invitations.php) | `invitations()` |
| Lists | [Api\Lists](src/Api/Lists.php) | `lists()` |
| Messages | [Api\Messages](src/Api/Messages.php) | `messages()` |
| Reports | [Api\Reports](src/Api/Reports.php) | `reports()` |
| Roles | [Api\Roles](src/Api/Roles.php) | `roles()` |
| Tags | [Api\Tags](src/Api/Tags.php) | `tags()` |
| Templates | [Api\Templates](src/Api/Templates.php) | `templates()` |
| Tickets | [Api\Tickets](src/Api/Tickets.php) | `tickets()` |
| Media | [Api\Media](src/Api/Media.php) | `media()` |
| Webhooks / API and signature verification | [Api\Webhooks](src/Api/Webhooks.php) | `webhooks()` |
| Partners / Partners | [Api\Partners](src/Api/Partners.php) | `partners()` |
| Partners / Partners / Deprecated | [Api\Partners\Deprecated](src/Api/Partners/Deprecated.php) | `deprecatedPartners()` |
| Partners / Partner Roles | [Api\Partners\Roles](src/Api/Partners/Roles.php) | `partnerRoles()` |
| Partners / Partner Invitations | [Api\Partners\Invitations](src/Api/Partners/Invitations.php) | `partnerInvitations()` |
| Channels | [Api\Channels](src/Api/Channels.php) | `channels()` |

Folders containing only incoming webhook payload examples, including "Webhook Contact
in automation step", do not define callable endpoints and therefore do not get
empty API classes. Receive and process those events in your application.

## Compatibility

`sendTemplate()` and `sendMessageText()` retain their signatures, parameter order
and JSON **string** return values. New API methods also return strings;
a response without content, such as HTTP 204, returns `''`.

The constructor accepts `($apikey = '', $apiBaseUrl = null, $timeout = 30, $transport = null)`.
The default changes from `https://app.spoki.it` to the official `https://api.spoki.com`.
An alternative HTTPS origin can be configured, without a path, query or credentials.
Existing integrations can continue to include `src/Spoki.php` directly.

Existing flat calls such as `$spoki->listContacts()` are forwarded to their owning
resource through `__call()`, preserving positional and named arguments. They are
listed as `@method` annotations for IDE completion, not physically declared API
methods on the facade. Code using `ReflectionMethod` or `method_exists()` to inspect
individual API operations should inspect the resource class instead. New code
should use the resource accessors or instantiate resource classes directly.

Requests default to a 30-second total timeout and a connection timeout of up to
10 seconds. Redirects are disabled and TLS verification remains enabled.
All HTTP 2xx responses are accepted; invalid JSON raises an exception.
There are no automatic retries, particularly to avoid duplicate message delivery.

## Sending Messages

```php
$messages = $spoki->messages();
$response = $messages->sendMessageText('+393331234567', 'Your order is ready.');
$result = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

$messages->sendTemplate(
	templateId: 123,
	phone: '+393331234567',
	language: 'IT',
	customFields: ['ORDER_ID' => '42'],
	metadata: ['internal_id' => 100]
);

$messages->sendTemplateCarouselMultilanguage([
	'phone' => '+393331234567',
	'template' => 123,
	'header_media_set' => [
		['url' => 'https://example.com/image.jpg', 'filename' => 'image.jpg', 'language' => 'it'],
	],
	'custom_fields' => ['ORDER_ID' => '42'],
]);
```

`sendMessage(array $data)` accepts the complete documented payload,
including optional fields such as `email` and channel-specific settings.
Media, carousel, button and list helpers accept the complete payload and set the
appropriate message type. Spoki requirements for templates, item counts,
permissions and conversation windows still apply.

## Automations

Starting an automation uses `secret` in the body, **without an API key header**.
The UUID and secret belong to the automation's initial "API Url" step;
the UUID is not the numeric automation ID.

```php
$automations = (new Spoki())->automations();
$response = $automations->startAutomation(
	uuid: (string) getenv('SPOKI_AUTOMATION_UUID'),
	secret: (string) getenv('SPOKI_WEBHOOK_SECRET'),
	phone: '+393331234567',
	data: [
		'first_name' => 'Mario',
		'language' => 'it',
		'custom_fields' => ['ORDER_ID' => '42'],
		'metadata' => ['internal_id' => 100],
	]
);

$automations->startAutomationBulk(
	(string) getenv('SPOKI_AUTOMATION_UUID'),
	(string) getenv('SPOKI_WEBHOOK_SECRET'),
	[['phone' => '+393331234567'], ['phone' => '+393331234568']]
);
```

Listing, retrieving and creating automations requires the account API key,
just like the other REST endpoints.

## Payloads And Filters

`list*` methods accept a `$query` array containing documented filters and pagination.
The client returns one page per call; it does not automatically fetch subsequent pages.
Create and update methods accept the complete `$data` body without removing
unknown fields. IDs can be integers or strings and are URL-encoded.

```php
$contactsApi = $spoki->contacts();
$contacts = json_decode($contactsApi->listContacts(['page' => 1, 'search' => 'Mario']), true);
$contactsApi->syncContact(['phone' => '+393331234567', 'first_name' => 'Mario']);
$contactsApi->syncContacts([
	['phone' => '+393331234567', 'first_name' => 'Mario'],
	['phone' => '+393331234568', 'first_name' => 'Anna'],
]);
$contactsApi->updateContact(123, ['first_name' => 'Marco']);
$contactsApi->unblockContact(123);

$result = $spoki->requestJson('GET', '/api/1/contacts/', query: ['page' => 1]);
```

`syncContacts()` uses a JSON array at the request root. Other empty bodies are JSON objects.
`request()` returns the original string; `requestJson()` decodes it and returns
`null` for an empty response. Paths are relative to the origin, for example
`/api/1/contacts/`, rather than absolute URLs.

Every method has English PHPDoc with a description, parameter types, payload or
query fields where documented, return values, exceptions and a usage example.
Field lists distinguish documented examples from explicitly required fields.
Nested schemas vary by message type, automation step, trigger and platform;
follow the linked API reference for those conditional requirements.

## Available Methods

Complete signatures and per-method PHPDoc are preserved in the resource classes
linked above. [src/Spoki.php](src/Spoki.php) contains accessors and legacy delegation,
not the endpoint implementations. [src/Client.php](src/Client.php) owns the shared transport.
The HTTP reference inventory is in [tests/fixtures/endpoints.json](tests/fixtures/endpoints.json).

| Area | Methods |
| --- | --- |
| Account | `listAccounts`, `getAccount`, `getAccountByPhone`, `getAccountCurrentReport`, `createAccountOnboardingLink` |
| Agencies | `listAgencies`, `getAgency` |
| Automations | `startAutomation`, `startAutomationBulk`, `listAutomations`, `getAutomation`, `createAutomation`, `getAutomationCustomFieldsUsed` |
| Campaigns | `listCampaigns`, `createCampaign`, `getCampaign`, `updateCampaign`, `deleteCampaign` |
| Contacts | `listContacts`, `syncContacts`, `syncContact`, `getContact`, `updateContact`, `deleteContact`, `addContactOperator`, `removeContactOperator`, `blockContact`, `unblockContact` |
| Custom fields | `listCustomFields`, `createCustomField`, `getCustomField`, `updateCustomField`, `deleteCustomField` |
| Iframe | `getAuthenticationToken` |
| Invitations | `listInvitations`, `getInvitation`, `createInvitation`, `resendInvitation`, `updateInvitationRole`, `deleteInvitation` |
| Lists | `listLists`, `createList`, `getList`, `syncListContacts`, `removeAllListContacts`, `removeListContacts`, `deleteList` |
| Messages | `sendMessage`, `sendTemplate`, `sendMessageText`, `sendTemplateWithDynamicHeaderMedia`, `sendTemplateCarousel`, `sendTemplateCarouselMultilanguage`, `sendMessageWithButtons`, `sendMessageList` |
| Report | `listReports`, `listDetailedReports` |
| Roles | `listRoles`, `getRole`, `addServiceUser`, `generateRolePrivateKey`, `hasRolePrivateKey`, `updateRole`, `deleteRole` |
| Tag | `listTags`, `getTag` |
| Template | `listTemplates`, `createTemplate`, `cloneTemplate`, `updateTemplate`, `submitTemplate`, `templateBackToDraft`, `getTemplate`, `deleteTemplate` |
| Ticket | `listTickets`, `createTicket`, `getTicket`, `updateTicket`, `deleteTicket` |
| Media | `listMedia`, `createMedia`, `getMedia`, `updateMedia`, `deleteMedia` |
| Webhook | `listWebhooks`, `createWebhook`, `getWebhook`, `updateWebhook`, `deleteWebhook`, `getWebhookExpands`, `setWebhookExpands`, `sendTestWebhook`, `rotateWebhookSecret`, `verifyWebhookSignature` |
| Partner | `listPartners`, `listPartnerAccounts`, `createPartnerOnboardingLink`, `createAccountApiKey`, `revokeAccountApiKey`, `addSoftwareVendorClients`, `createMetaCreditSubrecharge`, `setAccountProfitMargins`, `moveCreditFromAccount`, `getPartnerAccountReport`, `getPartnerAccountForecasts` |
| Deprecated partner operation | `createConversationsSubrecharge` |
| Partner roles | `listPartnerRoles`, `getPartnerRole`, `generatePartnerRolePrivateKey`, `hasPartnerRolePrivateKey`, `updatePartnerRole`, `deletePartnerRole` |
| Partner invitations | `listPartnerInvitations`, `getPartnerInvitation`, `createPartnerInvitation`, `resendPartnerInvitation`, `updatePartnerInvitationRole`, `deletePartnerInvitation` |
| Channels | `listChannels`, `getChannel`, `createChannel`, `renameChannel`, `setPrimaryChannel`, `refreshWhatsAppPhoneStatus`, `getChannelByPhone` |

Undocumented CRUD operations, such as tag creation, are not invented.
`cloneTemplate` uses GET as documented, even though it creates a copy.
`unblockContact` sends PATCH with `is_blocked: false`: the Postman
"Unlock Contact" example also includes `?is_blocked=true`, which contradicts the body
and is intentionally omitted. All `/api/1/` endpoints use the general
`X-Spoki-Api-Key` authentication scheme, even where an example omits the header.

The documentation marks `createAccountOnboardingLink()` as removed and returning
404; use `createChannel(['platform' => 1])` instead. It also announces removal of
`listReports()` on June 10, 2026; prefer `listDetailedReports()`.

## Errors

```php
try {
	$response = $spoki->contacts()->listContacts();
} catch (SpokiException $exception) {
	$httpStatus = $exception->statusCode;
	$responseBody = $exception->responseBody;
	$retryAfter = $exception->responseHeaders['retry-after'] ?? null;
}
```

`SpokiException` extends `RuntimeException` and exposes the HTTP status (`0` for
transport errors), response body and response headers. Exception messages generated
by the client do not include credentials or payloads. Response bodies may contain
personal data: do not log them verbatim without filtering. Invalid input and JSON
serialization failures raise `InvalidArgumentException` and `JsonException`,
respectively. A missing required API key raises `LogicException`.

Rate limits vary by endpoint; handle HTTP 429 and `Retry-After` in the caller.
A timeout does not prove that a message was not sent: do not retry automatically
without checking the outcome.

## Incoming Webhooks

Postman examples with method `VIEW` describe incoming notifications, not callable
APIs. The application server must receive and process them. For V2 webhooks:

```php
$rawBody = file_get_contents('php://input');
$valid = \MambuSRL\Spoki\Api\Webhooks::verifyWebhookSignature(
	$rawBody,
	$_SERVER['HTTP_X_SPOKI_SIGNATURE'] ?? '',
	(string) getenv('SPOKI_WEBHOOK_SIGNING_SECRET')
);
if (!$valid) {
	http_response_code(401);
	return;
}
$event = json_decode($rawBody, true, 512, JSON_THROW_ON_ERROR);
```

The helper verifies HMAC-SHA256 over the original body, uses a constant-time
comparison and allows a 300-second timestamp tolerance. Store processed `event_uuid`
values to prevent duplicates even within that window. Deprecated V1 signatures
are not accepted. The webhook signing secret is different from the automation
trigger secret.

## Tests

```sh
docker exec -i php_local php /var/www/html/spoki_whatsapp/tests/run.php
```

Tests run offline and check endpoint coverage, payloads, authentication, queries,
compatibility, HTTP and cURL failures, timeouts and webhook signatures without sending messages.
Every resource method is compared with its legacy facade call, including the emitted
HTTP request. Tests also cover direct resource construction, shared configuration,
resource caching, named arguments, documentation retention and rejected method names.
They do not validate live account permissions, provider settings or individual templates.

The fourth constructor argument accepts an injected transport for testing:
`callable(string $method, string $url, array $headers, ?string $body, int $timeout): array`.
It must return `['status' => int, 'body' => string, 'headers' => array]`;
response header names, when supplied, must be lowercase.

To update the reference, download the public collection to a local file and run
`node tools/import-reference.mjs collection.json`, then run the tests again.
The reference contains only operation names, methods and paths, not credentials
or a full copy of the provider documentation.
