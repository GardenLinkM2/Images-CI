FROM debian:stretch
MAINTAINER Forestier Florian <Florian.Forestier@etu.uca.fr>


RUN apt-get update && apt-get install -y openjdk-8-jdk
COPY application.properties /var/www/application.properties
COPY app.jar /var/www/app.jar

WORKDIR /var/www
EXPOSE 8080
CMD ["java", "-jar", "app.jar"]
