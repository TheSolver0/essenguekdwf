use NotchPay\NotchPay;
use NotchPay\Payment;

NotchPay::setApiKey('b.xxxxxxx');

try {
    $payment = Payment::initialize([
        'amount' => 5000,                // Amount according to currency format
        'email' => 'client@example.com', // Unique customer email
        'currency' => 'XAF',             // ISO currency code
        'callback' => 'https://example.com/callback', // Callback URL (optional)
        'reference' => 'order_123',      // Unique transaction reference
        'description' => 'Product purchase', // Description (optional)
        'channels' => ['mobile_money', 'card'], // Payment channels (optional)
        'metadata' => [                  // Metadata (optional)
            'customer_id' => '123',
            'order_id' => '456'
        ]
    ]);

    // Redirect user to payment URL
    header('Location: ' . $payment->authorization_url);
    exit();
} catch(\NotchPay\Exceptions\ApiException $e) {
    // Handle error
    echo $e->getMessage();
}
