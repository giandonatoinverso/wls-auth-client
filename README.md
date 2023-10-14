PHP application that allows users to authenticate with Oauth to the server 
https://github.com/giandonatoinverso/wls-backend-server 
and which returns the authorization code and username of the user who authenticated to an editable endpoint 
(default endpoint: https://github.com/giandonatoinverso/wls-productsales-app)

# Setup
You can use the example docker compose file that creates the complete stack

```
docker compose build --no-cache && docker compose -p wslStack up -d
```