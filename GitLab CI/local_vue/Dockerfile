FROM debian:stretch
MAINTAINER Forestier Florian <Florian.Forestier@etu.uca.fr>



RUN apt-get update --yes
RUN apt-get install --yes curl git openjdk-8-jdk wget unzip 
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install build-essential nodejs -y

RUN wget --output-document=sonar.zip https://binaries.sonarsource.com/Distribution/sonar-scanner-cli/sonar-scanner-cli-4.2.0.1873-linux.zip
RUN unzip -d sonar sonar.zip
ENV SONAR_HOME "$PWD/sonar/sonar-scanner-4.2.0.1873-linux/bin"
ENV PATH "$PATH:$PWD/sonar/sonar-scanner-4.2.0.1873-linux/bin"

ENV SONAR_SCANNER_OPTS "-Dsonar.host.url=https://quality.artheriom.fr/ -Dsonar.login=MDP -Dsonar.projectKey=admin"

COPY My_Root_CA.cer /etc/ssl/certs/My_Root_CA.cer
COPY My_Issuing_CA.cer /etc/ssl/certs/My_Issuing_CA.cer

ENV JAVA_HOME "/usr/lib/jvm/java-8-openjdk-amd64/jre/"

RUN $JAVA_HOME/bin/keytool -storepasswd -new mysecretpassword -keystore $PWD/sonar/sonar-scanner-4.2.0.1873-linux/jre/lib/security/cacerts -storepass changeit && \
    echo "yes" | $JAVA_HOME/bin/keytool -import -trustcacerts -file /etc/ssl/certs/My_Root_CA.cer -alias my-root-ca -keystore $PWD/sonar/sonar-scanner-4.2.0.1873-linux/jre/lib/security/cacerts -storepass mysecretpassword && \
    echo "yes" | $JAVA_HOME/bin/keytool -import -trustcacerts -file /etc/ssl/certs/My_Issuing_CA.cer -alias my-issuing-ca -keystore $PWD/sonar/sonar-scanner-4.2.0.1873-linux/jre/lib/security/cacerts -storepass mysecretpassword


ENV CURL_PARAMS "-u admin:MDP -T archive.tar -k"
ENV BINARIES "https://binaries.artheriom.fr/artifactory/generic-local/admin"

