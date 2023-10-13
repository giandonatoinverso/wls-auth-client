# Oauth-frontend

# Installazione
Utilizzare Docker per creare uno stack con una immagine pubblicata.

```
docker compose -f docker-compose.yaml up -d
```

# Pubblicazione
Incrementare la versione a mano in package.json e package_dist.json

```
task publish-docker
```