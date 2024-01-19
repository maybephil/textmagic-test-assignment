FROM docker.io/busybox AS process-configs

ARG PG_DATABASE_USER
ARG PG_DATABASE_PASSWORD

COPY config/pgadmin4/servers.json /servers.json

RUN sed -i 's/${DATABASE_USER}/'"$PG_DATABASE_USER"'/g' /servers.json && \
    sed -i 's/${DATABASE_PASSWORD}/'"$PG_DATABASE_PASSWORD"'/g' /servers.json

FROM docker.io/dpage/pgadmin4:8.2

COPY --from=process-configs /servers.json /pgadmin4/servers.json
