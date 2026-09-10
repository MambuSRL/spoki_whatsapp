<?php

namespace MambuSRL\Spoki;

require_once __DIR__ . '/../autoload.php';

/**
 * Resource accessors and a compatibility adapter for the original flat client API.
 *
 * New integrations should call the resource classes returned by the accessors.
 *
 * @method string listAccounts(array $query = []) Delegates to Api\Accounts::listAccounts().
 * @method string getAccount(string|int $id) Delegates to Api\Accounts::getAccount().
 * @method string getAccountByPhone(string $phone) Delegates to Api\Accounts::getAccountByPhone().
 * @method string getAccountCurrentReport(string|int $id, array $query = []) Delegates to Api\Accounts::getAccountCurrentReport().
 * @method string createAccountOnboardingLink(string|int $id, array $data = []) Delegates to Api\Accounts::createAccountOnboardingLink().
 * @method string listAgencies(array $query = []) Delegates to Api\Agencies::listAgencies().
 * @method string getAgency(string|int $id) Delegates to Api\Agencies::getAgency().
 * @method string startAutomation(string $uuid, string $secret, string $phone, array $data = []) Delegates to Api\Automations::startAutomation().
 * @method string startAutomationBulk(string $uuid, string $secret, array $contacts) Delegates to Api\Automations::startAutomationBulk().
 * @method string listAutomations(array $query = []) Delegates to Api\Automations::listAutomations().
 * @method string getAutomation(string|int $id) Delegates to Api\Automations::getAutomation().
 * @method string createAutomation(array $data) Delegates to Api\Automations::createAutomation().
 * @method string getAutomationCustomFieldsUsed(string|int $id) Delegates to Api\Automations::getAutomationCustomFieldsUsed().
 * @method string listCampaigns(array $query = []) Delegates to Api\Campaigns::listCampaigns().
 * @method string createCampaign(array $data) Delegates to Api\Campaigns::createCampaign().
 * @method string getCampaign(string|int $id) Delegates to Api\Campaigns::getCampaign().
 * @method string updateCampaign(string|int $id, array $data) Delegates to Api\Campaigns::updateCampaign().
 * @method string deleteCampaign(string|int $id) Delegates to Api\Campaigns::deleteCampaign().
 * @method string listContacts(array $query = []) Delegates to Api\Contacts::listContacts().
 * @method string syncContacts(array $data) Delegates to Api\Contacts::syncContacts().
 * @method string addContactOperator(string|int $id, array $data) Delegates to Api\Contacts::addContactOperator().
 * @method string removeContactOperator(string|int $id, array $data) Delegates to Api\Contacts::removeContactOperator().
 * @method string syncContact(array $data) Delegates to Api\Contacts::syncContact().
 * @method string getContact(string|int $id) Delegates to Api\Contacts::getContact().
 * @method string updateContact(string|int $id, array $data) Delegates to Api\Contacts::updateContact().
 * @method string deleteContact(string|int $id) Delegates to Api\Contacts::deleteContact().
 * @method string blockContact(string|int $id) Delegates to Api\Contacts::blockContact().
 * @method string unblockContact(string|int $id) Delegates to Api\Contacts::unblockContact().
 * @method string listCustomFields(array $query = []) Delegates to Api\CustomFields::listCustomFields().
 * @method string createCustomField(array $data) Delegates to Api\CustomFields::createCustomField().
 * @method string getCustomField(string|int $id) Delegates to Api\CustomFields::getCustomField().
 * @method string updateCustomField(string|int $id, array $data) Delegates to Api\CustomFields::updateCustomField().
 * @method string deleteCustomField(string|int $id) Delegates to Api\CustomFields::deleteCustomField().
 * @method string getAuthenticationToken(array $data) Delegates to Api\Embedding::getAuthenticationToken().
 * @method string listInvitations(array $query = []) Delegates to Api\Invitations::listInvitations().
 * @method string getInvitation(string|int $id) Delegates to Api\Invitations::getInvitation().
 * @method string createInvitation(array $data) Delegates to Api\Invitations::createInvitation().
 * @method string resendInvitation(string|int $id, array $data = []) Delegates to Api\Invitations::resendInvitation().
 * @method string updateInvitationRole(string|int $id, array $data) Delegates to Api\Invitations::updateInvitationRole().
 * @method string deleteInvitation(string|int $id) Delegates to Api\Invitations::deleteInvitation().
 * @method string listLists(array $query = []) Delegates to Api\Lists::listLists().
 * @method string createList(array $data) Delegates to Api\Lists::createList().
 * @method string getList(string|int $id) Delegates to Api\Lists::getList().
 * @method string syncListContacts(string|int $id, array $data) Delegates to Api\Lists::syncListContacts().
 * @method string removeAllListContacts(string|int $id) Delegates to Api\Lists::removeAllListContacts().
 * @method string removeListContacts(string|int $id, array $data) Delegates to Api\Lists::removeListContacts().
 * @method string deleteList(string|int $id) Delegates to Api\Lists::deleteList().
 * @method string sendTemplate(int $templateId, string $phone, string $language = 'IT', array $headerMedia = [], array $customFields = [], array $buttons = [], array $metadata = []) Delegates to Api\Messages::sendTemplate().
 * @method string sendMessageText(string $phone, string $text, array $metadata = []) Delegates to Api\Messages::sendMessageText().
 * @method string sendMessage(array $data) Delegates to Api\Messages::sendMessage().
 * @method string sendTemplateWithDynamicHeaderMedia(array $data) Delegates to Api\Messages::sendTemplateWithDynamicHeaderMedia().
 * @method string sendTemplateCarousel(array $data) Delegates to Api\Messages::sendTemplateCarousel().
 * @method string sendTemplateCarouselMultilanguage(array $data) Delegates to Api\Messages::sendTemplateCarouselMultilanguage().
 * @method string sendMessageWithButtons(array $data) Delegates to Api\Messages::sendMessageWithButtons().
 * @method string sendMessageList(array $data) Delegates to Api\Messages::sendMessageList().
 * @method string listReports(array $query = []) Delegates to Api\Reports::listReports().
 * @method string listDetailedReports(array $query = []) Delegates to Api\Reports::listDetailedReports().
 * @method string listRoles(array $query = []) Delegates to Api\Roles::listRoles().
 * @method string getRole(string|int $id) Delegates to Api\Roles::getRole().
 * @method string addServiceUser(array $data) Delegates to Api\Roles::addServiceUser().
 * @method string generateRolePrivateKey(string|int $id, array $data = []) Delegates to Api\Roles::generateRolePrivateKey().
 * @method string hasRolePrivateKey(string|int $id) Delegates to Api\Roles::hasRolePrivateKey().
 * @method string updateRole(string|int $id, array $data) Delegates to Api\Roles::updateRole().
 * @method string deleteRole(string|int $id) Delegates to Api\Roles::deleteRole().
 * @method string listTags(array $query = []) Delegates to Api\Tags::listTags().
 * @method string getTag(string|int $id) Delegates to Api\Tags::getTag().
 * @method string listTemplates(array $query = []) Delegates to Api\Templates::listTemplates().
 * @method string createTemplate(array $data) Delegates to Api\Templates::createTemplate().
 * @method string cloneTemplate(string|int $id, array $query = []) Delegates to Api\Templates::cloneTemplate().
 * @method string updateTemplate(string|int $id, array $data) Delegates to Api\Templates::updateTemplate().
 * @method string submitTemplate(string|int $id, array $data = []) Delegates to Api\Templates::submitTemplate().
 * @method string templateBackToDraft(string|int $id, array $data = []) Delegates to Api\Templates::templateBackToDraft().
 * @method string getTemplate(string|int $id) Delegates to Api\Templates::getTemplate().
 * @method string deleteTemplate(string|int $id) Delegates to Api\Templates::deleteTemplate().
 * @method string listTickets(array $query = []) Delegates to Api\Tickets::listTickets().
 * @method string createTicket(array $data) Delegates to Api\Tickets::createTicket().
 * @method string getTicket(string|int $id) Delegates to Api\Tickets::getTicket().
 * @method string updateTicket(string|int $id, array $data) Delegates to Api\Tickets::updateTicket().
 * @method string deleteTicket(string|int $id) Delegates to Api\Tickets::deleteTicket().
 * @method string listMedia(array $query = []) Delegates to Api\Media::listMedia().
 * @method string createMedia(array $data) Delegates to Api\Media::createMedia().
 * @method string getMedia(string|int $id) Delegates to Api\Media::getMedia().
 * @method string updateMedia(string|int $id, array $data) Delegates to Api\Media::updateMedia().
 * @method string deleteMedia(string|int $id) Delegates to Api\Media::deleteMedia().
 * @method string listWebhooks(array $query = []) Delegates to Api\Webhooks::listWebhooks().
 * @method string createWebhook(array $data) Delegates to Api\Webhooks::createWebhook().
 * @method string getWebhook(string|int $id) Delegates to Api\Webhooks::getWebhook().
 * @method string updateWebhook(string|int $id, array $data) Delegates to Api\Webhooks::updateWebhook().
 * @method string deleteWebhook(string|int $id) Delegates to Api\Webhooks::deleteWebhook().
 * @method string getWebhookExpands(string|int $id) Delegates to Api\Webhooks::getWebhookExpands().
 * @method string setWebhookExpands(string|int $id, array $data) Delegates to Api\Webhooks::setWebhookExpands().
 * @method string sendTestWebhook(string|int $id, array $data = []) Delegates to Api\Webhooks::sendTestWebhook().
 * @method string rotateWebhookSecret(string|int $id) Delegates to Api\Webhooks::rotateWebhookSecret().
 * @method string listPartners(array $query = []) Delegates to Api\Partners::listPartners().
 * @method string listPartnerAccounts(array $query = []) Delegates to Api\Partners::listPartnerAccounts().
 * @method string createPartnerOnboardingLink(array $data) Delegates to Api\Partners::createPartnerOnboardingLink().
 * @method string createAccountApiKey(array $data) Delegates to Api\Partners::createAccountApiKey().
 * @method string revokeAccountApiKey(array $data) Delegates to Api\Partners::revokeAccountApiKey().
 * @method string addSoftwareVendorClients(array $data) Delegates to Api\Partners::addSoftwareVendorClients().
 * @method string createMetaCreditSubrecharge(array $data) Delegates to Api\Partners::createMetaCreditSubrecharge().
 * @method string setAccountProfitMargins(array $data) Delegates to Api\Partners::setAccountProfitMargins().
 * @method string moveCreditFromAccount(array $data) Delegates to Api\Partners::moveCreditFromAccount().
 * @method string getPartnerAccountReport(array $query) Delegates to Api\Partners::getPartnerAccountReport().
 * @method string getPartnerAccountForecasts(array $query) Delegates to Api\Partners::getPartnerAccountForecasts().
 * @method string createConversationsSubrecharge(array $data) Delegates to Api\Partners\Deprecated::createConversationsSubrecharge().
 * @method string listPartnerRoles(array $query = []) Delegates to Api\Partners\Roles::listPartnerRoles().
 * @method string getPartnerRole(string|int $id) Delegates to Api\Partners\Roles::getPartnerRole().
 * @method string generatePartnerRolePrivateKey(string|int $id, array $data = []) Delegates to Api\Partners\Roles::generatePartnerRolePrivateKey().
 * @method string hasPartnerRolePrivateKey(string|int $id) Delegates to Api\Partners\Roles::hasPartnerRolePrivateKey().
 * @method string updatePartnerRole(string|int $id, array $data) Delegates to Api\Partners\Roles::updatePartnerRole().
 * @method string deletePartnerRole(string|int $id) Delegates to Api\Partners\Roles::deletePartnerRole().
 * @method string listPartnerInvitations(array $query = []) Delegates to Api\Partners\Invitations::listPartnerInvitations().
 * @method string getPartnerInvitation(string|int $id) Delegates to Api\Partners\Invitations::getPartnerInvitation().
 * @method string createPartnerInvitation(array $data) Delegates to Api\Partners\Invitations::createPartnerInvitation().
 * @method string resendPartnerInvitation(string|int $id, array $data = []) Delegates to Api\Partners\Invitations::resendPartnerInvitation().
 * @method string updatePartnerInvitationRole(string|int $id, array $data) Delegates to Api\Partners\Invitations::updatePartnerInvitationRole().
 * @method string deletePartnerInvitation(string|int $id) Delegates to Api\Partners\Invitations::deletePartnerInvitation().
 * @method string listChannels(array $query = []) Delegates to Api\Channels::listChannels().
 * @method string getChannel(string|int $id) Delegates to Api\Channels::getChannel().
 * @method string createChannel(array $data) Delegates to Api\Channels::createChannel().
 * @method string renameChannel(string|int $id, array $data) Delegates to Api\Channels::renameChannel().
 * @method string setPrimaryChannel(string|int $id) Delegates to Api\Channels::setPrimaryChannel().
 * @method string refreshWhatsAppPhoneStatus(string|int $id) Delegates to Api\Channels::refreshWhatsAppPhoneStatus().
 * @method string getChannelByPhone(string $phone) Delegates to Api\Channels::getChannelByPhone().
 */
