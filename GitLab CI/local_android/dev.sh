#!/bin/bash
grep -Po '"versionName": *\K"[^"]*' app/build/outputs/apk/debug/output.json | cut -d '"' -f 2
