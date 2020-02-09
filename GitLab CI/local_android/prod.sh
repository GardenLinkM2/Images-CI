#!/bin/bash
grep -Po '"versionName": *\K"[^"]*' app/build/outputs/apk/release/output.json | cut -d '"' -f 2
