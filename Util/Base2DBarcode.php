<?php

/*
 * This file is part of the bitgrave barcode library based on forked version of Dinesh Rabara 2D-3D Barcode
 * Generator class/lib (https://github.com/dineshrabara/2D-3D-Barcodes-Generator)
 *
 * BGBarcodeGenerator-1.0.1
 * master/dev branch: https://github.com/paterik/BGBarcodeGenerator
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BG\BarcodeBundle\Util;

use BG\BarcodeBundle\Util\Plugins\pdf417 as PDF417,
    BG\BarcodeBundle\Util\Plugins\datamatrix as Datamatrix,
    BG\BarcodeBundle\Util\Plugins\qrcode as QRcode;

/**
 * class Base2DBarcode 1.0.1
 *
 * @author Dinesh Rabara <dinesh.rabara@gmail.com>
 * @author Patrick Paechnatz <patrick.paechnatz@gmail.com>
 */
class Base2DBarcode
{
    /**
     * Array representation of barcode.
     * @protected
     */
    protected $barcodeArray = false;
    /**
     * path to save png in getBarcodePNGPath
     * @var <type>
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
            if (!file_exists($serverPath)) {
                mkdir($serverPath, 0770, true);
            }
        } catch (\Exception $e) {
            throw new \Exception("An error occurred while creating barcode cache directory at " . $serverPath);
        }
    }

    /**
     * get svg brcode (header stream)
     *
     * @param string $code
     * @param string $type
     * @param int    $w
     * @param int    $h
     * @param string $color
     */
    public function getBarcodeSVG($code, $type, $w=3, $h=3, $color='black')
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
     *
     * @param string $code
     * @param string $type
     * @param int    $w
     * @param int    $h
     * @param string $color
     *
     * @return string
     */
    public function getBarcodeSVGcode($code, $type, $w=3, $h=3, $color='black')
    {
        //set barcode code and type
        $this->setBarcode($code, $type);
        // replace table for special characters
        $repstr = array("\0" => '', '&' => '&amp;', '<' => '&lt;', '>' => '&gt;');
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
        $svg .= '</svg>' . "\n";

        return $svg;
    }

    /**
     * Return an HTML representation of barcode.
     *
     * @param string $code
     * @param string $type
     * @param int    $w
     * @param int    $h
     * @param string $color
     *
     * @return string
     */
    public function getBarcodeHTML($code, $type, $w=10, $h=10, $color='black')
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
        $html .= '</div>' . "\n";

        return $html;
    }

    /**
     * Return a PNG image representation of barcode (requires GD or Imagick library).
     *
     * @param string $code
     * @param string $type
     * @param int    $w
     * @param int    $h
     * @param array  $color
     *
     * @return bool
     */
    public function getBarcodePNG($code, $type, $w=3, $h=3, $color=array(0, 0, 0))
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

        return $bcPathArr[count($bcPathArr)-1];
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
    public function getBarcodePNGPath($code, $type, $w=3, $h=3, $color=array(0, 0, 0))
    {
        //set barcode code and type
        $this->setBarcode($code, $type);
        $bar = null;

        if (empty($this->barcodeArray) || (!$this->barcodeArray)) {
            throw new \Exception('It not possible to generate barcode of type: '.$type.' for number/code: '.$code.'! May be this is an invalid code pattern!');
        }

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
                        $bar->rectangle($x, $y, ($x + $w - 1), ($y + $h - 1));
                    } else {
                        imagefilledrectangle($png, $x, $y, ($x + $w - 1), ($y + $h - 1), $fgcol);
                    }
                }
                $x += $w;
            }
            $y += $h;
        }

        $nType = str_replace('+', 'PLUS', $type);

        $this->setTempPath($this->savePath);
        $saveFile = $this->checkfile($this->savePath . $nType . '_' . $code . '.png', true);

        if ($imagick) {
            $png->drawimage($bar);
            //echo $png;
        }
        // ImagePng : weazL
        if (imagepng($png, $saveFile)) {
            imagedestroy($png);

            return $saveFile;
        } else {
            imagedestroy($png);
            throw new \Exception('It not possible to write barcode cache file to path '.$this->savePath);
        }
    }

    /**
     * Set the barcode.
     *
     * @param string $code
     * @param string $type
     */
    public function setBarcode($code, $type)
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
                if (!isset($mode[1]) || ($mode[1] === '')) {
                    $aspectratio = 2; // default aspect ratio (width / height)
                } else {
                    $aspectratio = floatval($mode[1]);
                }
                if (!isset($mode[2]) || ($mode[2] === '')) {
                    $ecl = -1; // default error correction level (auto)
                } else {
                    $ecl = intval($mode[2]);
                }
                // set macro block
                $macro = array();
                if (isset($mode[3]) && ($mode[3] !== '') && isset($mode[4]) && ($mode[4] !== '') && isset($mode[5]) && ($mode[5] !== '')) {
                    $macro['segment_total'] = intval($mode[3]);
                    $macro['segment_index'] = intval($mode[4]);
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
                if (!isset($mode[1]) || (!in_array($mode[1], array('L', 'M', 'Q', 'H')))) {
                    $mode[1] = 'L'; // Ddefault: Low error correction
                }
                $qrcode = new QRcode($code, strtoupper($mode[1]));
                $this->barcodeArray = $qrcode->getBarcodeArray();
                $this->barcodeArray['code'] = $code;
                break;

            case 'RAW':
            case 'RAW2': // RAW MODE
                // remove spaces
                $code = preg_replace('/[\s]*/si', '', $code);
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
                $this->barcodeArray['bcode'] = array();
                foreach ($rows as $r) {
                    $this->barcodeArray['bcode'][] = str_split($r, 1);
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

            if (!$overwrite) {
                $baseName = pathinfo($path, PATHINFO_BASENAME);

                return $this->checkfile(str_replace($baseName, rand(0, 9999) . $baseName, $path), $overwrite);

            } else {

                unlink($path);

            }
        }

        return $path;
    }
}