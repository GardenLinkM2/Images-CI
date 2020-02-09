FROM debian:buster
MAINTAINER Forestier Florian <Florian.Forestier@etu.uca.fr>


COPY My_Root_CA.cer /etc/ssl/certs/My_Root_CA.cer
COPY My_Issuing_CA.cer /etc/ssl/certs/My_Issuing_CA.cer

RUN apt-get update --yes
RUN apt-get install --yes wget tar unzip lib32stdc++6 lib32z1 apt-transport-https dirmngr gnupg ca-certificates openjdk-11-jdk
RUN apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys 3FA7E0328081BFF6A14DA29AA6A19B38D3D831EF
RUN echo "deb https://download.mono-project.com/repo/debian stable-buster main" | tee /etc/apt/sources.list.d/mono-official-stable.list
RUN apt-get update --yes && apt-get install --yes mono-complete

RUN wget -qO- https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor > microsoft.asc.gpg
RUN mv microsoft.asc.gpg /etc/apt/trusted.gpg.d/
RUN wget -q https://packages.microsoft.com/config/debian/10/prod.list
RUN mv prod.list /etc/apt/sources.list.d/microsoft-prod.list
RUN chown root:root /etc/apt/trusted.gpg.d/microsoft.asc.gpg
RUN chown root:root /etc/apt/sources.list.d/microsoft-prod.list
RUN apt-get update
RUN apt-get install dotnet-sdk-3.1 -y
RUN apt-get install curl -y

ENV JAVA_HOME "/usr/lib/jvm/java-11-openjdk-amd64"

RUN $JAVA_HOME/bin/keytool -storepasswd -new mysecretpassword -keystore $JAVA_HOME/lib/security/cacerts -storepass changeit && \
    echo "yes" | $JAVA_HOME/bin/keytool -import -trustcacerts -file /etc/ssl/certs/My_Root_CA.cer -alias my-root-ca -keystore $JAVA_HOME/lib/security/cacerts -storepass mysecretpassword && \
    echo "yes" | $JAVA_HOME/bin/keytool -import -trustcacerts -file /etc/ssl/certs/My_Issuing_CA.cer -alias my-issuing-ca -keystore $JAVA_HOME/lib/security/cacerts -storepass mysecretpassword

RUN dotnet tool install --global dotnet-sonarscanner --version 4.8.0 


ENV SONAR_LOGIN "/d:sonar.login={{EDITED}}"
ENV SONAR_URL "/k:"backend" /d:sonar.host.url=https://quality.artheriom.fr/"
ENV CURL_PARAMS "-u admin:{{EDITED}} -T archive.tar -k"
ENV BINARIES "https://binaries.artheriom.fr/artifactory/generic-local/backend"