final class Spoki extends Client
{
    /** @var array<class-string<ApiResource>, ApiResource> Cached resources sharing this client. */
    private array $resources = [];

    /** @var list<class-string<ApiResource>> Resource classes available through this facade. */
    private const RESOURCE_CLASSES = [
        Api\Accounts::class,
        Api\Agencies::class,
        Api\Automations::class,
        Api\Campaigns::class,
        Api\Contacts::class,
        Api\CustomFields::class,
        Api\Embedding::class,
        Api\Invitations::class,
        Api\Lists::class,
        Api\Messages::class,
        Api\Reports::class,
        Api\Roles::class,
        Api\Tags::class,
        Api\Templates::class,
        Api\Tickets::class,
        Api\Media::class,
        Api\Webhooks::class,
        Api\Partners::class,
        Api\Partners\Deprecated::class,
        Api\Partners\Roles::class,
        Api\Partners\Invitations::class,
        Api\Channels::class,
    ];

    /**
     * Access the Accounts API using this client's configuration.
     *
     * @return Api\Accounts Cached resource instance.
     * @example $api = $spoki->accounts();
     */
    public function accounts(): Api\Accounts
    {
        return $this->resources[Api\Accounts::class] ??= new Api\Accounts($this);
    }

    /**
     * Access the Agencies API using this client's configuration.
     *
     * @return Api\Agencies Cached resource instance.
     * @example $api = $spoki->agencies();
     */
    public function agencies(): Api\Agencies
    {
        return $this->resources[Api\Agencies::class] ??= new Api\Agencies($this);
    }

