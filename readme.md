hosts

127.0.0.1	sedese.stefanini.test

127.0.0.1	api-sedese.stefanini.test

127.0.0.1	mysql-sedese.test

Para a aplicação no servidor devem ser feitas as seguintes alterações:

arquivo .env.development

NODE_ENV=development
VUE_API_URL=http://200.198.62.82/api/v1/
VUE_APP_TITLE='SISCAP - SEDESE Social'

VUE_APP_API_URL='http://200.198.62.82/api/v1/'

arquivo docker-composer.yml

version: '3.2'

services:

  frontend:
    image: ghcr.io/mjpinto-stefanini/node16-sedese:latest
    labels:
      - traefik.http.routers.sedese.rule=Host(`sedese.stefanini.test`)
    volumes:
      - ./frontend:/app
    environment:
      - PROJECT_WEBROOT=/src/public
    ports:
      - '8080:8080'
    networks:
      - default
  backend:
    image: ghcr.io/mjpinto-stefanini/php82-sedese:latest
    labels:
      - traefik.http.routers.api-sedese.rule=Host(`api-sedese.stefanini.test`)
    volumes:
      - ./backend:/src
    environment:
      - PROJECT_WEBROOT=/src/public
    ports:
      - '80:80'
    networks:
      - default

  database:
    image: mariadb:latest
    labels:
      - traefik.http.routers.mysql-sedese.rule=Host(`mysql-sedese.test`)
    environment:
      MYSQL_ROOT_PASSWORD: "root"
      MYSQL_DATABASE: "sedese"
    ports:
      - "3306:3306"
    volumes:
      - ./mysql/data:/var/lib/mysql
      - ./mysql/dumps:/var/dumps
    networks:
      - default

networks:
  default:
    name: dev-network
    external: true

arquivo ViewPage.vue - linha 274

            baseURL: 'http://200.198.62.82/api/v1/',