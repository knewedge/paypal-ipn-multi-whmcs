# PayPal Octa IPN
IPN broadcaster for PayPal to support up to eight different IPN hosts. WHMCS used as example.

### Situation
PayPal provides an IPN service, which will do a callback to your defined IPN link to confirm the payment. This is a process behind the scenes and the customer won't notice anything. The problem is that PayPal only allows **one** IPN link, which means that you can only run one automated business with this PayPal account. Please note that PayPal permits you to have two PayPal accounts, one Personal account and one Business account.

### Solution
This Octa IPN script is the solution. Now you can run up to eight different businesses. PayPal allows you to add additional email addresses. Currently there is a limit of eight total email addresses, hence the name Octo. Using this approach you can provide your business a seperate email address for the payments. This script must be hosted on your web server and must be added in your PayPal settings as IPN URL. This script will then proxy the IPN POST to the right business based on the secondary email address.

### Notification
Below is an example POST from the PayPal IPN. It contains several variables, but the most important ones are receiver_email and business values. This script uses the business value to filter the request and pass it to the right IPN. (This log has been captured from WHMCS)

```
transaction_subject => X
payment_date => 11:47:03 Oct 24, 2016 PDT
txn_type => web_accept
last_name => Doe
residence_country => UK
item_name => Invoice XXX
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
1. Setup and validate extra PayPal email addresses in your account.
2. Enter the ones that you want to use in the script.
3. Adjust the IPNs in the script.
4. If you are using WHMCS please check the steps below to make it work.

### WHMCS Setup
* Go to: Setup - Payments - Payment Gateways - Manage Existing Gateways
* Enter in "PayPal Email" one of the secondary email addresses from PayPal that you want to use in this specific WHMCS.
* At the end of this email field add a comma, and enter your primary PayPal email address. This is only used for verification and is required.

(More information: http://docs.whmcs.com/PayPal#Invalid_Receiver_Email)

### Credits
* Codeseekah for the original code (http://codeseekah.com).

### License
MIT License