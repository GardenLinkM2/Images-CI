FROM debian:stretch
MAINTAINER Forestier Florian <Florian.Forestier@etu.uca.fr>

RUN apt-get update --yes
RUN apt-get install --yes wget tar unzip lib32stdc++6 lib32z1 apt-transport-https dirmngr gnupg ca-certificates

RUN wget -qO- https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor > microsoft.asc.gpg
RUN mv microsoft.asc.gpg /etc/apt/trusted.gpg.d/
RUN wget -q https://packages.microsoft.com/config/debian/10/prod.list
RUN mv prod.list /etc/apt/sources.list.d/microsoft-prod.list
RUN chown root:root /etc/apt/trusted.gpg.d/microsoft.asc.gpg
RUN chown root:root /etc/apt/sources.list.d/microsoft-prod.list
RUN apt-get update
RUN apt-get install dotnet-sdk-3.1 -y
RUN apt-get install curl -y

COPY app.tar /var/www/app.tar
WORKDIR /var/www
RUN tar xvf app.tar
RUN chmod -R 777 ./
COPY appsettings.json appsettings.json

EXPOSE 5000
CMD ["./Union.Backend.API", "DbContext=noLocal", "--server.urls=http://0.0.0.0:5000"]