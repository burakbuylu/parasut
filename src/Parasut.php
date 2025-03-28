<?php

namespace BurakBuylu\Parasut;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Parasut
{
    private string $clientId;
    private string $clientSecret;
    private string $username;
    private string $password;
    private string $companyId;
    private ?string $accessToken = null;
    private Client $client;
    private string $baseUrl = 'https://api.parasut.com/v4';

    public function __construct(
        string $clientId,
        string $clientSecret,
        string $username,
        string $password,
        string $companyId
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->username = $username;
        $this->password = $password;
        $this->companyId = $companyId;
        $this->client = new Client();
    }

    /**
     * Get access token from API
     *
     * @throws GuzzleException
     * @return string
     */
    private function getAccessToken(): string
    {
        if ($this->accessToken !== null) {
            return $this->accessToken;
        }

        $response = $this->client->post($this->baseUrl . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'username' => $this->username,
                'password' => $this->password,
                'scope' => '*'
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $this->accessToken = $data['access_token'];

        return $this->accessToken;
    }

    /**
     * Send API request
     *
     * @param string $method
     * @param string $endpoint
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    private function request(string $method, string $endpoint, array $data = []): array
    {
        $response = $this->client->request($method, $this->baseUrl . $endpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'json' => $data
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create a new invoice
     *
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function createInvoice(array $data): array
    {
        return $this->request('POST', '/companies/' . $this->companyId . '/sales_invoices', $data);
    }

    /**
     * Get list of invoices
     *
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function getInvoices(array $params = []): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/sales_invoices', $params);
    }

    /**
     * Get invoice details
     *
     * @param int $invoiceId
     * @return array
     * @throws GuzzleException
     */
    public function getInvoice(int $invoiceId): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/sales_invoices/' . $invoiceId);
    }

    /**
     * Update invoice
     *
     * @param int $invoiceId
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function updateInvoice(int $invoiceId, array $data): array
    {
        return $this->request('PUT', '/companies/' . $this->companyId . '/sales_invoices/' . $invoiceId, $data);
    }

    /**
     * Delete invoice
     *
     * @param int $invoiceId
     * @return array
     * @throws GuzzleException
     */
    public function deleteInvoice(int $invoiceId): array
    {
        return $this->request('DELETE', '/companies/' . $this->companyId . '/sales_invoices/' . $invoiceId);
    }

