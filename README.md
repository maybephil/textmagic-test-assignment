# TextMagic Test Assignment

This is a test assignment for TextMagic.

## Deployment

You need to have Docker and docker-compose installed on your machine to run the application. If you run Fedora Linux, 
you can use podman provided that `podman-docker` is installed and `docker-compose` is configured to use its socket.

Deployment is done by running Makefile targets. The following targets are available:

* `.env` &mdash; create `.env` file from `.env.dist`.
* `init` &mdash; initialize application in production mode.
* `init-dev` &mdash; initialize application in development mode.
* `load-assessments-data` &mdash; load test assessments data.
* `down` &mdash; stop and remove containers.
* `down-into-the-sea` &mdash; stop and remove containers and volumes.

The application is configured in the `.env` file; `.env.dist` is provided as a template and contains default values.
It is copied automatically into `.env` during application initialization.

If you need to change any parameters, first run `make .env` and then edit the `.env` file. After that, you can run
`make init` or `make init-dev` to initialize the application.

After initializing the application, you need to load test assessments data by running `make load-assessments-data`.
This is done as a separate step because it is not necessary to load test data every time the application is initialized.

After that, you can access the application at `http://localhost:8080`. If the application was initialized in development
mode, pgadmin is available at `http://localhost:8081`. Use `PGADMIN_DEFAULT_EMAIL` and `PGADMIN_DEFAULT_PASSWORD` to
login to pgadmin and `DATABASE_PASSWORD` to connect to the database.

If you want to change the mode from development to production or vice versa, you need to run `make down` and then
`make init` or `make init-dev` again. Keep in mind that `make init` removes `docker-compose.override.yaml` keeping only
the `.dist` file, so all your changes will be lost.
