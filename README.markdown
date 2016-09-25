# Introduction

This is a simple project developed to learn how to incorporate Doctrine ORM in a Zend Framework, Zend Tool created application. The application demonstrates some of Doctrines most basic concepts including, creating successful YAML schema files, and one-to-one, one-to-many, and many-to-many CRUD operations.

Some of the immediate goals of the application besides learning how to use Doctrine, were to ensure that Doctrine result sets could be easily manipulated with Zend Form and Zend Paginator, stuff that you would use in any other daily work flow. 

# Requirements

This application was developed and or tested using [PHP 5.4](http://www.php.net), [Zend Framework 1.11.11](http://framework.zend.com) and an older version of [Doctrine 1.2.0](http://www.doctrine-project.org/). 

# Deploying

You will need to follow the official Zend Framework guidelines on creating an application including creating an entry in your servers hosts file and defining an Apache virtual host configuration entry that points to the applications public root directory. Refer to the docs directory for further information. To build the database you will need to use the Doctrine Command Line Interface script located in the application/scripts directory.

  To get a list of commands:
  
    doctrine
    
  To build the database issue this command:
    
    doctrine build-all
    
  To insert the default data, read from data yaml file.
    
    doctrine load-data
    
  To dump the data to the data fixture yaml file.
    
    doctrine dump-data

## License 

(The MIT License)

Copyright (c) 2011 Tom Shaw &lt;tom@visfx.me&gt;

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
'Software'), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
