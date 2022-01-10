Radio Mast Listener Authentication - PHP Example
===================================================

This directory contains an example of how to implement a custom listener authentication webhook handler
for [Radio Mast Streams](https://www.radiomast.io) using PHP.

Various options are demonstrated in the code and can be customized according to your needs.

## Setup

Copy the `radiomast_listenerauth.php` file to your webserver and customize the script according to your needs.


## Using with Radio Mast

Inside your Radio Mast account, under your stream's *Configuration* tab, set your Listener Authentication type to 
"Custom" and enter the URL to your web application:

    https://mysite.com/radiomast_listenerauth.php



## Testing

You can simulate the webhook by running the `test_listener_auth.sh` script included in this directory.
