Introduction
============

This Bundle provide barcode rendering using our barcode generator base library https://github.com/paterik/BGBarcodeGenerator
supports ImageMagick/GDLib based image rendering, svg and html table drawn output of the following 1D/2D bar codes:

1d barcodes
-----------
* C39 : CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
* C39+ : CODE 39 with checksum
* C39E : CODE 39 EXTENDED
* C39E+ : CODE 39 EXTENDED + CHECKSUM
* C93 : CODE 93 - USS-93
* S25 : Standard 2 of 5
* S25+ : Standard 2 of 5 + CHECKSUM
* I25 : Interleaved 2 of 5
* I25+ : Interleaved 2 of 5 + CHECKSUM
* C128 : CODE 128
* C128A : CODE 128 A
* C128B : CODE 128 B
* C128C : CODE 128 C
* EAN2 : 2-Digits UPC-Based Extention
* EAN5 : 5-Digits UPC-Based Extention
* EAN8 : EAN 8
* EAN13 : EAN 13
* UPCA : UPC-A
* UPCE : UPC-E
* MSI : MSI (Variation of Plessey code)
* MSI+ : MSI + CHECKSUM (modulo 11)
* POSTNET : POSTNET
* PLANET : PLANET
* RMS4CC : RMS4CC (Royal Mail 4-state Customer Code) - CBC (Customer Bar Code)
* KIX : KIX (Klant index - Customer index)
* IMB: Intelligent Mail Barcode - Onecode - USPS-B-3200
* CODABAR : CODABAR
* CODE11 : CODE 11
* PHARMA : PHARMACODE
* PHARMA2T : PHARMACODE TWO-TRACKS

2d barcodes
-----------
* DATAMATRIX : Datamatrix (ISO/IEC 16022)
* PDF417 : PDF417 (ISO/IEC 15438:2006) / a,e,t,s,f,o0,o1,o2,o3,o4,o5,o6
* QRCODE : QRcode Low error correction
* QRCODE, L : QRcode Low error correction
* QRCODE, M : QRcode Medium error correction
* QRCODE, Q : QRcode Better error correction
* QRCODE, H : QR-CODE Best error correction
* QR, RAW : raw mode - comma-separad list of array rows
* QR, RAW2 : raw mode - array rows are surrounded by square parenthesis.


Prerequisites
============

This version requires Symfony 2.1


Installation
============

  1 - Add the following lines in your composer.json:

```
    "require": {
        "bitgrave/barcode-bundle": "dev-master"
    }
```

  2 - Run the composer to download the bundle

```
    $ php composer.phar update bitgrave/barcode-bundle
```

  3 - Add this bundle to your application's kernel:

```
      // app/AppKernel.php
      public function registerBundles()
      {
          return array(
              // ...
              new BG\BarcodeBundle\BarcodeBundle(),
              // ...
          );
      }
```

Usage
=====

  1 - Add the following lines in your controller if you want to use both code types (1d/2d) :

```
use BG\BarcodeBundle\Util\Base1DBarcode as barCode;
use BG\BarcodeBundle\Util\Base2DBarcode as matrixCode;
```

  2 - set the cache path (for image based barcode rendering) call the image- or html renderer including your code and barcode type :

```
 $myBarcode = new barCode();
 $myBarcode->savePath = '/my/temp/media/path';
 $bcPathAbs = $myBarcode->getBarcodePNGPath('501234567890', 'EAN13', 1.75, 45);
 $bcHTMLRaw = $myBarcode->getBarcodeHTML('501234567890', 'EAN13', 1.75, 45);
```

 3 - fetch image by parse $bcPathAbs (absolute path to rendered barcode image) or using this a simple helper method

```
 /**
  * simple cache path returning method (sample cache path: "upload/barcode/cache" )
  *
  * @param bool $public
  *
  * @return string
  *
  */
 protected function getBarcodeCachePath($public = false)
 {

     return (!$public) ? $this->get('kernel')->getRootDir(). '/../web/upload/barcode/cache' : '/upload/barcode/cache';
 }
```

 4 - send public path to your symfony view and put result into your image src path or just render out the alternative table based barcode html structure

```
 $this->render('AcmeDemoBundle:Demo:barcode.html.twig', array(
     'barcodePathAndFile' => $this->getBarcodeCachePath($bcPathAbs),
     'barcodeHTML' => $bcHTMLRaw,
 ));

 // AcmeDemoBundle:Demo:barcode.html.twig
 // ...
 <!-- barcode as image -->
 <img src="{{ barcodePathAndFile }}" alt="barcode" title="my barcode image">
 // ...
 <!-- barcode as table -->
 {{ barcodeHTML|raw }}
 // ...

```


How To Contribute
=================

To contribute changes, fixes, additions/features please open a pull request with your new code.
please take not, that if you add new features or modify existing ones you have to doc this in
projects README file (also update projects CHANGELOG file!)

License
=======

See: resources/meta/LICENSE.md
