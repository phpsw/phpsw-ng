# Architecture 

## Overview

For the initial version of PHP-SW website all data shown on the website will be stored in JSON files. 
The data in the JSON files will be converted to static HTML and it is the static HTML that is served up.

A script will offer the following commands:

- *phpsw:validate* This will validate the JSON data is valid. This should be run as part of CI.
- *phpsw:build:website* This will convert the JSON files into static HTML.
- *phpsq:sync:meetup* This will sync all data in the JSON files with the meetup. Initially the dataflow will be one way: from here to meetup.


### Package layout

The project is broken into the following parts:

- *common* This consists entities and repositories. Classes in these packages can be accessed by any other class. 
- *container* This is responsible for DI, resolving config, etc. Any class in here should only be accessed by bootstrap code. 
- *importer* Code in here is responsible for importing code (for now from JSON files). It can only access code in this package and the common code. 
- *website generator* Code here is responsible for creating the static site. It can only access code in this package and tne common code. 



