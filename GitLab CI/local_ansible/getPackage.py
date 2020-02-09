import json
import requests
from requests.auth import HTTPBasicAuth
from argparse import ArgumentParser

compute_api = "https://binaries.artheriom.fr/artifactory/api/storage/"

parser = ArgumentParser()
parser.add_argument("-r", "--requested", help="Define requested repository.", default="")
parser.add_argument("-m", "--isMaven", help="Define if project is Maven Project.", default=False)
parser.add_argument("-o", "--output", help="Define artifact output", default="")
args, unknown = parser.parse_known_args()

if(args.requested=="" or args.output==""):
    print("FATAL : You must define props !")
    exit(0)

isMaven = args.isMaven
outputName = args.output
requested = args.requested



instances_rq = requests.get(url=compute_api+requested, verify=False, auth=HTTPBasicAuth("admin", "{{EDITED}}"))
instance_file = json.loads(instances_rq.content)

found=False

nb = len(instance_file["children"])

if(isMaven):
    # One more loop ! \o/
    foundMaven=False
    while(nb!=0 and foundMaven==False):
        if(instance_file["children"][nb-1]["folder"]):
            foundMaven=True
            requested = requested+instance_file["children"][nb-1]["uri"]
            instances_rq = requests.get(url=compute_api+requested, verify=False, auth=HTTPBasicAuth("admin", "{{EDITED}}"))
            instance_file = json.loads(instances_rq.content)
            nb = len(instance_file["children"])
        else:
            nb=nb-1
    if(foundMaven==False):
        print("FATAL : Could not find Maven repo !")
        exit(0)

file=""
while(nb!=0 and found==False):
    temp = instance_file["children"][nb-1]["uri"].split(".")
    if(temp[len(temp)-1]=="tar" or temp[len(temp)-1]=="jar" or temp[len(temp)-1]=="apk"):
       file=instance_file["children"][nb-1]["uri"]
       found=True
    nb=nb-1

if(file==""):
    print("FATAL : File not found !")
    exit(0)

instances_rq = requests.get(url=compute_api+requested+file, verify=False, auth=HTTPBasicAuth("admin", "{{EDITED}}"))
instance_file = json.loads(instances_rq.content)

instances_rq = requests.get(url=instance_file["downloadUri"], verify=False, auth=HTTPBasicAuth("admin", "{{EDITED}}"))


f = open(outputName, "wb")
f.write(instances_rq.content)
f.close()