    /**
     * Access the Automations API using this client's configuration.
     *
     * @return Api\Automations Cached resource instance.
     * @example $api = $spoki->automations();
     */
    public function automations(): Api\Automations
    {
        return $this->resources[Api\Automations::class] ??= new Api\Automations($this);
    }

    /**
     * Access the Campaigns API using this client's configuration.
     *
     * @return Api\Campaigns Cached resource instance.
     * @example $api = $spoki->campaigns();
     */
    public function campaigns(): Api\Campaigns
    {
        return $this->resources[Api\Campaigns::class] ??= new Api\Campaigns($this);
    }

    /**
     * Access the Contacts API using this client's configuration.
     *
     * @return Api\Contacts Cached resource instance.
     * @example $api = $spoki->contacts();
     */
    public function contacts(): Api\Contacts
    {
        return $this->resources[Api\Contacts::class] ??= new Api\Contacts($this);
    }

    /**
     * Access the CustomFields API using this client's configuration.
     *
     * @return Api\CustomFields Cached resource instance.
     * @example $api = $spoki->customFields();
     */
    public function customFields(): Api\CustomFields
    {
        return $this->resources[Api\CustomFields::class] ??= new Api\CustomFields($this);
    }

    /**
     * Access the Embedding API using this client's configuration.
     *
     * @return Api\Embedding Cached resource instance.
     * @example $api = $spoki->embedding();
     */
    public function embedding(): Api\Embedding
    {
        return $this->resources[Api\Embedding::class] ??= new Api\Embedding($this);
    }

