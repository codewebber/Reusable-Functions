# PDF implementation using cakephp3

# Installtion 

prerequisites : composer need to install in your project folder

check whether composer installed in your project folder or not  : 
```php
php composer.phar

if composer not installed then

curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

## if composer installed properly then follow below command for installation of cakepdf
```php
php composer.phar require friendsofcake/cakepdf
```
cakepdf is base class for pdf functionality,doest not include any pdf engines again we need to install required pdf engines

```php
Current Engines supported by cakepdf are
1.DomPdf
2.Mpdf
3.Tcpdf
4.WkHtmlToPdf

```
## installation of pdf engines we can pick any one for explaining purpose using tcpdf engine
composer require dompdf/dompdf
composer require tecnickcom/tcpdf
composer require mpdf/mpdf
http://wkhtmltopdf.org/ (direcly we can download)

## After installation setup
In config/bootstrap.php add:
```php
Plugin::load('CakePdf', ['bootstrap' => true]);
```

## App Controller
```php
public function initialize()
    {
        parent::initialize();
        Configure::write('CakePdf', [
        'engine' => 'CakePdf.Tcpdf',
        'margin' => [
            'bottom' => 15,
            'left' => 50,
            'right' => 30,
            'top' => 45
        ],
        'orientation' => 'landscape',
        'download' => true
    ]);
```

## Particular Controller(simple pdf download)
```php
public function view($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => []
        ]);
          $this->viewBuilder()->options([
                'pdfConfig' => [
                    'orientation' => 'portrait',
                    'filename' => 'Posts_' . $id.'.pdf'
                ]
            ]);
        $this->set('post', $post);
        //$this->set('_serialize', ['post']);
    }
```
*Note : create view.ctp  file path :src/Template/Invoices/pdf/view.ctp and 
             default.ctp path:src/Template/Layout/pdf/default.ctp (Please check attached files for reference)

## pdf download + save in particular folder in our project

```php
    public function examplePdf()
    {
       $this->autoRender = false;
       $posts = $this->Posts->find('all')->toArray();
       $this->set(compact('posts'));
       $targetPath = $_SERVER['DOCUMENT_ROOT'] . $this->request->webroot.'webroot/uploads/';
       $this->set(compact('targetPath'));

       $CakePdf = new \CakePdf\Pdf\CakePdf();
       $string = strtotime(date('Y-m-d H:i:s'));
       $CakePdf->template('samplepost', 'default');
       $CakePdf->viewVars($this->viewVars);
       //Get the PDF string returned
       $pdf = $CakePdf->output();
       // Or write it to file directly
       $pdf = $CakePdf->write($targetPath. 'newsletter_'.$string.'.pdf');
    }
```

## Explanation :
```php
$this->autoRender = false; this line is required otherwise 2 view pages will render (one is for download and one is for upload) 
$this->loadComponent('RequestHandler'); this comoponet is required
in this example we need to create some template file for upload 
Path : src/Template/Pdf/samplepost.ctp
Layout Path : src/Template/Layout/pdf/default.ctp
in above code we render like this $CakePdf->template('samplepost', 'default');
we can write our html code in samplepost.ctp it will convert as pdf file and automatically upload to defined folder

```






