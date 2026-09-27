<?php
/**
 * GoogleAuth - lightweight Google OAuth 2.0 helper.
 *
 * No external libraries required. Uses PHP's file_get_contents / stream
 * context to call Google's token and userinfo endpoints directly.
 */
class GoogleAuth {

    private string $clientId;
    private string $clientSecret;
    private string $redirectUri;
    /** @var string[] */
    private array $allowedEmails;

    private const AUTH_URL  = 'https://accounts.google.com/o/oauth2/v2/auth';
    private const TOKEN_URL = 'https://oauth2.googleapis.com/token';
    private const USER_URL  = 'https://www.googleapis.com/oauth2/v3/userinfo';

    public function __construct() {
        $this->clientId      = env_get('GOOGLE_CLIENT_ID');
        $this->clientSecret  = env_get('GOOGLE_CLIENT_SECRET');
        $this->redirectUri   = env_get('GOOGLE_REDIRECT_URI');

        $raw = env_get('GOOGLE_ALLOWED_EMAILS');
        $this->allowedEmails = array_filter(
            array_map('trim', explode(',', $raw))
        );
    }

    /**
     * Build the URL to redirect the user to Google's consent screen.
     * Stores a random state token in the session to prevent CSRF.
     */
    public function getAuthUrl(): string {
        $state = bin2hex(random_bytes(16));
        $_SESSION['google_oauth_state'] = $state;

        $params = http_build_query([
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUri,
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'access_type'   => 'online',
            'prompt'        => 'select_account',
            'state'         => $state,
        ]);

        return self::AUTH_URL . '?' . $params;
    }

    /**
     * Handle the callback from Google.
     *
     * @param  string $code   The authorization code from ?code=
     * @param  string $state  The state value from ?state=
     * @return array{ok:bool, email:string, name:string, picture:string, error:string}
     */
    public function handleCallback(string $code, string $state): array {
        // 1. Validate state to prevent CSRF
        $expected = $_SESSION['google_oauth_state'] ?? '';
        unset($_SESSION['google_oauth_state']);

        if ($expected === '' || !hash_equals($expected, $state)) {
            return ['ok' => false, 'error' => 'Invalid OAuth state. Please try again.', 'email' => '', 'name' => '', 'picture' => ''];
        }

        // 2. Exchange the authorization code for an access token
        $tokenData = $this->fetchToken($code);
        if (isset($tokenData['error'])) {
            return ['ok' => false, 'error' => 'Google token error: ' . ($tokenData['error_description'] ?? $tokenData['error']), 'email' => '', 'name' => '', 'picture' => ''];
        }

        $accessToken = $tokenData['access_token'] ?? '';
        if ($accessToken === '') {
            return ['ok' => false, 'error' => 'No access token received from Google.', 'email' => '', 'name' => '', 'picture' => ''];
        }

        // 3. Fetch the user's profile from Google
        $profile = $this->fetchProfile($accessToken);
        if (isset($profile['error'])) {
            return ['ok' => false, 'error' => 'Could not fetch Google profile.', 'email' => '', 'name' => '', 'picture' => ''];
        }

        $email   = strtolower(trim($profile['email'] ?? ''));
        $verified = $profile['email_verified'] ?? false;
        $name    = $profile['name'] ?? $email;
        $picture = $profile['picture'] ?? '';

        // 4. Verify the email is confirmed by Google
        if (!$verified) {
            return ['ok' => false, 'error' => 'Google account email is not verified.', 'email' => $email, 'name' => $name, 'picture' => $picture];
        }

        // 5. Check against the allowed-emails whitelist
        if (!empty($this->allowedEmails)) {
            $allowed = array_map('strtolower', $this->allowedEmails);
            if (!in_array($email, $allowed, true)) {
                return ['ok' => false, 'error' => 'This Google account is not authorized to access the admin panel.', 'email' => $email, 'name' => $name, 'picture' => $picture];
            }
        }

        return ['ok' => true, 'email' => $email, 'name' => $name, 'picture' => $picture, 'error' => ''];
    }

    /**
     * POST to Google's token endpoint and return decoded JSON.
     */
    private function fetchToken(string $code): array {
        $body = http_build_query([
            'code'          => $code,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri'  => $this->redirectUri,
            'grant_type'    => 'authorization_code',
        ]);

        $context = stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n"
                           . "Accept: application/json\r\n",
                'content' => $body,
                'timeout' => 10,
            ],
            'ssl' => [
                'verify_peer'      => true,
                'verify_peer_name' => true,
            ],
        ]);

        $response = @file_get_contents(self::TOKEN_URL, false, $context);
        if ($response === false) {
            return ['error' => 'network_error', 'error_description' => 'Could not reach Google token endpoint.'];
        }
        return json_decode($response, true) ?? ['error' => 'invalid_response'];
    }

    /**
     * GET the Google userinfo endpoint using the access token.
     */
    private function fetchProfile(string $accessToken): array {
        $context = stream_context_create([
            'http' => [
                'method'  => 'GET',
                'header'  => "Authorization: Bearer {$accessToken}\r\n"
                           . "Accept: application/json\r\n",
                'timeout' => 10,
            ],
            'ssl' => [
                'verify_peer'      => true,
                'verify_peer_name' => true,
            ],
        ]);

        $response = @file_get_contents(self::USER_URL, false, $context);
        if ($response === false) {
            return ['error' => 'network_error'];
        }
        return json_decode($response, true) ?? ['error' => 'invalid_response'];
    }
}
