<?php

declare(strict_types=1);

namespace TomasVotruba\BarcodeBundle\Tests;

use TomasVotruba\BarcodeBundle\Base1DBarcode as barCode;
use TomasVotruba\BarcodeBundle\Base2DBarcode as matrixCode;
use PHPUnit\Framework\TestCase;

final class BarcodeBaseTest extends TestCase
{
    public const C_BC_DEFAULT = '1234567';

    public const C_BC_EAN2 = '05';

    public const C_BC_EAN5 = '12345';

    public const C_BC_EAN8 = '40123455';

    public const C_BC_EAN13 = '501234567890';

    public const C_BC_UPCA = '501234567890';

    public const C_BC_UPCE = '127890';

    public const C_BC_IS25 = '74380707240152655700';

    public const C_BC_C128C = '20140200000057';

    public const C_MC_DEFAULT = 'BGBarcodeBundle';

    public const C_BC_1D_HEIGHT = 45;

    public const C_BC_1D_WIDTH = 2;

    public const C_MC_2D_HEIGHT = 2;

    public const C_MC_2D_WIDTH = 2;

    public const C_TMP_PATH = '/tmp/';

    /**
     * gdlib or imagemagic availability check
     */
    public function testImageRenderer()
    {
        $this->assertTrue(function_exists('imagecreate') || function_exists('imagick'));
    }

