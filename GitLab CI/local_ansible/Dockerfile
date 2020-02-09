FROM centos:8
MAINTAINER Forestier Florian <Florian.Forestier@etu.uca.fr>

COPY ssh_key /root/ssh_key
COPY getPackage.py /root/getPackage.py

RUN chmod 777 /root/getPackage.py


RUN yum install -y https://dl.fedoraproject.org/pub/epel/epel-release-latest-8.noarch.rpm
RUN yum upgrade -y
RUN yum update && yum install -y python3 wget curl ansible openssh openssh-clients
RUN curl "https://bootstrap.pypa.io/get-pip.py" -o "get-pip.py"
RUN python3 get-pip.py
RUN pip install requests

COPY known_hosts /root/.ssh/known_hosts
RUN chmod 600 /root/ssh_key