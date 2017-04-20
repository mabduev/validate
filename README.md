## Code Example
```php
<?php
  $validate = new Validate();
			
  $validation = $validate->check($_POST, array(
    'firstname' => array(
      'name' => 'Vorname',
      'required' => true,
      'min' => 2,
      'max' => 30
      ),
    ));
?>
```
## Installation
```php
<?php
  require 'classes/validate.php';
?>
```
## License

Open-sourced software licensed under the MIT license.
