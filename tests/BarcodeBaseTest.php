<?php

declare(strict_types=1);

namespace TomasVotruba\BarcodeBundle\Tests;

use PHPUnit\Framework\TestCase;
use TomasVotruba\BarcodeBundle\Base1DBarcode as barCode;
use TomasVotruba\BarcodeBundle\Base2DBarcode as matrixCode;

final class BarcodeBaseTest extends TestCase
{
    /**
     * @var string
     */
    public const C_BC_DEFAULT = '1234567';

    /**
     * @var string
     */
    public const C_BC_EAN2 = '05';

    /**
     * @var string
     */
    public const C_BC_EAN5 = '12345';

    /**
     * @var string
     */
    public const C_BC_EAN8 = '40123455';

    /**
     * @var string
     */
    public const C_BC_EAN13 = '501234567890';

    /**
     * @var string
     */
    public const C_BC_UPCA = '501234567890';

    /**
     * @var string
     */
    public const C_BC_UPCE = '127890';

    /**
     * @var string
     */
    public const C_BC_IS25 = '74380707240152655700';

    /**
     * @var string
     */
    public const C_BC_C128C = '20140200000057';

    /**
     * @var string
     */
    public const C_MC_DEFAULT = 'BGBarcodeBundle';

    /**
     * @var int
     */
    public const C_BC_1D_HEIGHT = 45;

    /**
     * @var int
     */
    public const C_BC_1D_WIDTH = 2;

    /**
     * @var int
     */
    public const C_MC_2D_HEIGHT = 2;

    /**
     * @var int
     */
    public const C_MC_2D_WIDTH = 2;

    /**
     * @var string
     */
    public const C_TMP_PATH = '/tmp/';

    /**
     * gdlib or imagemagic availability check
     */
    public function testImageRenderer(): void
    {
        $this->assertTrue(function_exists('imagecreate') || function_exists('imagick'));
    }

