PHP application that allows users to authenticate with Oauth to the server 
https://github.com/giandonatoinverso/wls-backend-server 
and which returns the authorization code and username of the user who authenticated to an editable endpoint 
(default endpoint: https://github.com/giandonatoinverso/wls-productsales-app)

# Setup
You can use the example docker compose file that creates the complete stack

```
docker compose build --no-cache && docker compose -p wslStack up -d
```

## Context

This repository is part of a set of four interconnected projects created as part of my work for the security exam for service-oriented architectures: https://www.unimi.it/it/corsi/insegnamenti-dei-corsi-di-laurea/2024/sicurezza-delle-architetture-orientate-ai-servizi

1. [wls-productsales-app](https://github.com/giandonatoinverso/wls-productsales-app): PHP ERP application with custom OAuth authentication for role-based access privileges.

2. [wls-auth-client](https://github.com/giandonatoinverso/wls-auth-client): A PHP application for OAuth authentication, returning authorization codes and usernames for authenticated users to an editable endpoint

3. [wls-backend-server](https://github.com/giandonatoinverso/wls-backend-server): OAuth authentication server and wholesale system backend in TypeScript

4. [wsl-db](https://github.com/giandonatoinverso/wsl-db): Database