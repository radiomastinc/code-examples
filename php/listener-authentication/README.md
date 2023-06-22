Radio Mast Listener Authentication - PHP Example
===================================================

This directory contains two examples of how to implement a custom listener authentication webhook handler
for [Radio Mast Streams](https://www.radiomast.io) using PHP.

Various options are demonstrated in the code and can be customized according to your needs.

The `radiomast_listenerauth_token.php` example shows how to authenticate listeners using a secret token appended to
the URL. This is a common way to provide "premium streams", where each listener has their own unique listening URL.

The `radiomast_listenerauth_ipban_accounts.php` example shows how to ban listeners by IP and user-agent, as well as
requiring a username and password using HTTP basic authentication. This method of authentication is not often 
supported by players, so we recommend using the token approach when possible.

## Setup

Copy one of the `.php` scripts to your webserver and customize it according to your needs.


## Using with Radio Mast

Inside your Radio Mast account, under your stream's *Configuration* tab, set your Listener Authentication type to 
"Custom" and enter the URL to your web application, such as:

    https://mysite.com/radiomast_listenerauth_token.php


## Testing

You can simulate the webhook by running the `test_listener_auth.sh` script included in this directory.
