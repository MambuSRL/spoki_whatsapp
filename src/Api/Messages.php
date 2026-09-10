<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Messages documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->messages();
 */
final class Messages extends ApiResource
{

    /**
     * Send a template message using the backwards-compatible positional arguments.
     *
     * POST /api/1/messages/send/
     *
     * custom_fields maps field codes to replacement values; header_media is one object, not a media list.
     * The legacy default arrays and the language default IT are retained for compatibility.
     *
     * @param int $templateId Numeric ID of the message template in your Spoki account.
     * @param string $phone International phone number as a string, including the + country prefix.
     * @param string $language Template language code; legacy default IT.
     * @param array{url?: string, filename?: string} $headerMedia Optional single header media object; [] keeps the legacy empty value.
     * @param array<string, string> $customFields Dynamic field codes mapped to their replacement values.
     * @param list<array{order: int, payload?: string}> $buttons Optional template button payloads indexed by button order.
     * @param array<string, mixed> $metadata Application metadata forwarded with the message.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $messages->sendTemplate(123, '+393331234567', 'IT', [], ['ORDER_ID' => '42']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function sendTemplate(int $templateId, string $phone, string $language = "IT", array $headerMedia = [], array $customFields = [], array $buttons = [], array $metadata = []): string {
        $data = [
            "type" => "Template",
            "phone" => $phone,
            "header_media" => $headerMedia,
            "template" => $templateId,
            "language" => $language,
            "custom_fields" => $customFields,
            "buttons" => $buttons,
            "metadata" => $metadata
        ];
        return $this->sendMessage($data);
    }

    /**
     * Send a free-form text message to an international phone number.
     *
     * POST /api/1/messages/send/
     *
     * @param string $phone International phone number as a string, including the + country prefix.
     * @param string $text Message text; delivery remains subject to the provider conversation-window rules.
     * @param array<string, mixed> $metadata Application metadata forwarded with the message.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $messages->sendMessageText('+393331234567', 'Your order is ready.', ['order_id' => 42]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function sendMessageText(string $phone, string $text, array $metadata = []): string {
        $data = [
            "type" => "Message",
            "content_type" => "Text",
            "phone" => $phone,
            "text" => $text,
            "metadata" => $metadata
        ];
        return $this->sendMessage($data);
    }

    /**
     * Send any documented message payload, including optional channel and template settings.
     *
     * POST /api/1/messages/send/
     *
     * Provide the complete documented payload. type selects Template or Message.
     * For free-form messages, content_type selects Text, Interactive or List.
     * The required nested fields depend on the selected message type.
     *
     * Payload fields and types (as documented for this operation):
     * type: string.
     * phone: string.
     * template: int.
     * email: string.
     * language: string.
     * custom_fields: array<string, string>.
     * buttons: list<array<string, mixed>>.
     * buttons[].order: int.
     * buttons[].payload: string.
     * metadata: array<string, mixed>.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $messages->sendMessage(['type' => 'Message', 'content_type' => 'Text', 'phone' => '+393331234567', 'text' => 'Hello']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function sendMessage(array $data): string
    {
        return $this->client->request('POST', '/api/1/messages/send/', $data);
    }

    /**
     * Send a template with a dynamic header image, video or document.
     *
     * POST /api/1/messages/send/
     *
     * Requires phone, template and header_media for this variant; type is set to Template.
     * header_media contains url and filename strings. Use a provider-supported HTTPS media URL.
     *
     * Payload fields and types (as documented for this operation):
     * type: string.
     * phone: string.
     * template: int.
     * email: string.
     * header_media: array<string, mixed>.
     * header_media.url: string.
     * header_media.filename: string.
     * custom_fields: array<string, string>.
     * metadata: array<string, mixed>.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $messages->sendTemplateWithDynamicHeaderMedia(['phone' => '+393331234567', 'template' => 123, 'header_media' => ['url' => 'https://example.com/image.jpg', 'filename' => 'image.jpg']]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function sendTemplateWithDynamicHeaderMedia(array $data): string
    {
        return $this->sendMessage(array_merge($data, ['type' => 'Template']));
    }

    /**
     * Send a carousel template with a dynamic header media list.
     *
     * POST /api/1/messages/send/
     *
     * Requires phone, template and header_media_set for this variant; type is set to Template.
     * header_media_set is a list of media objects ordered to match the carousel cards.
     *
     * Payload fields and types (as documented for this operation):
     * type: string.
     * phone: string.
     * template: int.
     * email: string.
     * header_media_set: list<array<string, mixed>>.
     * header_media_set[].url: string.
     * header_media_set[].filename: string.
     * custom_fields: array<string, string>.
     * metadata: array<string, mixed>.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $messages->sendTemplateCarousel(['phone' => '+393331234567', 'template' => 123, 'header_media_set' => $cardMedia]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function sendTemplateCarousel(array $data): string
    {
        return $this->sendMessage(array_merge($data, ['type' => 'Template']));
    }

    /**
     * Send a carousel template with language-specific dynamic header media.
     *
     * POST /api/1/messages/send/
     *
     * Requires phone, template and header_media_set; type is set to Template.
     * Media entries may include language (string, e.g. en or it) for a localized card set.
     *
     * Payload fields and types (as documented for this operation):
     * type: string.
     * phone: string.
     * template: int.
     * email: string.
     * header_media_set: list<array<string, mixed>>.
     * header_media_set[].url: string.
     * header_media_set[].filename: string.
     * custom_fields: array<string, string>.
     * metadata: array<string, mixed>.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $messages->sendTemplateCarouselMultilanguage(['phone' => '+393331234567', 'template' => 123, 'header_media_set' => $localizedCardMedia]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function sendTemplateCarouselMultilanguage(array $data): string
    {
        return $this->sendTemplateCarousel($data);
    }

    /**
     * Send an interactive message with a header, footer and reply buttons.
     *
     * POST /api/1/messages/send/
     *
     * type is set to Message and content_type to Interactive.
     * Provide phone, text and the buttons list; header, footer and metadata are optional.
     *
     * Payload fields and types (as documented for this operation):
     * type: string.
     * content_type: string.
     * phone: string.
     * text: string.
     * header: array<string, mixed>.
     * header.format: string.
     * header.text: string.
     * footer: array<string, mixed>.
     * footer.text: string.
     * buttons: list<array<string, mixed>>.
     * buttons[].button_type: string.
     * buttons[].text: string.
     * buttons[].order: int.
     * buttons[].payload: string.
     * metadata: array<string, mixed>.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $messages->sendMessageWithButtons(['phone' => '+393331234567', 'text' => 'Confirm?', 'buttons' => [['button_type' => 'quick_reply', 'text' => 'Yes', 'order' => 0, 'payload' => 'confirm']]]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function sendMessageWithButtons(array $data): string
    {
        return $this->sendMessage(array_merge($data, ['type' => 'Message', 'content_type' => 'Interactive']));
    }

    /**
     * Send an interactive list message with sections and selectable rows.
     *
     * POST /api/1/messages/send/
     *
     * type is set to Message and content_type to List.
     * Provide phone, text and list with title and sections; header, footer and metadata are optional.
     *
     * Payload fields and types (as documented for this operation):
     * type: string.
     * content_type: string.
     * phone: string.
     * text: string.
     * header: array<string, mixed>.
     * header.format: string.
     * header.text: string.
     * footer: array<string, mixed>.
     * footer.text: string.
     * list: array<string, mixed>.
     * list.title: string.
     * list.sections: list<array<string, mixed>>.
     * list.sections[].title: string.
     * list.sections[].rows: list<array<string, mixed>>.
     * list.sections[].rows[].title: string.
     * list.sections[].rows[].description: string.
     * list.sections[].rows[].payload: string.
     * metadata: array<string, mixed>.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $messages->sendMessageList(['phone' => '+393331234567', 'text' => 'Choose an option', 'list' => $list]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function sendMessageList(array $data): string
    {
        return $this->sendMessage(array_merge($data, ['type' => 'Message', 'content_type' => 'List']));
    }
}
