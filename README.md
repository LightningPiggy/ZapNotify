# ZapNotify

A webapp (also installable as a Progressive Web App) that activates various notifications (sound, popup,...) when donations ("zaps") come in.

Live demo: https://oink.LightningPiggy.com/

Part of https://LightningPiggy.com/

# How to install and configure

1) Clone this project into a local folder on your PC or place the files into a webhosting service.

Tip: if you fork it in GitHub, and call the fork "\<yourusername\>.github.io" (without the "quotes") then
it will be publicly hosted by GitHub on https://yourusername.github.io (where yourusername is your username).

Read more about this, including custom domains, at https://pages.github.com/

2) Create a wallet in LNBits (demo server: https://legend.lnbits.com)

3) Copy-paste the "Wallet ID" from LNBits into this project's index.html file, in the apiUrl, on the first line below <script>.

For example, if your LNBits Wallet ID is c9168d53aa5942858354249f39f18de4
then in index.html, you should have:

```
const apiUrl = "wss://legend.lnbits.com/api/v1/ws/c9168d53aa5942858354249f39f18de4";
```
4) Create a LNURLp (= reusable payment string) in LNBits for the newly created wallet.
- Wallet: choose the newly created lnbits wallet
- Item description: "Donation to LightningPiggy.com" (users will see this in their wallet when they zap)
- Lightning Address: oink (or whatever you like)
- Min: 1000 (default value that wallet will show)
- Max: 100000000 (is this too low?)
- Currency: satoshis
- Comment maximum characters: 255
- Webhook URL: not needed
- Success message (optional): Oink! Thank you! Oink, oink!
- Nostr: Enable nostr zaps

5) Copy-paste the LNURL string from LNBits into this project's index.html file.
Do the same for the lightning address (if you created one as part of the LNURLp setup).

For example, if your LNURLp string is LNURL1DP68GURN8GHJ7MR9VAJKUEPWD3HXY6T5WVHXXMMD9AKXUATJD3CZ74RTDFNKZSSNL3E35
and your lightning address is oink@legend.lnbits.com then you should have in index.html something like:

```
<a href="lightning:LNURL1DP68GURN8GHJ7MR9VAJKUEPWD3HXY6T5WVHXXMMD9AKXUATJD3CZ74RTDFNKZSSNL3E35" class="text-secondary"><img class="QR" src="QR.png"/></a>
<a href="lightning:oink@legend.lnbits.com" class="text-secondary"><h2>oink@legend.lnbits.com</h2></a>
```

# How to use

If the files are hosted somewhere (such as https://yourusername.github.io/) then open that website.
Or if you have them locally on your PC, open the index.html file in a webbrowser.

Click the "Enable audio and visual notifications" button to allow the browser to play audio (blocked if the user hasn't interacted with the page) and to connect the websocket and wait for incoming payments.

Note that you can also install the applications as a Progressive Web App.
Do this, in Chrome for example, by clicking the menu in the top right (three dots) and choosing "Install LightningPiggy Oink..."

# How it works

The index.html file opens a websocket to LNBits using Javascript.

LNBits sends a notification over that websocket when a payment comes in.

The index.html parses the incoming payment data (amount, comment), plays an MP3 and shows a message and the comment to the user for 10 seconds.
