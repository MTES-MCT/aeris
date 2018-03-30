## Doctrine & forms

Some useful links include:

 - [Doctrine's mapping reference](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/basic-mapping.html). Here is a short list of the common ones:

    - string: Type that maps a SQL VARCHAR to a PHP string.
    - integer: Type that maps a SQL INT to a PHP integer.
    - smallint: Type that maps a database SMALLINT to a PHP integer.
    - bigint: Type that maps a database BIGINT to a PHP string.
    - boolean: Type that maps a SQL boolean or equivalent (TINYINT) to a PHP boolean.
    - decimal: Type that maps a SQL DECIMAL to a PHP string.
    - date: Type that maps a SQL DATETIME to a PHP DateTime object.
    - time: Type that maps a SQL TIME to a PHP DateTime object.
    - datetime: Type that maps a SQL DATETIME/TIMESTAMP to a PHP DateTime object.
    - datetimetz: Type that maps a SQL DATETIME/TIMESTAMP to a PHP DateTime object with timezone.
    - text: Type that maps a SQL CLOB to a PHP string.

 - [Doctrine's annotation reference](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/annotations-reference.html)
 - [Symfony's forms type list](https://symfony.com/doc/current/reference/forms/types.html)
 - [Working with associations](https://symfony.com/doc/current/doctrine/associations.html)