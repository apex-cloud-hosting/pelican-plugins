# Paymenter Auth Connector (by OpenCode)

Adds Paymenter as an OAuth2 authentication provider in Pelican.

## Features

- Register Paymenter in Pelican's built-in OAuth settings
- Configure Paymenter Base URL, Client ID, and Client Secret
- Override OAuth endpoint paths when needed
- Customize login button display name and color
- Uses Paymenter's OAuth2 endpoints (`/oauth/authorize`, `/api/oauth/token`, `/api/me`)

## Setup

1. In Paymenter, create an OAuth client in **Admin -> OAuth Clients**.
2. Use your Pelican callback URL: `https://your-panel.example.com/auth/oauth/callback/paymenter`.
3. In Pelican, open **Admin -> Settings -> OAuth**, enable **Paymenter**, and fill in the values.

Paymenter's `/api/me` endpoint requires the `profile` scope. This plugin requests that scope automatically.
