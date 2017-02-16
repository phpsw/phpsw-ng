#!/bin/bash
PROJ_ROOT=$(cd "$(dirname "${BASH_SOURCE[0]}")"/.. && pwd)
VENDOR_BIN="${PROJ_ROOT}/vendor/bin"
SRC="${PROJ_ROOT}/src"
SUMMARY=""
ERROR=0

function run_tool() {
    echo -e "\e[1;34m*********************************************"
    echo -e "\e[1;34m*\e[0;33m ${2}"
    echo -e "\e[1;34m*********************************************\e[0m"
    echo
    cd ${PROJ_ROOT} && ${1}

    if [ $? != 0 ]
    then
        SUMMARY="${SUMMARY}\e[1;31m"
        ERROR=1
    else
        SUMMARY="${SUMMARY}\e[1;32m"
    fi

    SUMMARY="${SUMMARY}\u25cf\e[0m ${2}\n"
    echo
}

function print_summary() {
    echo -e "\e[1;34m*********************************************"
    echo -e "\e[1;34m*\e[0;33m Summary"
    echo -e "\e[1;34m*********************************************\e[0m"
    echo -e ${SUMMARY}
}


run_tool "vendor/bin/php-cs-fixer fix" "PHP Coding Standards Fixer"
run_tool "vendor/bin/security-checker security:check" "Security Check"
run_tool "vendor/bin/phpunit" "Unit tests"

print_summary

exit ${ERROR}
