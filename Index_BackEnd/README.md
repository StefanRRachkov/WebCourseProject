# Backend

Use the `DBConnection` in order to extract data from the database. It should be used like so:

```php
$db = DBConnection::getInstance();
$result = $db->getAllFrom("USERS");
```

The class is used as a singleton. 

We should add new functions (e.g. `getReferatsWithTitle('someTitle')`) that will take specific data from our database. Of course, we could pass parameters into them, if needed.
