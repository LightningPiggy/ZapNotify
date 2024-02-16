# ZapNotify

A webapp (also installable as a Progressive Web App) that activates various notifications (sound, popup,...) when donations ("zaps") come in.

# How to install and configure

1) Copy the files in this folder to a webserver that supports PHP.

2) Configure the LNURLp extension in an LNBits instance with the following settings:
- Wallet: choose one of your lnbits wallets
- Item description: "Donation to LightningPiggy.com" (users will see this in their wallet when they zap)
- Lightning Address: oink (or whatever you like)
- Min: 1000 (default value that wallet will show)
- Max: 100000000 (is this too low?)
- Currency: satoshis
- Comment maximum characters: 255
- Webhook URL: https://yourwebsite.com/log.php (make sure this points to your own webserver's URL where you installed log.php)
- Success message (optional): Oink! Thank you! Oink, oink!
- Nostr: Enable nostr zaps

# How to use

Open the webpage where you installed the index.html file, such as: https://yourwebsite.com/

Click the "Enable ZapNotify notifications!" button to allow the browser to play audio (blocked if the user hasn't interacted with the page) and to start polling (each second) for new donations/zaps.

# How to test

To simulate the LNBits server calling the webhook URL, you can use curl:

```
curl -d '{"payment_hash": "cc1da5c4d0adb505807211cf56b25ae590a05e72ca6c73d9054b361fd764b8dd", "payment_request": "lnbc10n1pjumhmtsp5725pqgsf79jdmdwk2dpm28qlcn5r48vpnhy8qz0rq26ntknwxuuqpp5esw6t3xs4k6stqrjz884dvj6ukg2qhnjefk88kg9fvmpl4myhrwshp5f9g4tqed47kzzg5tgyyum25qr3mwjnlr5vn46j2temrw6xshez0qxqzjccqpjrzjqgj79x7039lj9k04g6khzxzlj5vak5udfp9jl5h290szug94cu3ykz6y2gqqdwgqqyqqqqryqqqqqvsqyg9qxpqysgq7fchu5ldrjtsrru7w7sewd54v6cdfd9uvcwwegpdk4325l7yewlh4j3kknlm0cq92etnljjaryjfnswkn9nl3usvk2w2sudy3kfuzdcql98mzp", "amount": 1234, "comment": "testing the webhook with curl", "webhook_data": "", "lnurlp": "jkasasqwe", "body": ""}' https://yourwebsite.com/log.php
```

# How it works

When a user makes a donation from a Bitcoin Lightning wallet, the wallet requests an invoice using [LNURLp](https://github.com/lnbits/lnurlp).

When they pay the invoice, LNBits calls the webhook URL (https://yourwebsite.com/log.php) and POSTs the payment details (amount, comment) as a JSON object.

The log.php script logs the details of the POST request into a file (payment_metrics.csv).

When a user has the webpage open and has clicked the button, the webpage polls the https://yourwebsite.com/last.php script each second to get the last line of payment_metrics.csv.

When this last line changes (meaning a new donation/zap came in) it parses that line (to get payment details), plays audio and displays the donation amount+comment to the user for a few seconds.
