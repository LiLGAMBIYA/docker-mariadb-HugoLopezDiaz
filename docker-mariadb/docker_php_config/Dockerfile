# 1. Empezamos desde la imagen base de PHP y Apache que ya usabas
FROM php:8.3-apache

# 2. Actualizamos los paquetes e instalamos las dependencias necesarias
# (wait-for-it es opcional pero muy recomendado para esperar a que la BD esté lista)
RUN apt-get update && apt-get install -y \
    procps \
    wget \
    && rm -rf /var/lib/apt/lists/*

# 3. ¡Esta es la línea clave!
# Usamos la utilidad de Docker para instalar extensiones de PHP.
# Instalamos pdo_mysql (para MariaDB/MySQL) y mysqli (otra librería común)
RUN docker-php-ext-install pdo_mysql mysqli

# 4. (Opcional pero recomendado) Añadir el script wait-for-it
ADD https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh /usr/local/bin/wait-for-it
RUN chmod +x /usr/local/bin/wait-for-it

# 5. (Opcional pero recomendado) Establecer el script como punto de entrada
# Esto hará que el contenedor web espere a que 'db:3306' responda antes de iniciar Apache.
# Previene errores de "conexión rehusada" si la web arranca antes que la BD.
CMD ["wait-for-it", "db:3306", "--", "apache2-foreground"]
