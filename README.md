## Laravel ACL on field level

### How to use the package: 

-   Add a dependency to your composer 
    <code>composer require neposoft/field-acl</code>


- Add the service provider in config/app.php <br>
    `Neposoft\FieldAcl\FieldAclServiceProvider::class `
  
- `php artisan vendor:publish` to publish config files, views and migrations

- Add class that you want to manage in config/fieldAcl.php , inside class  <br>
     ```php
     'classes' => [
        \App\User::class
    ]
```
- also change the roles and other parameters according to your needs. 

- In your model, use FieldAcl trait: 

         use    Neposoft\FieldAcl\FieldAcl;

- Open the browser at `/permissions` and you are ready to manage the permissions for the groups that you defined in config.

![Screenshot](http://i.imgur.com/FUp41FM.png)

If any trouble, don't hesistate to open issues :) 
