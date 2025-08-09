#!/bin/bash
# This script is designed to automate the local startup of the project
# Check if XAMPP is installed and attempt to locate its control script via the pathway of C:/xampp/xampp-control.exe
XAMPP_CONTROL="C:/xampp/xampp-control.exe"

# Check if the XAMPP control script exists with debugging notions
if [ ! -f "$XAMPP_CONTROL" ]; then
    echo "Error: XAMPP control script not found at $XAMPP_CONTROL."
    echo "Please update the 'XAMPP_CONTROL' variable in this script with the correct path to your XAMPP installation."
    exit 1
fi

# Start the XAMPP control panel
"$XAMPP_CONTROL" start