    /**
     * Access the Invitations API using this client's configuration.
     *
     * @return Api\Invitations Cached resource instance.
     * @example $api = $spoki->invitations();
     */
    public function invitations(): Api\Invitations
    {
        return $this->resources[Api\Invitations::class] ??= new Api\Invitations($this);
    }

    /**
     * Access the Lists API using this client's configuration.
     *
     * @return Api\Lists Cached resource instance.
     * @example $api = $spoki->lists();
     */
    public function lists(): Api\Lists
    {
        return $this->resources[Api\Lists::class] ??= new Api\Lists($this);
    }

    /**
     * Access the Messages API using this client's configuration.
     *
     * @return Api\Messages Cached resource instance.
     * @example $api = $spoki->messages();
     */
    public function messages(): Api\Messages
    {
        return $this->resources[Api\Messages::class] ??= new Api\Messages($this);
    }

    /**
     * Access the Reports API using this client's configuration.
     *
     * @return Api\Reports Cached resource instance.
     * @example $api = $spoki->reports();
     */
    public function reports(): Api\Reports
    {
        return $this->resources[Api\Reports::class] ??= new Api\Reports($this);
    }

    /**
     * Access the Roles API using this client's configuration.
     *
     * @return Api\Roles Cached resource instance.
     * @example $api = $spoki->roles();
     */
    public function roles(): Api\Roles
    {
        return $this->resources[Api\Roles::class] ??= new Api\Roles($this);
    }

    /**
     * Access the Tags API using this client's configuration.
     *
     * @return Api\Tags Cached resource instance.
     * @example $api = $spoki->tags();
     */
    public function tags(): Api\Tags
    {
        return $this->resources[Api\Tags::class] ??= new Api\Tags($this);
    }

    /**
     * Access the Templates API using this client's configuration.
     *
     * @return Api\Templates Cached resource instance.
     * @example $api = $spoki->templates();
     */
    public function templates(): Api\Templates
    {
        return $this->resources[Api\Templates::class] ??= new Api\Templates($this);
    }

