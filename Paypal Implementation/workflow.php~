Recurring Payments with Express Checkout processing flow:

Merchant: step1. Calls SetExpressCheckout, setting up one or more billing
agreements in the request.

PayPal: step2. Returns a token, which identifies the transaction, to the merchant.

Merchant: step3. Redirects buyer's browser to: https://www.paypal.com/cgi-
bin/webscr?cmd=_express-checkout &token=<token returned by
SetExpressCheckout>

PayPal: step3. Displays login page and allows buyer to select payment options and
shipping address.

PayPal: step4. Redirects buyer's browser to returnURL passed toSetExpressCheckout
if buyer agrees to payment description.

Merchant: step5. Calls GetExpressCheckoutDetails to get buyer information
(optional).

PayPal: step5. Returns GetExpressCheckoutDetails response.

Merchant: step5. Displays merchant review page for buyer.

Merchant: step6. Calls DoExpressCheckoutPayment if the order includes one-time
purchases as well as a recurring payment. Otherwise, skip this step.

PayPal: step6. Returns DoExpressCheckoutPayment response

Merchant: step6. Calls CreateRecurringPaymentsProfile one time for each recurring
payment item included in the order.

PayPal: step6. Returns ProfileID inCreateRecurringPaymentsProfile response for
each profile successfully created.

Merchant: step7. Displays successful transaction page.

