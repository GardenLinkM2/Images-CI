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

RUN wget --output-document=android-sdk.zip https://dl.google.com/android/repository/sdk-tools-linux-4333796.zip
RUN unzip -d android-sdk-linux android-sdk.zip
RUN echo y | android-sdk-linux/tools/bin/sdkmanager "platforms;android-28" >/dev/null
RUN echo y | android-sdk-linux/tools/bin/sdkmanager "platform-tools" >/dev/null
RUN echo y | android-sdk-linux/tools/bin/sdkmanager "build-tools;28.0.2" >/dev/null
ENV ANDROID_HOME $PWD/android-sdk-linux
ENV PATH $PATH:$PWD/android-sdk-linux/platform-tools/
RUN yes | android-sdk-linux/tools/bin/sdkmanager --licenses


RUN wget --output-document=sonar.zip https://binaries.sonarsource.com/Distribution/sonar-scanner-cli/sonar-scanner-cli-4.2.0.1873-linux.zip
RUN unzip -d sonar sonar.zip
ENV SONAR_HOME $PWD/sonar/sonar-scanner-4.2.0.1873-linux/bin
ENV PATH $PATH:$PWD/sonar/sonar-scanner-4.2.0.1873-linux/bin
ENV CURL_CREDENTIALS "-u admin:{{EDITED}} -k"

ENV SONAR_SCANNER_OPTS "-Dsonar.host.url=https://quality.artheriom.fr/ -Dsonar.login={{EDITED}} -Dsonar.projectKey=mobile -Dsonar.java.binaries=build/intermediates/classes"

RUN $JAVA_HOME/bin/keytool -storepasswd -new mysecretpassword -keystore $PWD/sonar/sonar-scanner-4.2.0.1873-linux/jre/lib/security/cacerts -storepass changeit && \
    echo "yes" | $JAVA_HOME/bin/keytool -import -trustcacerts -file /etc/ssl/certs/My_Root_CA.cer -alias my-root-ca -keystore $PWD/sonar/sonar-scanner-4.2.0.1873-linux/jre/lib/security/cacerts -storepass mysecretpassword && \
    echo "yes" | $JAVA_HOME/bin/keytool -import -trustcacerts -file /etc/ssl/certs/My_Issuing_CA.cer -alias my-issuing-ca -keystore $PWD/sonar/sonar-scanner-4.2.0.1873-linux/jre/lib/security/cacerts -storepass mysecretpassword


COPY prod.sh /root/prod.sh
COPY dev.sh /root/dev.sh
RUN chmod 777 /root/prod.sh
RUN chmod 777 /root/dev.sh