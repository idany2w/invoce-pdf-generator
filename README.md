```bash
cp api/.env.example .env
```

```bash
cp client/.env.local.example client/.env.local
```

```bash
sudo docker compose up
```

```bash
sudo docker compose exec --user=www api bash -c "composer install && php artisan key:generate && php artisan storage:link"
```