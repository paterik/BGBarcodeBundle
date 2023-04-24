<?php

declare(strict_types=1);

namespace TomasVotruba\BarcodeBundle;

use TomasVotruba\BarcodeBundle\Plugins\datamatrix as Datamatrix;
use TomasVotruba\BarcodeBundle\Plugins\pdf417 as PDF417;
use TomasVotruba\BarcodeBundle\Plugins\qrcode as QRcode;

final class Base2DBarcode
{
    /**
     * Array representation of barcode
     */
    private $barcodeArray = [];

    /**
     * path to save png in getBarcodePNGPath
     * @var string
     */
    public $savePath;

    /**
     * Return an array representations of barcode.
     * @return array
     */
    public function getBarcodeArray()
    {
        return $this->barcodeArray;
    }

    /**
     * setup temporary path for barcode cache
     *
     * @param string $serverPath
     *
     * @throws \Exception
     */
    public function setTempPath($serverPath)
    {
        try {
            if (! file_exists($serverPath)) {
                mkdir($serverPath, 0770, true);
            }
        } catch (\Exception $exception) {
            throw new \Exception("An error occurred while creating barcode cache directory at " . $serverPath, $exception->getCode(), $exception);
        }
    }

    public function getBarcodeSVG(string $code, string $type, int $w = 3, int $h = 3, string $color = 'black'): void
    {
        //set barcode code and type
        $this->setBarcode($code, $type);
        // send headers
        $code = $this->getBarcodeSVGcode($w, $h, $color);
        header('Content-Type: application/svg+xml');
        header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
        header('Pragma: public');
        header('Expires: Sat, 12 Nov 1977 23:50:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Content-Disposition: inline; filename="' . md5($code) . '.svg";');
        //header('Content-Length: '.strlen($code));
        echo $code;
    }

    /**
     * Return a SVG string representation of barcode.
     */
    public function getBarcodeSVGcode(string $code, string $type, int $w = 3, int $h = 3, string $color = 'black'): string
    {
        //set barcode code and type
        $this->setBarcode($code, $type);
        // replace table for special characters
        $repstr = [
            "\0" => '',
            '&' => '&amp;',
            '<' => '&lt;',
            '>' => '&gt;',
        ];
        $svg = '<' . '?' . 'xml version="1.0" standalone="no"' . '?' . '>' . "\n";
        $svg .= '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">' . "\n";
        $svg .= '<svg width="' . round(($this->barcodeArray['num_cols'] * $w), 3) . '" height="' . round(($this->barcodeArray['num_rows'] * $h), 3) . '" version="1.1" xmlns="http://www.w3.org/2000/svg">' . "\n";
        $svg .= "\t" . '<desc>' . strtr($this->barcodeArray['code'], $repstr) . '</desc>' . "\n";
        $svg .= "\t" . '<g id="elements" fill="' . $color . '" stroke="none">' . "\n";
        // print barcode elements
        $y = 0;
        // for each row
        for ($r = 0; $r < $this->barcodeArray['num_rows']; ++$r) {
            $x = 0;
            // for each column
            for ($c = 0; $c < $this->barcodeArray['num_cols']; ++$c) {
                if ($this->barcodeArray['bcode'][$r][$c] == 1) {
                    // draw a single barcode cell
                    $svg .= "\t\t" . '<rect x="' . $x . '" y="' . $y . '" width="' . $w . '" height="' . $h . '" />' . "\n";
                }

                $x += $w;
            }

            $y += $h;
        }

        $svg .= "\t" . '</g>' . "\n";

        return $svg . ('</svg>' . "\n");
    }

    /**
     * Return an HTML representation of barcode.
     *
     * @param string $type
     * @param int    $w
     * @param int    $h
     * @param string $color
     */
    public function getBarcodeHTML(string $code, $type, $w = 10, $h = 10, $color = 'black'): string
    {
        //set barcode code and type
        $this->setBarcode($code, $type);
        $html = '<div style="font-size:0;position:relative;width:' . ($w * $this->barcodeArray['num_cols']) . 'px;height:' . ($h * $this->barcodeArray['num_rows']) . 'px;">' . "\n";
        // print barcode elements
        $y = 0;
        // for each row
        for ($r = 0; $r < $this->barcodeArray['num_rows']; ++$r) {
            $x = 0;
            // for each column
            for ($c = 0; $c < $this->barcodeArray['num_cols']; ++$c) {
                if ($this->barcodeArray['bcode'][$r][$c] == 1) {
                    // draw a single barcode cell
                    $html .= '<div style="background-color:' . $color . ';width:' . $w . 'px;height:' . $h . 'px;position:absolute;left:' . $x . 'px;top:' . $y . 'px;">&nbsp;</div>' . "\n";
                }

                $x += $w;
            }

            $y += $h;
        }

        return $html . ('</div>' . "\n");
    }

