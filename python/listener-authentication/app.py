from flask import Flask, request, Response

app = Flask(__name__)

JINGLE_MP3_URL = 'http://....'      # URL to play a preroll
DENIAL_MP3_URL = 'http://....'      # URL to play when a listener is denied.


@app.route('/listener-auth', methods=["GET", "POST"])
def listener_auth():
    resp = Response("")

    allow_listener = True
    mount = request.form.get('mount', '/')

    # The mount may contain querystring parameters, so strip them out.
    if "?" in mount:
        mount = mount[0:mount.index('?')]

    # Extract some webhook parameters that you may find useful.
    user_agent = request.form.get('agent', '')                  # User agent of the listener.
    user_ip = request.form.get('ip')                            # IP address of the listener. Can be used to implement
                                                                # custom geoblocking or preroll targeting.
    duration_24hr = int(request.form.get('listener-duration-1day', 0))  # Get cumulative listening time of this listener within the last 24 hours.
    duration_7day = int(request.form.get('listener-duration-7day', 0))  # Get cumulative listening time of this listener within the last 7 days.

    # Build a response
    if allow_listener:
        resp.headers['icecast-auth-user'] = 1           # Authorize the listener - allows them to listen!
        resp.headers['preroll'] = JINGLE_MP3_URL        # Optional: Play a preroll jingle
        resp.headers['icecast-auth-timelimit'] = 7200   # Optional: Impose a maximum listening duration on this session.
                                                        # Radio Mast will drop the listener once this time has been
                                                        # exceeded (seconds)
    else:
        # Deny the listener
        resp.headers['icecast-auth-user'] = 0

        # Optional: Redirect the listener to a denial audio message
        # (eg. "You are not authorized to listen to this stream").
        resp.headers['icecast-auth-redirect'] = DENIAL_MP3_URL

    return resp


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, threaded=True, debug=True)