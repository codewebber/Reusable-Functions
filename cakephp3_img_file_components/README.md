# Cakephp3 file component and image resize component : 

load component in particular controller : 

```php
     $this->loadComponent('File');
     $this->loadComponent('Resize');
```

### resize function calling from resize component
 
```php
        $file_type = $_FILES['vImage']['type'];
        $file_name = $_FILES['vImage']['name'];
        $file_size = $_FILES['vImage']['size'];
        $file_tmp = $_FILES['vImage']['tmp_name'];

        $this->Resize->resize($file_type, $file_name, $file_size, $file_tmp); 
```

### upload function calling from File component

```php
    $this->File->upload($file_tmpname, $targetdir, $file_orgfile); //instead of giving file original name you can rename file name with some encryption
```

### code change required areas in resize component
below lines of code you can change as per your requirement and you can review and change wherever changes required as per your requirement
```php
	$path_thumbs_small 	= $_SERVER['DOCUMENT_ROOT'] . $this->request->webroot.'webroot/uploads/small';
	$path_thumbs_medium = $_SERVER['DOCUMENT_ROOT'] . $this->request->webroot.'webroot/uploads/medium';
	$path_thumbs_big 	  =   $_SERVER['DOCUMENT_ROOT'] . $this->request->webroot.'webroot/uploads/big';

	$img_thumb_width_medium = 100; // 
  	$img_thumb_width_big 	= 200; // 
  	$img_thumb_width_small 	= 50; //
```
