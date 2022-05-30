<?php
const TOKEN = "S6VSbeQ9KkrRi57xaNk3owm7czNa7ndqqQYwFkV5S8WHteg2Y9V5Bkn3FB2NfWyAVLbmUPsexgdfdcDFRgbTKJH2Qeb8jCVVxRFSoNooUxsgUm6JERzZzcbg2sa2gAH3"; // The secret token to add as a GitHub or GitLab secret, or otherwise as https://www.example.com/?token=secret-token
const REMOTE_REPOSITORY = "git@github.com:cessel/pro-ss.ru.git"; // The SSH URL to your repository
const DIR = "/home/virtwww/w_pro-ss-ru_f2809982/http/";                          // The path to your repostiroy; this must begin with a forward slash (/)
const BRANCH = "refs/heads/master";                                 // The branch route
const LOGFILE = "deploy.log";                                       // The name of the file you want to log to.
const GIT = "git";                                         // The path to the git executable
const MAX_EXECUTION_TIME = 180;                                     // Override for PHP's max_execution_time (may need set in php.ini)
const BEFORE_PULL = "";                                             // A command to execute before pulling
const AFTER_PULL = "";                                              // A command to execute after successfully pulling

require_once("deployer.php");
