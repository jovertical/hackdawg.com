.PHONY: build

chore:
	@docker container exec -it web hackdawg-chore

deploy@local:
	@docker-compose \
		-f docker-compose.yml \
		-f docker-compose.local.yml \
		up --build --force-recreate

copy-hosts@local:
	@sudo chmod +x ./deploy/copy_hosts.local.sh
	@sudo ./deploy/copy_hosts.local.sh

deploy@production:
	@docker-compose \
		-f docker-compose.yml \
		-f docker-compose.production.yml \
		up -d --build --force-recreate

copy-hosts@production:
	@sudo chmod +x ./deploy/copy_hosts.production.sh
	@sudo ./deploy/copy_hosts.production.sh