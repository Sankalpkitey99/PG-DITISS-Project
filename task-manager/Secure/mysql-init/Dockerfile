FROM mysql:5.7

# Set root and user credentials
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_DATABASE=task_manager
ENV MYSQL_USER=admin
ENV MYSQL_PASSWORD=toor

# Copy init.sql into the initdb directory
COPY init.sql /docker-entrypoint-initdb.d/