    /**
     * C39 Barcode PNG rendering test
     */
    public function testC39GetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = self::C_TMP_PATH;
        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'C39', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 140);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * C39 Barcode HTML table rendering test
     */
    public function testC39GetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'C39', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 46);
    }

    /**
     * C39E Barcode PNG rendering test
     */
    public function testC39EGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'C39E', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 140);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * C39E Barcode HTML table rendering test
     */
    public function testC39EGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'C39E', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 46);
    }

    /**
     * C39+ Barcode PNG rendering test
     */
    public function testC39PlusGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'C39+', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 150);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * C39+ Barcode HTML table rendering test
     */
    public function testC39PlusGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'C39+', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 51);
    }

    /**
     * C93 Barcode PNG rendering test
     */
    public function testC93PlusGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'C93', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

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
    public function testC93PlusGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'C93', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 35);
    }

    /**
     * S25 Barcode PNG rendering test
     */
    public function testS25GetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'S25', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

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
    public function testS25GetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'S25', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 47);
    }

    /**
     * I25 Barcode PNG rendering test
     */
    public function testI25GetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'I25', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) >= 120);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * I25 Barcode HTML table rendering test
     */
    public function testI25GetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'I25', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 25);
    }

    /**
     * I25+ Barcode PNG rendering test
     */
    public function testI25PlusGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'I25+', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * I25 Barcode HTML table rendering test
     */
    public function testI25PlusGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'I25+', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 25);
    }

    /**
     * C128 (native) Barcode PNG rendering test
     */
    public function testC128GetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'C128', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * C128 (native) Barcode HTML table rendering test
     */
    public function testC128GetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'C128', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 28);
    }

    /**
     * C128 (A) Barcode PNG rendering test
     */
    public function testC128AGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'C128A', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

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
    public function testC128AGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'C128', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 28);
    }

    /**
     * C128 (B) Barcode PNG rendering test
     */
    public function testC128BGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'C128B', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

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
    public function testC128BGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'C128B', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 34);
    }

    /**
     * C128 (C) Barcode PNG rendering test
     */
    public function testC128CGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_C128C, 'C128B', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * C128 (C) Barcode HTML table rendering test
     */
    public function testC128CGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_C128C, 'C128C', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 34);
    }

    /**
     * EAN2 Barcode PNG rendering test
     */
    public function testEAN2GetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_EAN2, 'EAN2', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 100);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * EAN2 Barcode HTML table rendering test
     */
    public function testEAN2GetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_EAN2, 'EAN2', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 8);
    }

    /**
     * EAN5 Barcode PNG rendering test
     */
    public function testEAN5GetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_EAN5, 'EAN5', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 100);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * EAN5 Barcode HTML table rendering test
     */
    public function testEAN5GetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_EAN2, 'EAN5', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 17);
    }

    /**
     * EAN13 Barcode PNG rendering test
     */
    public function testEAN13GetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_EAN5, 'EAN13', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * EAN13 Barcode HTML table rendering test
     */
    public function testEAN13GetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_EAN2, 'EAN13', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 31);
    }

    /**
     * EAN8 Barcode PNG rendering test
     */
    public function testEAN8GetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_EAN5, 'EAN8', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 100);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * EAN8 Barcode HTML table rendering test
     */
    public function testEAN8GetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_EAN2, 'EAN13', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 31);
    }

    /**
     * UPCA Barcode PNG rendering test
     */
    public function testUPCAGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_UPCA, 'UPCA', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * UPCA Barcode HTML table rendering test
     */
    public function testUPCAGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_UPCA, 'UPCA', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 31);
    }

    /**
     * UPCE Barcode PNG rendering test
     */
    public function testUPCEGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_UPCE, 'UPCE', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 100);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * UPCE Barcode HTML table rendering test
     */
    public function testUPCEGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_UPCE, 'UPCE', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 18);
    }

    /**
     * MSI Barcode PNG rendering test
     */
    public function testMSIGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'MSI', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

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
    public function testMSIGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'MSI', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 32);
    }

    /**
     * MSI+ Barcode PNG rendering test
     */
    public function testMSIPlusGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'MSI+', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

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
    public function testMSIPlusGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'MSI+', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 36);
    }

    /**
     * POSTNET Barcode PNG rendering test
     */
    public function testPOSTNETGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'POSTNET', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

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
    public function testPOSTNETGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'POSTNET', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 43);
    }

    /**
     * PLANET Barcode PNG rendering test
     */
    public function testPLANETGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'PLANET', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

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
    public function testPLANETGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'PLANET', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 43);
    }

    /**
     * RMS4CC Barcode PNG rendering test
     */
    public function testRMS4CCGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'RMS4CC', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * RMS4CC Barcode HTML table rendering test
     */
    public function testRMS4CCGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'RMS4CC', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 35);
    }

    /**
     * KIX Barcode PNG rendering test
     */
    public function testKIXGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'KIX', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

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
    public function testKIXGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'KIX', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 29);
    }

    /**
     * IMB Barcode PNG rendering test
     */
    public function testIMBGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'IMB', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

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
    public function testIMBGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'IMB', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 66);
    }

    /**
     * CODABAR Barcode PNG rendering test
     */
    public function testCODABARGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'CODABAR', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * CODABAR Barcode HTML table rendering test
     */
    public function testCODABARGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'CODABAR', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 37);
    }

    /**
     * CODE11 Barcode PNG rendering test
     */
    public function testCODE11GetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'CODE11', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 120);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }

    /**
     * CODE11 Barcode HTML table rendering test
     */
    public function testCODE11GetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'CODE11', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 31);
    }

    /**
     * PHARMA Barcode PNG rendering test
     */
    public function testPHARMAGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'PHARMA', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

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
    public function testPHARMAGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'PHARMA', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 21);
    }

    /**
     * PHARMA2T Barcode PNG rendering test
     */
    public function testPHARMA2TGetBarcodePNGPath(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base1DBarcode->getBarcodePNGPath(self::C_BC_DEFAULT, 'PHARMA2T', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);

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
    public function testPHARMA2TGetBarcodeHTMLRaw(): void
    {
        $base1DBarcode = new barCode();
        $base1DBarcode->savePath = '/tmp/';

        $bcHTMLRaw = $base1DBarcode->getBarcodeHTML(self::C_BC_DEFAULT, 'PHARMA2T', self::C_BC_1D_WIDTH, self::C_BC_1D_HEIGHT);
        $bcCheckArray = explode('background-color:black', $bcHTMLRaw);

        $this->assertTrue(count($bcCheckArray) === 14);
    }

    /**
     * DATAMATRIX 2D Matrix-Code PNG rendering test
     */
    public function testDATAMATRIXGetBarcodePNGPath(): void
    {
        $base2DBarcode = new matrixCode();
        $base2DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base2DBarcode->getBarcodePNGPath(self::C_MC_DEFAULT, 'datamatrix', self::C_MC_2D_WIDTH, self::C_MC_2D_HEIGHT);

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
    public function testQRCODEGetBarcodePNGPath(): void
    {
        $base2DBarcode = new matrixCode();
        $base2DBarcode->savePath = '/tmp/';

        $bcPathAbs = $base2DBarcode->getBarcodePNGPath(self::C_MC_DEFAULT, 'qrcode', self::C_MC_2D_WIDTH, self::C_MC_2D_HEIGHT);

        if (function_exists('imagecreate')) {
            $checkCondition = (file_exists($bcPathAbs)) && (filesize($bcPathAbs) > 200 && filesize($bcPathAbs) < 255);
        } else {
            $checkCondition = file_exists($bcPathAbs);
        }

        unlink($bcPathAbs);

        $this->assertTrue($checkCondition);
    }
};
