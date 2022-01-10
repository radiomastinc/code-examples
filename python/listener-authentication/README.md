Radio Mast Listener Authentication - Python Example
===================================================

This directory contains an example of how to implement a custom listener authentication webhook handler
for [Radio Mast Streams](https://www.radiomast.io) using the [Flask framework](https://flask.palletsprojects.com/en/2.0.x/) for Python.

This application has a single URL route at `/listener-auth` which handles the custom listener authentication webhook
and authorizes the listener. Various options are demonstrated in the code and can be customized according to your needs.

## Setup and Run

Create a virtualenv and install the requirements (Flask):

    python -m virtualenv -p python3 demo-venv
    source demo-venv/bin/activate
    pip install -r requirements.txt
    
Run the example application with:

    python app.py
    

## Using with Radio Mast

Inside your Radio Mast account, under your stream's *Configuration* tab, set your Listener Authentication type to 
"Custom" and enter the URL to your web application:

    http://myip:5000/listener-auth

The built-in Flask webserver is not recommended for use in production. We recommend reading the [Flask deployment options](https://flask.palletsprojects.com/en/2.0.x/deploying/)
to see how to deploy this in production.


## Testing

You can simulate the webhook by running the `test_listener_auth.sh` script included in this directory.