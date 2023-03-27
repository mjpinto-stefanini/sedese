FROM ghcr.io/mjpinto-stefanini/node16-sedese:latest
RUN mkdir -p /app
WORKDIR /app
RUN npm install --global yarn
COPY package.json /app/
RUN npm install -g npm@latest @vue/cli @quasar/cli
COPY . /app
RUN npm install