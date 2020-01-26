# phpdoodle
## Idea behind
I was looking for a very simple poll tool like the online doodle tool, to ask friend what they bring to your party etc. However I did not find a easy tool, all open source solutions were highly sophisticated. So I came up with this simple form.
## Installation
* Put all files into a directory on your webserver
* Create a new mySQL table. The amount of columsn and rows defines the size of the doodle
  * User varchar fields with utf8mb4_general_ci
* Rename _config.php.sample_ in _config.php_
* Adjust _config.php_ and put in your mySQL credentials
* Done