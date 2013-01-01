@ECHO off
SET PHP_BIN=C:/php/php.exe
SET DOCTRINE_SCRIPT=doctrine.php
"%PHP_BIN%" -d safe_mode=Off -f "%DOCTRINE_SCRIPT%" %*