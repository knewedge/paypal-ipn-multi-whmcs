# PayPal Multi WHMCS IPN
IPN broadcaster for PayPal to support multiple WHMCS installations

### Situation
PayPal provides an IPN service, which will do a callback to your defined IPN link to confirm the payment. This is a process behind the scenes and the customer won't notice anything. The problem is that PayPal only allows **one** IPN link, which means that you can only run one automated business with this PayPal account.

### Solution
This IPN script is the solution. Now you can run multiple different businesses with a single IPN endpoint. Please note that WHMCS prepends the business name to every transaction, e.g. Business XYX - Invoice 123. This script must be hosted on your web server and must be added in your PayPal settings as IPN URL. This script will then proxy the IPN POST to the right business based on the prepended business name in 'item_name'.

### Notification
Below is an example POST from the PayPal IPN. It contains several variables, but the most important ones are receiver_email and business values. This script uses the business value to filter the request and pass it to the right IPN. (This log has been captured from WHMCS)

```
transaction_subject => X
payment_date => 11:47:03 Oct 24, 2016 PDT
txn_type => web_accept
last_name => Doe
residence_country => UK
item_name => ABC Hosting - Invoice XXX
payment_gross => 
mc_currency => EUR
business => companysecondary@qarizm.com
payment_type => instant
protection_eligibility => Ineligible
verify_sign => X
payer_status => verified
tax => 0.00
payer_email => thisisthecustomer@qarizm.com
txn_id => X
quantity => 1
receiver_email => companyprimary@qarizm.com
first_name => John
payer_id => X
receiver_id => X
item_number => 
payment_status => Completed
payment_fee => 
mc_fee => 0.00
mc_gross => 0.00
custom => 0
charset => windows-1252
notify_version => 3.8
ipn_track_id => 0
```

### Installation
Adjust the IPNs in the script with your business names and IPN endpoints.
If you are using WHMCS please check the steps below to make it work.

### Credits
* Codeseekah for the original code (http://codeseekah.com).
* Fork of PayPal Octa IPN (https://github.com/devaqto/paypal-octa-ipn).

### License
MIT License