    /**
     * Create a new contact
     *
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function createContact(array $data): array
    {
        return $this->request('POST', '/companies/' . $this->companyId . '/contacts', $data);
    }

    /**
     * Get list of contacts
     *
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function getContacts(array $params = []): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/contacts', $params);
    }

    /**
     * Get contact details
     *
     * @param int $contactId
     * @return array
     * @throws GuzzleException
     */
    public function getContact(int $contactId): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/contacts/' . $contactId);
    }

    /**
     * Update contact
     *
     * @param int $contactId
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function updateContact(int $contactId, array $data): array
    {
        return $this->request('PUT', '/companies/' . $this->companyId . '/contacts/' . $contactId, $data);
    }

    /**
     * Delete contact
     *
     * @param int $contactId
     * @return array
     * @throws GuzzleException
     */
    public function deleteContact(int $contactId): array
    {
        return $this->request('DELETE', '/companies/' . $this->companyId . '/contacts/' . $contactId);
    }

    /**
     * Create a new product
     *
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function createProduct(array $data): array
    {
        return $this->request('POST', '/companies/' . $this->companyId . '/products', $data);
    }

    /**
     * Get list of products
     *
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function getProducts(array $params = []): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/products', $params);
    }

    /**
     * Get product details
     *
     * @param int $productId
     * @return array
     * @throws GuzzleException
     */
    public function getProduct(int $productId): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/products/' . $productId);
    }

    /**
     * Update product
     *
     * @param int $productId
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function updateProduct(int $productId, array $data): array
    {
        return $this->request('PUT', '/companies/' . $this->companyId . '/products/' . $productId, $data);
    }

    /**
     * Delete product
     *
     * @param int $productId
     * @return array
     * @throws GuzzleException
     */
    public function deleteProduct(int $productId): array
    {
        return $this->request('DELETE', '/companies/' . $this->companyId . '/products/' . $productId);
    }

    /**
     * Create a new transaction
     *
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function createTransaction(array $data): array
    {
        return $this->request('POST', '/companies/' . $this->companyId . '/transactions', $data);
    }

    /**
     * Get list of transactions
     *
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function getTransactions(array $params = []): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/transactions', $params);
    }

    /**
     * Get transaction details
     *
     * @param int $transactionId
     * @return array
     * @throws GuzzleException
     */
    public function getTransaction(int $transactionId): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/transactions/' . $transactionId);
    }

    /**
     * Update transaction
     *
     * @param int $transactionId
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function updateTransaction(int $transactionId, array $data): array
    {
        return $this->request('PUT', '/companies/' . $this->companyId . '/transactions/' . $transactionId, $data);
    }

    /**
     * Delete transaction
     *
     * @param int $transactionId
     * @return array
     * @throws GuzzleException
     */
    public function deleteTransaction(int $transactionId): array
    {
        return $this->request('DELETE', '/companies/' . $this->companyId . '/transactions/' . $transactionId);
    }

    /**
     * Create a new payment
     *
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function createPayment(array $data): array
    {
        return $this->request('POST', '/companies/' . $this->companyId . '/payments', $data);
    }

    /**
     * Get list of payments
     *
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function getPayments(array $params = []): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/payments', $params);
    }

    /**
     * Get payment details
     *
     * @param int $paymentId
     * @return array
     * @throws GuzzleException
     */
    public function getPayment(int $paymentId): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/payments/' . $paymentId);
    }

    /**
     * Update payment
     *
     * @param int $paymentId
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function updatePayment(int $paymentId, array $data): array
    {
        return $this->request('PUT', '/companies/' . $this->companyId . '/payments/' . $paymentId, $data);
    }

    /**
     * Delete payment
     *
     * @param int $paymentId
     * @return array
     * @throws GuzzleException
     */
    public function deletePayment(int $paymentId): array
    {
        return $this->request('DELETE', '/companies/' . $this->companyId . '/payments/' . $paymentId);
    }

    /**
     * Get exchange rates
     *
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function getExchangeRates(array $params = []): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/exchange_rates', $params);
    }

    /**
     * Get exchange rate details
     *
     * @param int $exchangeRateId
     * @return array
     * @throws GuzzleException
     */
    public function getExchangeRate(int $exchangeRateId): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/exchange_rates/' . $exchangeRateId);
    }

    /**
     * Get company details
     *
     * @return array
     * @throws GuzzleException
     */
    public function getCompany(): array
    {
        return $this->request('GET', '/companies/' . $this->companyId);
    }

    /**
     * Get company settings
     *
     * @return array
     * @throws GuzzleException
     */
    public function getCompanySettings(): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/settings');
    }

    /**
     * Update company settings
     *
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function updateCompanySettings(array $data): array
    {
        return $this->request('PUT', '/companies/' . $this->companyId . '/settings', $data);
    }

    /**
     * Get company users
     *
     * @return array
     * @throws GuzzleException
     */
    public function getCompanyUsers(): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/users');
    }

    /**
     * Get company user details
     *
     * @param int $userId
     * @return array
     * @throws GuzzleException
     */
    public function getCompanyUser(int $userId): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/users/' . $userId);
    }

    /**
     * Get company roles
     *
     * @return array
     * @throws GuzzleException
     */
    public function getCompanyRoles(): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/roles');
    }

    /**
     * Get company role details
     *
     * @param int $roleId
     * @return array
     * @throws GuzzleException
     */
    public function getCompanyRole(int $roleId): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/roles/' . $roleId);
    }

    /**
     * Get company permissions
     *
     * @return array
     * @throws GuzzleException
     */
    public function getCompanyPermissions(): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/permissions');
    }

    /**
     * Get company permission details
     *
     * @param int $permissionId
     * @return array
     * @throws GuzzleException
     */
    public function getCompanyPermission(int $permissionId): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/permissions/' . $permissionId);
    }

    /**
     * Get company tags
     *
     * @return array
     * @throws GuzzleException
     */
    public function getCompanyTags(): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/tags');
    }

    /**
     * Get company tag details
     *
     * @param int $tagId
     * @return array
     * @throws GuzzleException
     */
    public function getCompanyTag(int $tagId): array
    {
        return $this->request('GET', '/companies/' . $this->companyId . '/tags/' . $tagId);
    }

    /**
     * Create company tag
     *
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function createCompanyTag(array $data): array
    {
        return $this->request('POST', '/companies/' . $this->companyId . '/tags', $data);
    }

    /**
     * Update company tag
     *
     * @param int $tagId
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function updateCompanyTag(int $tagId, array $data): array
    {
        return $this->request('PUT', '/companies/' . $this->companyId . '/tags/' . $tagId, $data);
    }

    /**
     * Delete company tag
     *
     * @param int $tagId
     * @return array
     * @throws GuzzleException
     */
    public function deleteCompanyTag(int $tagId): array
    {
        return $this->request('DELETE', '/companies/' . $this->companyId . '/tags/' . $tagId);
    }
} 