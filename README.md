#php-tupas
[![Build Status](https://travis-ci.org/tuutti/php-tupas.svg?branch=master)](https://travis-ci.org/tuutti/tupas)

##Usage
###Building a form
Create a new class that implements `\Tupas\Entity\BankInterface`.
````
<?php
$bank = new YourBankClass();

$form = new TupasForm($bank);
$form->setCancelUrl('http://example.com/tupas/cancel')
    ->setRejectedUrl('http://example.com/tupas/rejected')
    ->setReturnUrl('http://example.com/tupas/return')
    ->setLanguage('FI');
````
Generate and store transaction id in a storage that persists over multiple requests, for example:

````
<?php
$_SESSION['transaction_id'] = $form->getTransactionId();
````
Note: This is not required, but *highly* recommended as otherwise the users can reuse their valid authentication urls as many times they want.

Build your forms:
````
<?php
foreach ($form->build() as $key => $value) {
    // Your form logic should generate a hidden input field:
    // <input type="hidden" name="$key", value="$value">
}
````

Set form action to post to the Tupas service:
````
<form method="..." action="$bank->getActionUrl();">
````
###Validating a returning customer
````
<?php
...
// You should always use the bank number (three first 
// characters of B02K_STAMP) to validate the bank.
$bank_number = substr($_GET['B02K_STAMP'], 0, 3);
$bank = $bank_storage->loadByBankNumber($bank_number);
...
$tupas = new Tupas($bank, $_GET);

// Compare transaction id stored in persistent storage against 
// the one returned by the Tupas service.
if (!$tupas->isValidTransaction($_SESSION['transaction_id'])) {
    // Transaction id validation failed.
}
try {
    $tupas->validate();
}
catch (\Tupas\Exception\TupasGenericException $e) {
    // Validation failed due to missing parameters.
}
catch (\Tupas\Exception\HashMatchException $e) {
    // Validated due to hash mismatch.
}
````
Invalidate transaction id after a successful authentication:
````
<?php
unset($_SESSION['transaction_id']);
````