    /**
     * Return a PNG image representation of barcode (requires GD or Imagick library).
     *
     * @param string $type
     * @param int    $w
     * @param int    $h
     * @param array  $color
     */
    public function getBarcodePNG(string $code, $type, $w = 3, $h = 3, $color = [0, 0, 0]): bool
    {
        //set barcode code and type
        $this->setBarcode($code, $type);
        $bar = null;

        // calculate image size
        $width = ($this->barcodeArray['num_cols'] * $w);
        $height = ($this->barcodeArray['num_rows'] * $h);
        if (function_exists('imagecreate')) {
            // GD library
            $imagick = false;
            $png = imagecreate($width, $height);
            $bgcol = imagecolorallocate($png, 255, 255, 255);
            imagecolortransparent($png, $bgcol);
            $fgcol = imagecolorallocate($png, $color[0], $color[1], $color[2]);
        } elseif (extension_loaded('imagick')) {
            $imagick = true;
            $fgcol = new \imagickpixel('rgb(' . $color[0] . ',' . $color[1] . ',' . $color[2] . ')');
            $png = new \Imagick();
            $png->newImage($width, $height, 'none', 'png');
        } else {
            return false;
        }

        // print barcode elements
        $y = 0;
        // for each row
        for ($r = 0; $r < $this->barcodeArray['num_rows']; ++$r) {
            $x = 0;
            // for each column
            for ($c = 0; $c < $this->barcodeArray['num_cols']; ++$c) {
                if ($this->barcodeArray['bcode'][$r][$c] == 1) {
                    // draw a single barcode cell
                    if ($imagick) {
                        $bar = new \imagickdraw();
                        $bar->setfillcolor($fgcol);
                        $bar->rectangle($x, $y, ($x + $w), ($y + $h));
                    } else {
                        imagefilledrectangle($png, $x, $y, ($x + $w), ($y + $h), $fgcol);
                    }
                }

                $x += $w;
            }

            $y += $h;
        }

        // send headers
        header('Content-Type: image/png');
        header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
        header('Pragma: public');
        header('Expires: Sat, 12 Nov 1977 23:50:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        if ($imagick) {
            $png->drawimage($bar);
            echo $png;
        } else {
            imagepng($png);
            imagedestroy($png);
        }

        return true;
    }

    /**
     * return filename from give path
     *
     * @param string $path
     *
     * @todo: refactor this, move method in some kind of utility class
     *
     * @return mixed
     */
    public function getBarcodeFilenameFromGenPath($path)
    {
        $bcPathArr = explode('/', $path);

        return $bcPathArr[count($bcPathArr) - 1];
    }

