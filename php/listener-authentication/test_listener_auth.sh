#!/bin/bash

# Simulate a request from Radio Mast to your webhook handler. This is useful for testing if your script is working
# correctly.
curl -v "http://127.0.0.1:2016/radiomast_listenerauth_token.php" \
     -X POST \
     -d 'server=127.0.0.1' \
     -d 'port=80' \
     -d 'ip=127.0.0.1' \
     -d 'client=123456' \
     -d 'user=' \
     -d 'pass=' \
     -d 'agent=testing' \
     -d 'referer=' \
     -d 'listener-count=0' \
     -d 'action=listener_add' \
     -d 'listener-duration-1day=100' \
     -d 'listener-duration-7day=100' \
     -d 'mount=/3ecdc389-4d0c-1ba6-23e6-1edf3362fbf2?token=foo%26other=bar'
