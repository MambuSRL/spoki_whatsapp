<?php

namespace MambuSRL\Spoki;
/**
 * Summary of Spoki
 * Spoki API Wrapper
 * https://spoki.it
 * https://documenter.getpostman.com/view/21611004/UzBqnPvF
 */
final class Spoki {

    /**
     * Summary of apikey
     * @var Api Key for Spoki API
     */
    private ?string $apikey = null;
    /**
     * Summary of apiBaseUrl
     * @var Base URL for Spoki API
     */
    private string $apiBaseUrl = "https://app.spoki.it";

    /**
     * Summary of __construct
     * Spoki constructor.
     * @param string $apikey Api Key for
     * @param string|null $apiBaseUrl Base URL for Spoki API
     */
    public function __construct(string $apikey, ?string $apiBaseUrl) {
        $this->setApiKey($apikey);
        if (is_string($apiBaseUrl) && trim($apiBaseUrl) !== "") {
            $this->setApiBaseUrl($apiBaseUrl);
        }
    }

    /**
     * Summary of setApiBaseUrl
     * Set Base URL for Spoki API
     * @param string $apiBaseUrl Base URL for Spoki API
     */
    private function setApiBaseUrl(string $apiBaseUrl): void {
        $this->apiBaseUrl = $apiBaseUrl;
    }

    /**
     * Summary of setApiKey
     * Set API Key for Spoki API
     * @param string $apikey API Key for Spoki API
     */
    public function setApiKey(string $apikey): void {
        $this->apikey = $apikey;
    }

    /**
     * Summary of getApiKey
     * Get API Key for Spoki API
     * @return null|string
     */
    public function getApiKey(): null|string {
        return $this->apikey;
    }

    /**
     * Summary of sendTemplate
     * Send a Template Message
     * Rate Limit: 60/min
     * https://documenter.getpostman.com/view/21611004/UzBqnPvF#22eb28b9-2ae1-435a-9364-0f32cf88b51c:~:text=Send-,Template,-POST
     * @param int $templateId Template ID
     * @param string $phone Destination Phone number
     * @param string $language Language
     * @param array $headerMedia Optional list of Media to include in message (couple of image and video)
     * @param array $customFields Optional list of Custom Fields
     * @param array $buttons Optional list of Button to include in message
     * @param array $metadata Optional list of Metadata
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
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiBaseUrl . '/api/1/messages/send/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'X-Spoki-Api-Key: ' . $this->apikey,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($responseCode !== 200) {
            throw new \Exception("Error sending template message: " . $response);
        }
        curl_close($curl);
        return $response;
    }

    /**
     * Summary of sendMessageText
     * Send a Text Message
     * Rate Limit: 120/min
     * @param string $text Text to send
     * @param string $phone Destination Phone number
     * @param array $metadata Optional list of Metadata
     */
    public function sendMessageText(string $phone, string $text, array $metadata = []): string {
        $data = [
            "type" => "Message",
            "content_type" => "Text",
            "phone" => $phone,
            "text" => $text,
            "metadata" => $metadata
        ];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiBaseUrl . '/api/1/messages/send/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'X-Spoki-Api-Key: ' . $this->apikey,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($responseCode !== 200) {
            throw new \Exception("Error sending template message: " . $response);
        }
        curl_close($curl);
        return $response;
    }
}