    /**
     * C39 Barcode PNG rendering test
     */
    public function testC39GetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = self::C_TMP_PATH;
        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'C39', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 140);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * C39 Barcode HTML table rendering test
     */
    public function testC39GetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'C39', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 46);
    }

    /**
     * C39E Barcode PNG rendering test
     */
    public function testC39EGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'C39E', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 140);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * C39E Barcode HTML table rendering test
     */
    public function testC39EGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'C39E', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 46);
    }

    /**
     * C39+ Barcode PNG rendering test
     */
    public function testC39PlusGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'C39+', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 150);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * C39+ Barcode HTML table rendering test
     */
    public function testC39PlusGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'C39+', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 51);
    }

    /**
     * C93 Barcode PNG rendering test
     */
    public function testC93PlusGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'C93', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * C39+ Barcode HTML table rendering test
     */
    public function testC93PlusGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'C93', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 35);
    }

    /**
     * S25 Barcode PNG rendering test
     */
    public function testS25GetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'S25', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 130);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * C39+ Barcode HTML table rendering test
     */
    public function testS25GetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'S25', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 47);
    }

    /**
     * I25 Barcode PNG rendering test
     */
    public function testI25GetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'I25', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) >= 120);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * I25 Barcode HTML table rendering test
     */
    public function testI25GetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'I25', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 25);
    }

    /**
     * I25+ Barcode PNG rendering test
     */
    public function testI25PlusGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'I25+', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * I25 Barcode HTML table rendering test
     */
    public function testI25PlusGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'I25+', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 25);
    }

    /**
     * C128 (native) Barcode PNG rendering test
     */
    public function testC128GetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'C128', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * C128 (native) Barcode HTML table rendering test
     */
    public function testC128GetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'C128', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 28);
    }

    /**
     * C128 (A) Barcode PNG rendering test
     */
    public function testC128AGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'C128A', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 130);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * C128 (A) Barcode HTML table rendering test
     */
    public function testC128AGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'C128', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 28);
    }

    /**
     * C128 (B) Barcode PNG rendering test
     */
    public function testC128BGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'C128B', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 130);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * C128 (B) Barcode HTML table rendering test
     */
    public function testC128BGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'C128B', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 34);
    }

    /**
     * C128 (C) Barcode PNG rendering test
     */
    public function testC128CGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_C128C, 'C128B', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * C128 (C) Barcode HTML table rendering test
     */
    public function testC128CGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_C128C, 'C128C', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 34);
    }

    /**
     * EAN2 Barcode PNG rendering test
     */
    public function testEAN2GetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_EAN2, 'EAN2', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 100);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * EAN2 Barcode HTML table rendering test
     */
    public function testEAN2GetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_EAN2, 'EAN2', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 8);
    }

    /**
     * EAN5 Barcode PNG rendering test
     */
    public function testEAN5GetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_EAN5, 'EAN5', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 100);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * EAN5 Barcode HTML table rendering test
     */
    public function testEAN5GetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_EAN2, 'EAN5', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 17);
    }

    /**
     * EAN13 Barcode PNG rendering test
     */
    public function testEAN13GetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_EAN5, 'EAN13', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * EAN13 Barcode HTML table rendering test
     */
    public function testEAN13GetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_EAN2, 'EAN13', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 31);
    }

    /**
     * EAN8 Barcode PNG rendering test
     */
    public function testEAN8GetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_EAN5, 'EAN8', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 100);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * EAN8 Barcode HTML table rendering test
     */
    public function testEAN8GetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_EAN2, 'EAN13', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 31);
    }

    /**
     * UPCA Barcode PNG rendering test
     */
    public function testUPCAGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_UPCA, 'UPCA', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * UPCA Barcode HTML table rendering test
     */
    public function testUPCAGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_UPCA, 'UPCA', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 31);
    }

    /**
     * UPCE Barcode PNG rendering test
     */
    public function testUPCEGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_UPCE, 'UPCE', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 100);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * UPCE Barcode HTML table rendering test
     */
    public function testUPCEGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_UPCE, 'UPCE', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 18);
    }

    /**
     * MSI Barcode PNG rendering test
     */
    public function testMSIGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'MSI', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * UPCE Barcode HTML table rendering test
     */
    public function testMSIGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'MSI', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 32);
    }

    /**
     * MSI+ Barcode PNG rendering test
     */
    public function testMSIPlusGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'MSI+', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 130);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * MSI+ Barcode HTML table rendering test
     */
    public function testMSIPlusGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'MSI+', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 36);
    }

    /**
     * POSTNET Barcode PNG rendering test
     */
    public function testPOSTNETGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'POSTNET', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 130);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * POSTNET Barcode HTML table rendering test
     */
    public function testPOSTNETGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'POSTNET', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 43);
    }

    /**
     * PLANET Barcode PNG rendering test
     */
    public function testPLANETGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'PLANET', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 130);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * PLANET Barcode HTML table rendering test
     */
    public function testPLANETGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'PLANET', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 43);
    }

    /**
     * RMS4CC Barcode PNG rendering test
     */
    public function testRMS4CCGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'RMS4CC', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * RMS4CC Barcode HTML table rendering test
     */
    public function testRMS4CCGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'RMS4CC', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 35);
    }

    /**
     * KIX Barcode PNG rendering test
     */
    public function testKIXGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'KIX', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 130);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * KIX Barcode HTML table rendering test
     */
    public function testKIXGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'KIX', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 29);
    }

    /**
     * IMB Barcode PNG rendering test
     */
    public function testIMBGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'IMB', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 160);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * IMB Barcode HTML table rendering test
     */
    public function testIMBGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'IMB', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 66);
    }

    /**
     * CODABAR Barcode PNG rendering test
     */
    public function testCODABARGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'CODABAR', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * CODABAR Barcode HTML table rendering test
     */
    public function testCODABARGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'CODABAR', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 37);
    }

    /**
     * CODE11 Barcode PNG rendering test
     */
    public function testCODE11GetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'CODE11', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = (file_exists($bcPathAbs)) ? true : false;
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * CODE11 Barcode HTML table rendering test
     */
    public function testCODE11GetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'CODE11', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 31);
    }

    /**
     * PHARMA Barcode PNG rendering test
     */
    public function testPHARMAGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'PHARMA', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * PHARMA Barcode HTML table rendering test
     */
    public function testPHARMAGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'PHARMA', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 21);
    }

    /**
     * PHARMA2T Barcode PNG rendering test
     */
    public function testPHARMA2TGetBarcodePNGPath()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcPathAbs = $d1->getBarcodePNGPath(self::C_BC_DEFAULT, 'PHARMA2T', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 110);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * PHARMA2T Barcode HTML table rendering test
     */
    public function testPHARMA2TGetBarcodeHTMLRaw()
    {
        $d1 = new barCode();
        $d1->savePath = '/tmp/';

        $bcHTMLRaw = $d1->getBarcodeHTML(self::C_BC_DEFAULT, 'PHARMA2T', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 14);
    }

    /**
     * DATAMATRIX 2D Matrix-Code PNG rendering test
     */
    public function testDATAMATRIXGetBarcodePNGPath()
    {
        $d2 = new matrixCode();
        $d2->savePath = '/tmp/';

        $bcPathAbs = $d2->getBarcodePNGPath(self::C_MC_DEFAULT, 'datamatrix', self::C_MC_2D_WIDTH, self::C_MC_2D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 100);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * QRCode 2D Matrix-Code PNG rendering test
     */
    public function testQRCODEGetBarcodePNGPath()
    {
        $d2 = new matrixCode();
        $d2->savePath = '/tmp/';

        $bcPathAbs = $d2->getBarcodePNGPath(self::C_MC_DEFAULT, 'qrcode', self::C_MC_2D_WIDTH, self::C_MC_2D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 200 && filesize($bcPathAbs) < 255);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }
};
