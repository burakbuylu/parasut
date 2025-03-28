# Paraşüt API PHP Paketi

Bu paket, Paraşüt API'sini PHP uygulamalarınızda kolayca kullanmanızı sağlar.

## Özellikler

- PHP 7.4 ve üzeri uyumluluğu
- Modern OOP yaklaşımı
- PSR-4 autoloading
- Guzzle HTTP client entegrasyonu
- Kapsamlı dokümantasyon
- Unit test desteği
- Tüm Paraşüt API endpoint'leri desteği

## Kurulum

Composer ile kurulum yapabilirsiniz:

```bash
composer require burakbuylu/parasut
```

## Kullanım

### Temel Kullanım

```php
use BurakBuylu\Parasut\Parasut;

$parasut = new Parasut(
    'client_id',
    'client_secret',
    'username',
    'password',
    'company_id'
);
```

### Fatura İşlemleri

```php
// Fatura oluşturma
$invoice = $parasut->createInvoice([
    'data' => [
        'type' => 'sales_invoices',
        'attributes' => [
            'item_type' => 'invoice',
            'description' => 'Test Fatura',
            'issue_date' => '2024-03-20',
            'currency' => 'TRY',
            'exchange_rate' => 1,
            'withholding_rate' => 0,
            'vat_withholding_rate' => 0,
            'invoice_discount_type' => 'amount',
            'invoice_discount' => 0,
            'billing_address' => 'Test Adres',
            'billing_phone' => '5555555555',
            'billing_fax' => '',
            'tax_office' => 'Test Vergi Dairesi',
            'tax_number' => '1234567890',
            'city' => 'İstanbul',
            'district' => 'Kadıköy',
            'is_archived' => false,
            'remaining_amount' => 1000,
            'remaining_amount_in_trl' => 1000,
            'payment_status' => 'overdue',
            'shipment_included' => false,
            'cash_sale' => false,
            'shipment_date' => null,
            'shipment_number' => null,
            'order_date' => null,
            'order_number' => null,
            'details' => [
                [
                    'type' => 'sales_invoice_details',
                    'attributes' => [
                        'quantity' => 1,
                        'unit_price' => 1000,
                        'vat_rate' => 18,
                        'discount_type' => 'amount',
                        'discount_value' => 0,
                        'excise_duty_type' => null,
                        'excise_duty_value' => null,
                        'communications_tax_rate' => null,
                        'description' => 'Test Ürün'
                    ]
                ]
            ]
        ]
    ]
]);

// Fatura listesi alma
$invoices = $parasut->getInvoices();

// Fatura detayı alma
$invoiceDetail = $parasut->getInvoice(123);

// Fatura güncelleme
$updatedInvoice = $parasut->updateInvoice(123, [
    'data' => [
        'type' => 'sales_invoices',
        'attributes' => [
            'description' => 'Güncellenmiş Fatura'
        ]
    ]
]);

// Fatura silme
$parasut->deleteInvoice(123);
```

### Müşteri İşlemleri

```php
// Müşteri oluşturma
$contact = $parasut->createContact([
    'data' => [
        'type' => 'contacts',
        'attributes' => [
            'name' => 'Test Müşteri',
            'short_name' => 'TM',
            'contact_type' => 'company',
            'tax_office' => 'Test Vergi Dairesi',
            'tax_number' => '1234567890',
            'district' => 'Kadıköy',
            'city' => 'İstanbul',
            'address' => 'Test Adres',
            'phone' => '5555555555',
            'email' => 'test@example.com'
        ]
    ]
]);

// Müşteri listesi alma
$contacts = $parasut->getContacts();

// Müşteri detayı alma
$contactDetail = $parasut->getContact(123);

// Müşteri güncelleme
$updatedContact = $parasut->updateContact(123, [
    'data' => [
        'type' => 'contacts',
        'attributes' => [
            'name' => 'Güncellenmiş Müşteri'
        ]
    ]
]);

// Müşteri silme
$parasut->deleteContact(123);
```

### Ürün İşlemleri

```php
// Ürün oluşturma
$product = $parasut->createProduct([
    'data' => [
        'type' => 'products',
        'attributes' => [
            'name' => 'Test Ürün',
            'code' => 'TU001',
            'unit' => 'adet',
            'vat_rate' => 18,
            'unit_price' => 1000,
            'currency' => 'TRY',
            'description' => 'Test Ürün Açıklaması'
        ]
    ]
]);

// Ürün listesi alma
$products = $parasut->getProducts();

// Ürün detayı alma
$productDetail = $parasut->getProduct(123);

// Ürün güncelleme
$updatedProduct = $parasut->updateProduct(123, [
    'data' => [
        'type' => 'products',
        'attributes' => [
            'name' => 'Güncellenmiş Ürün'
        ]
    ]
]);

// Ürün silme
$parasut->deleteProduct(123);
```

