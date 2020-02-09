FROM openjdk:8-jdk
MAINTAINER Forestier Florian <Florian.Forestier@etu.uca.fr>

COPY My_Root_CA.cer /etc/ssl/certs/My_Root_CA.cer
COPY My_Issuing_CA.cer /etc/ssl/certs/My_Issuing_CA.cer

RUN apt-get update --yes
RUN apt-get install --yes wget tar unzip lib32stdc++6 lib32z1 maven

RUN wget https://services.gradle.org/distributions/gradle-6.1.1-bin.zip  --output-document=gradle.zip
RUN unzip -d /opt/gradle gradle.zip && rm gradle.zip
ENV PATH /opt/gradle/gradle-6.1.1/bin:${PATH}


RUN $JAVA_HOME/bin/keytool -storepasswd -new mysecretpassword -keystore $JAVA_HOME/jre/lib/security/cacerts -storepass changeit && \
    echo "yes" | $JAVA_HOME/bin/keytool -import -trustcacerts -file /etc/ssl/certs/My_Root_CA.cer -alias my-root-ca -keystore $JAVA_HOME/jre/lib/security/cacerts -storepass mysecretpassword && \
    echo "yes" | $JAVA_HOME/bin/keytool -import -trustcacerts -file /etc/ssl/certs/My_Issuing_CA.cer -alias my-issuing-ca -keystore $JAVA_HOME/jre/lib/security/cacerts -storepass mysecretpassword


ENV MAVEN_HOME /usr/share/maven
ENV MAVEN_CONFIG "/root/.m2"
ENV MAVEN_ARGS "-Dsonar.host.url=https://quality.artheriom.fr/ -Dsonar.login={{EDITED}}"
ENV MAVEN_OPTS "-Dsonar.host.url=https://quality.artheriom.fr/ -Dsonar.login={{EDITED}}"
ENV GRADLE_OPTS "-Dsonar.host.url=https://quality.artheriom.fr/ -Dsonar.login={{EDITED}}"
COPY settings.xml /root/.m2/settings.xml