    /**
     * Return a .png file path which create in server
     *
     * @param string $code
     * @param string $type
     * @param int    $w
     * @param int    $h
     * @param array  $color
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function getBarcodePNGPath($code, $type, $w = 3, $h = 3, $color = [0, 0, 0], $filename = null)
    {
        if (is_null($filename)) {
            $filename = $type . '_' . $code;
        }

        //set barcode code and type
        $this->setBarcode($code, $type);
        $bar = null;

        if (empty($this->barcodeArray) || (! $this->barcodeArray)) {
            throw new \Exception('It not possible to generate barcode of type: ' . $type . ' for number/code: ' . $code . '! May be this is an invalid code pattern!');
        }

        // calculate image size
        $width = ($this->barcodeArray['num_cols'] * $w);
        $height = ($this->barcodeArray['num_rows'] * $h);

        $width = (int) $width;
        $height = (int) $height;

        if (function_exists('imagecreate')) {
            // GD library
            $imagick = false;
            $png = imagecreate($width, $height);
            $bgcol = imagecolorallocate($png, 255, 255, 255);
            imagecolortransparent($png, $bgcol);
            $fgcol = imagecolorallocate($png, $color[0], $color[1], $color[2]);
        } elseif (extension_loaded('imagick')) {
            $imagick = true;
            $fgcol = new \imagickpixel('rgb(' . $color[0] . ',' . $color[1] . ',' . $color[2] . ')');
            $png = new \Imagick();
            $png->newImage($width, $height, 'none', 'png');
        } else {
            return false;
        }

        // print barcode elements
        $y = 0;
        // for each row
        for ($r = 0; $r < $this->barcodeArray['num_rows']; ++$r) {
            $x = 0;
            // for each column
            for ($c = 0; $c < $this->barcodeArray['num_cols']; ++$c) {
                if ($this->barcodeArray['bcode'][$r][$c] == 1) {
                    // draw a single barcode cell
                    if ($imagick) {
                        $bar = new \imagickdraw();
                        $bar->setfillcolor($fgcol);
                        $bar->rectangle($x, $y, ($x + $w - 1), ($y + $h - 1));
                    } else {
                        imagefilledrectangle($png, $x, $y, $x + $w - 1, $y + $h - 1, $fgcol);
                    }
                }

                $x += $w;
            }

            $y += $h;
        }

        $this->setTempPath($this->savePath);
        $saveFile = $this->checkfile($this->savePath . $filename . '.png', true);

        if ($imagick) {
            $png->drawimage($bar);
        }

        if (imagepng($png, $saveFile)) {
            imagedestroy($png);

            return $saveFile;
        } else {
            imagedestroy($png);
            throw new \Exception('It not possible to write barcode cache file to path ' . $this->savePath);
        }
    }

    /**
     * Set the barcode.
     * @param string $type
     */
    public function setBarcode(string $code, $type): void
    {
        $mode = explode(',', $type);
        $qrtype = strtoupper($mode[0]);

        switch ($qrtype) {
            case 'DATAMATRIX': // DATAMATRIX (ISO/IEC 16022)
                $qrcode = new Datamatrix($code);
                $this->barcodeArray = $qrcode->getBarcodeArray();
                $this->barcodeArray['code'] = $code;
                break;

            case 'PDF417': // PDF417 (ISO/IEC 15438:2006)
                if (! isset($mode[1]) || ($mode[1] === '')) {
                    $aspectratio = 2; // default aspect ratio (width / height)
                } else {
                    $aspectratio = (float) $mode[1];
                }

                if (! isset($mode[2]) || ($mode[2] === '')) {
                    $ecl = -1; // default error correction level (auto)
                } else {
                    $ecl = (int) $mode[2];
                }

                // set macro block
                $macro = [];
                if (isset($mode[3]) && ($mode[3] !== '') && isset($mode[4]) && ($mode[4] !== '') && isset($mode[5]) && ($mode[5] !== '')) {
                    $macro['segment_total'] = (int) $mode[3];
                    $macro['segment_index'] = (int) $mode[4];
                    $macro['file_id'] = strtr($mode[5], "\xff", ',');
                    for ($i = 0; $i < 7; ++$i) {
                        $o = $i + 6;
                        if (isset($mode[$o]) && ($mode[$o] !== '')) {
                            // add option
                            $macro['option_' . $i] = strtr($mode[$o], "\xff", ',');
                        }
                    }
                }

                $qrcode = new PDF417($code, $ecl, $aspectratio, $macro);
                $this->barcodeArray = $qrcode->getBarcodeArray();
                $this->barcodeArray['code'] = $code;
                break;

            case 'QRCODE': // QR-CODE
                if (! isset($mode[1]) || (! in_array($mode[1], ['L', 'M', 'Q', 'H']))) {
                    $mode[1] = 'L'; // Ddefault: Low error correction
                }

                $qrcode = new QRcode($code, strtoupper($mode[1]));
                $this->barcodeArray = $qrcode->getBarcodeArray();
                $this->barcodeArray['code'] = $code;
                break;

            case 'RAW':
            case 'RAW2': // RAW MODE
                // remove spaces
                $code = preg_replace('#[\s]*#si', '', $code);
                if (strlen($code) < 3) {
                    break;
                }

                if ($qrtype == 'RAW') {
                    // comma-separated rows
                    $rows = explode(',', $code);
                } else {
                    // rows enclosed in square parentheses
                    $code = substr($code, 1, -1);
                    $rows = explode('][', $code);
                }

                $this->barcodeArray['num_rows'] = count($rows);
                $this->barcodeArray['num_cols'] = strlen($rows[0]);
                $this->barcodeArray['bcode'] = [];
                foreach ($rows as $row) {
                    $this->barcodeArray['bcode'][] = str_split($row, 1);
                }

                $this->barcodeArray['code'] = $code;
                break;

            default:
                $this->barcodeArray = false;
                break;
        }
    }

    /**
     * unlink old barcode image file or optional rand prefix file
     *
     * @param string $path
     * @param bool   $overwrite
     *
     * @return mixed
     */
    public function checkfile($path, $overwrite)
    {
        if (file_exists($path)) {
            if (! $overwrite) {
                $baseName = pathinfo($path, PATHINFO_BASENAME);

                return $this->checkfile(str_replace($baseName, random_int(0, 9999) . $baseName, $path), $overwrite);
            } else {
                unlink($path);
            }
        }

        return $path;
    }
}
