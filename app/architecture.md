# Architecture 

## Overview

For the initial version of PHP-SW website all data shown on the website will be stored in JSON files. 
The data in the JSON files will be converted to static HTML and it is the static HTML that is served up.

A script will offer the following commands:

- *phpsw:validate* This will validate the JSON data is valid. This should be run as part of CI.
- *phpsw:build:website* This will convert the JSON files into static HTML.
- *phpsq:sync:meetup* This will sync all data in the JSON files with the meetup. Initially the dataflow will be one way: from here to meetup.