### İşlem İşlemleri

```php
// İşlem oluşturma
$transaction = $parasut->createTransaction([
    'data' => [
        'type' => 'transactions',
        'attributes' => [
            'description' => 'Test İşlem',
            'date' => '2024-03-20',
            'amount' => 1000,
            'currency' => 'TRY',
            'exchange_rate' => 1,
            'transaction_type' => 'income'
        ]
    ]
]);

// İşlem listesi alma
$transactions = $parasut->getTransactions();

// İşlem detayı alma
$transactionDetail = $parasut->getTransaction(123);

// İşlem güncelleme
$updatedTransaction = $parasut->updateTransaction(123, [
    'data' => [
        'type' => 'transactions',
        'attributes' => [
            'description' => 'Güncellenmiş İşlem'
        ]
    ]
]);

// İşlem silme
$parasut->deleteTransaction(123);
```

### Ödeme İşlemleri

```php
// Ödeme oluşturma
$payment = $parasut->createPayment([
    'data' => [
        'type' => 'payments',
        'attributes' => [
            'description' => 'Test Ödeme',
            'date' => '2024-03-20',
            'amount' => 1000,
            'currency' => 'TRY',
            'exchange_rate' => 1,
            'payment_type' => 'cash'
        ]
    ]
]);

// Ödeme listesi alma
$payments = $parasut->getPayments();

// Ödeme detayı alma
$paymentDetail = $parasut->getPayment(123);

// Ödeme güncelleme
$updatedPayment = $parasut->updatePayment(123, [
    'data' => [
        'type' => 'payments',
        'attributes' => [
            'description' => 'Güncellenmiş Ödeme'
        ]
    ]
]);

// Ödeme silme
$parasut->deletePayment(123);
```

### Döviz İşlemleri

```php
// Döviz kurları listesi alma
$exchangeRates = $parasut->getExchangeRates();

// Döviz kuru detayı alma
$exchangeRateDetail = $parasut->getExchangeRate(123);
```

### Şirket İşlemleri

```php
// Şirket detayları alma
$company = $parasut->getCompany();

// Şirket ayarları alma
$companySettings = $parasut->getCompanySettings();

// Şirket ayarları güncelleme
$updatedCompanySettings = $parasut->updateCompanySettings([
    'data' => [
        'type' => 'settings',
        'attributes' => [
            'setting_key' => 'setting_value'
        ]
    ]
]);

// Şirket kullanıcıları listesi alma
$companyUsers = $parasut->getCompanyUsers();

// Şirket kullanıcı detayı alma
$companyUserDetail = $parasut->getCompanyUser(123);

// Şirket rolleri listesi alma
$companyRoles = $parasut->getCompanyRoles();

// Şirket rol detayı alma
$companyRoleDetail = $parasut->getCompanyRole(123);

// Şirket izinleri listesi alma
$companyPermissions = $parasut->getCompanyPermissions();

// Şirket izin detayı alma
$companyPermissionDetail = $parasut->getCompanyPermission(123);

// Şirket etiketleri listesi alma
$companyTags = $parasut->getCompanyTags();

// Şirket etiket detayı alma
$companyTagDetail = $parasut->getCompanyTag(123);

// Şirket etiketi oluşturma
$newCompanyTag = $parasut->createCompanyTag([
    'data' => [
        'type' => 'tags',
        'attributes' => [
            'name' => 'Test Etiket'
        ]
    ]
]);

// Şirket etiketi güncelleme
$updatedCompanyTag = $parasut->updateCompanyTag(123, [
    'data' => [
        'type' => 'tags',
        'attributes' => [
            'name' => 'Güncellenmiş Etiket'
        ]
    ]
]);

// Şirket etiketi silme
$parasut->deleteCompanyTag(123);
```

## Geliştirme

### Gereksinimler

- PHP 7.4 veya üzeri
- Composer
- PHPUnit (test için)

### Test Çalıştırma

```bash
composer test
```

### Kod Standartları Kontrolü

```bash
composer cs-check
```

### Kod Standartları Düzeltme

```bash
composer cs-fix
```

## Lisans

Bu paket MIT lisansı altında lisanslanmıştır. Detaylar için [LICENSE](LICENSE) dosyasına bakın.

## Destek

Herhangi bir sorunuz veya öneriniz varsa, lütfen GitHub üzerinden issue açın. 