# php-skeleton-project
An empty project that can bu built as an one fat phar with phing.

## What has in it? What can it do?
* Includes composer config file. Added PSR-4 compatibility into it.
* Includes phing config file. Just 'phing build' it and your phar is served under the target directory.
* HtAccess Apache configuration for viewing the web side without hassle. Everything directs to the index.php file in the src/main/webapp directory.
* A simple AJAX RPC structure added in the src/main/webapp/ajax directory. Works like this: index.php?ajax=FILE_NAME&action=METHOD_NAME. Helper JSON returns and ERROR return methods added. 
* Cli and Web side availability added. 

## TODOS:
 * NGINX and IIS configurations needed.

