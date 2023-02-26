test:
	@docker exec -it laravel_auth_package sh -c "./vendor/bin/phpunit"