    /**
     * Access the Tickets API using this client's configuration.
     *
     * @return Api\Tickets Cached resource instance.
     * @example $api = $spoki->tickets();
     */
    public function tickets(): Api\Tickets
    {
        return $this->resources[Api\Tickets::class] ??= new Api\Tickets($this);
    }

    /**
     * Access the Media API using this client's configuration.
     *
     * @return Api\Media Cached resource instance.
     * @example $api = $spoki->media();
     */
    public function media(): Api\Media
    {
        return $this->resources[Api\Media::class] ??= new Api\Media($this);
    }

    /**
     * Access the Webhooks API using this client's configuration.
     *
     * @return Api\Webhooks Cached resource instance.
     * @example $api = $spoki->webhooks();
     */
    public function webhooks(): Api\Webhooks
    {
        return $this->resources[Api\Webhooks::class] ??= new Api\Webhooks($this);
    }

    /**
     * Access the Partners API using this client's configuration.
     *
     * @return Api\Partners Cached resource instance.
     * @example $api = $spoki->partners();
     */
    public function partners(): Api\Partners
    {
        return $this->resources[Api\Partners::class] ??= new Api\Partners($this);
    }

    /**
     * Access the Partners / Deprecated API using this client's configuration.
     *
     * @return Api\Partners\Deprecated Cached resource instance.
     * @example $api = $spoki->deprecatedPartners();
     */
    public function deprecatedPartners(): Api\Partners\Deprecated
    {
        return $this->resources[Api\Partners\Deprecated::class] ??= new Api\Partners\Deprecated($this);
    }

    /**
     * Access the Partners / Roles API using this client's configuration.
     *
     * @return Api\Partners\Roles Cached resource instance.
     * @example $api = $spoki->partnerRoles();
     */
    public function partnerRoles(): Api\Partners\Roles
    {
        return $this->resources[Api\Partners\Roles::class] ??= new Api\Partners\Roles($this);
    }

    /**
     * Access the Partners / Invitations API using this client's configuration.
     *
     * @return Api\Partners\Invitations Cached resource instance.
     * @example $api = $spoki->partnerInvitations();
     */
    public function partnerInvitations(): Api\Partners\Invitations
    {
        return $this->resources[Api\Partners\Invitations::class] ??= new Api\Partners\Invitations($this);
    }

    /**
     * Access the Channels API using this client's configuration.
     *
     * @return Api\Channels Cached resource instance.
     * @example $api = $spoki->channels();
     */
    public function channels(): Api\Channels
    {
        return $this->resources[Api\Channels::class] ??= new Api\Channels($this);
    }

    /**
     * Forward a legacy flat API call to its owning resource class.
     *
     * Use the explicit resource accessors for new code and IDE navigation.
     * Unknown names and non-public methods are rejected before any network request.
     *
     * @param string $name Original API method name, e.g. listContacts.
     * @param array<array-key, mixed> $arguments Positional or named arguments for that method.
     * @return mixed The unchanged result of the resource method.
     * @throws \BadMethodCallException Unknown or inaccessible API method.
     * @throws SpokiException The delegated API request failed.
     * @example $spoki->listContacts(['page' => 1]);
     */
    public function __call(string $name, array $arguments): mixed
    {
        foreach (self::RESOURCE_CLASSES as $class) {
            if (!method_exists($class, $name)) {
                continue;
            }
            $method = new \ReflectionMethod($class, $name);
            if (!$method->isPublic() || $method->isConstructor() || $method->getDeclaringClass()->getName() !== $class) {
                continue;
            }
            $resource = $this->resources[$class] ??= new $class($this);
            return $resource->$name(...$arguments);
        }
        throw new \BadMethodCallException('Unknown Spoki API method: ' . $name);
    }

    /**
     * Verify a webhook signature through the Webhooks resource for legacy integrations.
     *
     * @param string $payload Exact raw request body before JSON decoding.
     * @param string $header Complete X-Spoki-Signature header containing t and v2.
     * @param string $secret Outgoing webhook signing secret.
     * @param int $tolerance Allowed timestamp drift in seconds; default 300.
     * @param int|null $now Optional Unix timestamp override for deterministic tests.
     * @return bool True when the V2 signature and timestamp are valid.
     * @example Spoki::verifyWebhookSignature($rawBody, $header, $secret);
     * @see Api\Webhooks::verifyWebhookSignature()
     */
    public static function verifyWebhookSignature(string $payload, string $header, string $secret, int $tolerance = 300, ?int $now = null): bool
    {
        return Api\Webhooks::verifyWebhookSignature($payload, $header, $secret, $tolerance, $now);
    }
}
