<?php

namespace OpenCode\PaymenterAuthConnector\Extensions\OAuth\Providers;

use GuzzleHttp\RequestOptions;
use InvalidArgumentException;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class PaymenterProvider extends AbstractProvider
{
    public const IDENTIFIER = 'PAYMENTER';

    protected $scopes = ['profile'];

    protected $scopeSeparator = ' ';

    public static function additionalConfigKeys(): array
    {
        return ['base_url', 'authorize_path', 'token_path', 'user_path'];
    }

    protected function getBaseUrl(): string
    {
        $baseUrl = $this->getConfig('base_url');

        if (!is_string($baseUrl) || $baseUrl === '') {
            throw new InvalidArgumentException('Missing base_url');
        }

        return rtrim($baseUrl, '/');
    }

    protected function getAuthUrl($state): string
    {
        return $this->buildAuthUrlFromBase($this->getBaseUrl() . $this->getPath('authorize_path', '/oauth/authorize'), $state);
    }

    protected function getTokenUrl(): string
    {
        return $this->getBaseUrl() . $this->getPath('token_path', '/api/oauth/token');
    }

    protected function getUserByToken($token): array
    {
        $response = $this->getHttpClient()->get($this->getBaseUrl() . $this->getPath('user_path', '/api/me'), [
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    protected function mapUserToObject(array $user): User
    {
        $name = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
        $email = $user['email'] ?? null;

        return (new User())->setRaw($user)->map([
            'id' => $user['id'] ?? null,
            'nickname' => $user['username'] ?? (is_string($email) ? explode('@', $email, 2)[0] : null),
            'name' => $name !== '' ? $name : ($user['name'] ?? $email),
            'email' => $email,
            'avatar' => null,
        ]);
    }

    protected function getPath(string $key, string $default): string
    {
        $path = $this->getConfig($key, $default);

        if (!is_string($path) || $path === '') {
            return $default;
        }

        return str_starts_with($path, '/') ? $path : '/' . $path;
    }
}
