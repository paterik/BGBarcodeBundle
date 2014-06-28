<?php

/*
 * This file is part of the bitgrave barcode library based on forked version of Dinesh Rabara 2D-3D Barcode
 * Generator class/lib (https://github.com/dineshrabara/2D-3D-Barcodes-Generator)
 *
 * BGBarcodeGenerator-1.0.0
 * master/dev branch: https://github.com/paterik/BGBarcodeGenerator
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BG\Barcode\Modules;

/**
 * class Datamatrix 1.0.0
 * two-dimensional matrix bar code (requires PHP bcmath extension)
 *
 * @author Dinesh Rabara, https://github.com/dineshrabara
 * @author Patrick Paechnatz, https://github.com/paterik
 */
class Datamatrix
{
    const

        DATAMATRIXDEFS = true,
        ENC_ASCII = 0, // ASCII encoding: ASCII character 0 to 127 (1 byte per CW)
        ENC_C40 = 1, // C40 encoding: Upper-case alphanumeric (3/2 bytes per CW)
        ENC_TXT = 2, // TEXT encoding: Lower-case alphanumeric (3/2 bytes per CW)
        ENC_X12 = 3, // X12 encoding: ANSI X12 (3/2 byte per CW)
        ENC_EDF = 4, // EDIFACT encoding: ASCII character 32 to 94 (4/3 bytes per CW)
        ENC_BASE256 = 5, // BASE 256 encoding: ASCII character 0 to 255 (1 byte per CW)
        ENC_ASCII_EXT = 6, // ASCII extended encoding: ASCII character 128 to 255 (1/2 byte per CW)
        ENC_ASCII_NUM = 7; // ASCII number encoding: ASCII digits (2 bytes per CW)

    protected $barcodeArray = array();

    protected $lastEnc = self::ENC_ASCII;

    protected $symbattr = array(
        array(0x00a,0x00a,0x008,0x008,0x00a,0x00a,0x008,0x008,0x001,0x001,0x001,0x003,0x005,0x001,0x003,0x005), // 10x10
        array(0x00c,0x00c,0x00a,0x00a,0x00c,0x00c,0x00a,0x00a,0x001,0x001,0x001,0x005,0x007,0x001,0x005,0x007), // 12x12
        array(0x00e,0x00e,0x00c,0x00c,0x00e,0x00e,0x00c,0x00c,0x001,0x001,0x001,0x008,0x00a,0x001,0x008,0x00a), // 14x14
        array(0x010,0x010,0x00e,0x00e,0x010,0x010,0x00e,0x00e,0x001,0x001,0x001,0x00c,0x00c,0x001,0x00c,0x00c), // 16x16
        array(0x012,0x012,0x010,0x010,0x012,0x012,0x010,0x010,0x001,0x001,0x001,0x012,0x00e,0x001,0x012,0x00e), // 18x18
        array(0x014,0x014,0x012,0x012,0x014,0x014,0x012,0x012,0x001,0x001,0x001,0x016,0x012,0x001,0x016,0x012), // 20x20
        array(0x016,0x016,0x014,0x014,0x016,0x016,0x014,0x014,0x001,0x001,0x001,0x01e,0x014,0x001,0x01e,0x014), // 22x22
        array(0x018,0x018,0x016,0x016,0x018,0x018,0x016,0x016,0x001,0x001,0x001,0x024,0x018,0x001,0x024,0x018), // 24x24
        array(0x01a,0x01a,0x018,0x018,0x01a,0x01a,0x018,0x018,0x001,0x001,0x001,0x02c,0x01c,0x001,0x02c,0x01c), // 26x26
        array(0x020,0x020,0x01c,0x01c,0x010,0x010,0x00e,0x00e,0x002,0x002,0x004,0x03e,0x024,0x001,0x03e,0x024), // 32x32
        array(0x024,0x024,0x020,0x020,0x012,0x012,0x010,0x010,0x002,0x002,0x004,0x056,0x02a,0x001,0x056,0x02a), // 36x36
        array(0x028,0x028,0x024,0x024,0x014,0x014,0x012,0x012,0x002,0x002,0x004,0x072,0x030,0x001,0x072,0x030), // 40x40
        array(0x02c,0x02c,0x028,0x028,0x016,0x016,0x014,0x014,0x002,0x002,0x004,0x090,0x038,0x001,0x090,0x038), // 44x44
        array(0x030,0x030,0x02c,0x02c,0x018,0x018,0x016,0x016,0x002,0x002,0x004,0x0ae,0x044,0x001,0x0ae,0x044), // 48x48
        array(0x034,0x034,0x030,0x030,0x01a,0x01a,0x018,0x018,0x002,0x002,0x004,0x0cc,0x054,0x002,0x066,0x02a), // 52x52
        array(0x040,0x040,0x038,0x038,0x010,0x010,0x00e,0x00e,0x004,0x004,0x010,0x118,0x070,0x002,0x08c,0x038), // 64x64
        array(0x048,0x048,0x040,0x040,0x012,0x012,0x010,0x010,0x004,0x004,0x010,0x170,0x090,0x004,0x05c,0x024), // 72x72
        array(0x050,0x050,0x048,0x048,0x014,0x014,0x012,0x012,0x004,0x004,0x010,0x1c8,0x0c0,0x004,0x072,0x030), // 80x80
        array(0x058,0x058,0x050,0x050,0x016,0x016,0x014,0x014,0x004,0x004,0x010,0x240,0x0e0,0x004,0x090,0x038), // 88x88
        array(0x060,0x060,0x058,0x058,0x018,0x018,0x016,0x016,0x004,0x004,0x010,0x2b8,0x110,0x004,0x0ae,0x044), // 96x96
        array(0x068,0x068,0x060,0x060,0x01a,0x01a,0x018,0x018,0x004,0x004,0x010,0x330,0x150,0x006,0x088,0x038), // 104x104
        array(0x078,0x078,0x06c,0x06c,0x014,0x014,0x012,0x012,0x006,0x006,0x024,0x41a,0x198,0x006,0x0af,0x044), // 120x120
        array(0x084,0x084,0x078,0x078,0x016,0x016,0x014,0x014,0x006,0x006,0x024,0x518,0x1f0,0x008,0x0a3,0x03e), // 132x132
        array(0x090,0x090,0x084,0x084,0x018,0x018,0x016,0x016,0x006,0x006,0x024,0x616,0x26c,0x00a,0x09c,0x03e), // 144x144
        // rectangular form (currently unused) ---------------------------------------------------------------------------
        array(0x008,0x012,0x006,0x010,0x008,0x012,0x006,0x010,0x001,0x001,0x001,0x005,0x007,0x001,0x005,0x007), // 8x18
        array(0x008,0x020,0x006,0x01c,0x008,0x010,0x006,0x00e,0x001,0x002,0x002,0x00a,0x00b,0x001,0x00a,0x00b), // 8x32
        array(0x00c,0x01a,0x00a,0x018,0x00c,0x01a,0x00a,0x018,0x001,0x001,0x001,0x010,0x00e,0x001,0x010,0x00e), // 12x26
        array(0x00c,0x024,0x00a,0x020,0x00c,0x012,0x00a,0x010,0x001,0x002,0x002,0x00c,0x012,0x001,0x00c,0x012), // 12x36
        array(0x010,0x024,0x00e,0x020,0x010,0x012,0x00e,0x010,0x001,0x002,0x002,0x020,0x018,0x001,0x020,0x018), // 16x36
        array(0x010,0x030,0x00e,0x02c,0x010,0x018,0x00e,0x016,0x001,0x002,0x002,0x031,0x01c,0x001,0x031,0x01c)  // 16x48
    );

    protected $chsetId = array(self::ENC_C40 => 'C40', self::ENC_TXT => 'TXT', self::ENC_X12 =>'X12');

    protected $chset = array(
        'C40' => array( // Basic set for C40 ----------------------------------------------------------------------------
            'S1'=>0x00,'S2'=>0x01,'S3'=>0x02,0x20=>0x03,0x30=>0x04,0x31=>0x05,0x32=>0x06,0x33=>0x07,0x34=>0x08,0x35=>0x09, //
            0x36=>0x0a,0x37=>0x0b,0x38=>0x0c,0x39=>0x0d,0x41=>0x0e,0x42=>0x0f,0x43=>0x10,0x44=>0x11,0x45=>0x12,0x46=>0x13, //
            0x47=>0x14,0x48=>0x15,0x49=>0x16,0x4a=>0x17,0x4b=>0x18,0x4c=>0x19,0x4d=>0x1a,0x4e=>0x1b,0x4f=>0x1c,0x50=>0x1d, //
            0x51=>0x1e,0x52=>0x1f,0x53=>0x20,0x54=>0x21,0x55=>0x22,0x56=>0x23,0x57=>0x24,0x58=>0x25,0x59=>0x26,0x5a=>0x27),//
        'TXT' => array( // Basic set for TEXT ---------------------------------------------------------------------------
            'S1'=>0x00,'S2'=>0x01,'S3'=>0x02,0x20=>0x03,0x30=>0x04,0x31=>0x05,0x32=>0x06,0x33=>0x07,0x34=>0x08,0x35=>0x09, //
            0x36=>0x0a,0x37=>0x0b,0x38=>0x0c,0x39=>0x0d,0x61=>0x0e,0x62=>0x0f,0x63=>0x10,0x64=>0x11,0x65=>0x12,0x66=>0x13, //
            0x67=>0x14,0x68=>0x15,0x69=>0x16,0x6a=>0x17,0x6b=>0x18,0x6c=>0x19,0x6d=>0x1a,0x6e=>0x1b,0x6f=>0x1c,0x70=>0x1d, //
            0x71=>0x1e,0x72=>0x1f,0x73=>0x20,0x74=>0x21,0x75=>0x22,0x76=>0x23,0x77=>0x24,0x78=>0x25,0x79=>0x26,0x7a=>0x27),//
        'SH1' => array( // Shift 1 set ----------------------------------------------------------------------------------
            0x00=>0x00,0x01=>0x01,0x02=>0x02,0x03=>0x03,0x04=>0x04,0x05=>0x05,0x06=>0x06,0x07=>0x07,0x08=>0x08,0x09=>0x09, //
            0x0a=>0x0a,0x0b=>0x0b,0x0c=>0x0c,0x0d=>0x0d,0x0e=>0x0e,0x0f=>0x0f,0x10=>0x10,0x11=>0x11,0x12=>0x12,0x13=>0x13, //
            0x14=>0x14,0x15=>0x15,0x16=>0x16,0x17=>0x17,0x18=>0x18,0x19=>0x19,0x1a=>0x1a,0x1b=>0x1b,0x1c=>0x1c,0x1d=>0x1d, //
            0x1e=>0x1e,0x1f=>0x1f),                                                                                        //
        'SH2' => array( // Shift 2 set ----------------------------------------------------------------------------------
            0x21=>0x00,0x22=>0x01,0x23=>0x02,0x24=>0x03,0x25=>0x04,0x26=>0x05,0x27=>0x06,0x28=>0x07,0x29=>0x08,0x2a=>0x09, //
            0x2b=>0x0a,0x2c=>0x0b,0x2d=>0x0c,0x2e=>0x0d,0x2f=>0x0e,0x3a=>0x0f,0x3b=>0x10,0x3c=>0x11,0x3d=>0x12,0x3e=>0x13, //
            0x3f=>0x14,0x40=>0x15,0x5b=>0x16,0x5c=>0x17,0x5d=>0x18,0x5e=>0x19,0x5f=>0x1a,'F1'=>0x1b,'US'=>0x1e),           //
        'S3C' => array( // Shift 3 set for C40 --------------------------------------------------------------------------
            0x60=>0x00,0x61=>0x01,0x62=>0x02,0x63=>0x03,0x64=>0x04,0x65=>0x05,0x66=>0x06,0x67=>0x07,0x68=>0x08,0x69=>0x09, //
            0x6a=>0x0a,0x6b=>0x0b,0x6c=>0x0c,0x6d=>0x0d,0x6e=>0x0e,0x6f=>0x0f,0x70=>0x10,0x71=>0x11,0x72=>0x12,0x73=>0x13, //
            0x74=>0x14,0x75=>0x15,0x76=>0x16,0x77=>0x17,0x78=>0x18,0x79=>0x19,0x7a=>0x1a,0x7b=>0x1b,0x7c=>0x1c,0x7d=>0x1d, //
            0x7e=>0x1e,0x7f=>0x1f),
        'S3T' => array( // Shift 3 set for TEXT -------------------------------------------------------------------------
            0x60=>0x00,0x41=>0x01,0x42=>0x02,0x43=>0x03,0x44=>0x04,0x45=>0x05,0x46=>0x06,0x47=>0x07,0x48=>0x08,0x49=>0x09, //
            0x4a=>0x0a,0x4b=>0x0b,0x4c=>0x0c,0x4d=>0x0d,0x4e=>0x0e,0x4f=>0x0f,0x50=>0x10,0x51=>0x11,0x52=>0x12,0x53=>0x13, //
            0x54=>0x14,0x55=>0x15,0x56=>0x16,0x57=>0x17,0x58=>0x18,0x59=>0x19,0x5a=>0x1a,0x7b=>0x1b,0x7c=>0x1c,0x7d=>0x1d, //
            0x7e=>0x1e,0x7f=>0x1f),                                                                                        //
        'X12' => array( // Set for X12 ----------------------------------------------------------------------------------
            0x0d=>0x00,0x2a=>0x01,0x3e=>0x02,0x20=>0x03,0x30=>0x04,0x31=>0x05,0x32=>0x06,0x33=>0x07,0x34=>0x08,0x35=>0x09, //
            0x36=>0x0a,0x37=>0x0b,0x38=>0x0c,0x39=>0x0d,0x41=>0x0e,0x42=>0x0f,0x43=>0x10,0x44=>0x11,0x45=>0x12,0x46=>0x13, //
            0x47=>0x14,0x48=>0x15,0x49=>0x16,0x4a=>0x17,0x4b=>0x18,0x4c=>0x19,0x4d=>0x1a,0x4e=>0x1b,0x4f=>0x1c,0x50=>0x1d, //
            0x51=>0x1e,0x52=>0x1f,0x53=>0x20,0x54=>0x21,0x55=>0x22,0x56=>0x23,0x57=>0x24,0x58=>0x25,0x59=>0x26,0x5a=>0x27) //
    );

    /**
     * @param string $code
     */
    public function __construct($code)
    {
        $params = array();

        if ((is_null($code)) || ($code == '\0') || ($code == '')) {
            return false;
        }
        // get data codewords
        $cw = $this->getHighLevelEncoding($code);
        // number of data codewords
        $nd = count($cw);
        // check size
        if ($nd > 1558) {
            return false;
        }
        // get minimum required matrix size.
        foreach ($this->symbattr as $params) {
            if ($params[11] >= $nd) {
                break;
            }
        }
        if ($params[11] < $nd) {
            // too much data
            return false;
        } elseif ($params[11] > $nd) {
            // add padding
            if ($this->lastEnc == self::ENC_EDF) {
                // switch to ASCII encoding
                $cw[] = 124;
                ++$nd;
            } elseif (($this->lastEnc != self::ENC_ASCII) && ($this->lastEnc != self::ENC_BASE256)) {
                // switch to ASCII encoding
                $cw[] = 254;
                ++$nd;
            }
            if ($params[11] > $nd) {
                // add first pad
                $cw[] = 129;
                ++$nd;
                // add remaining pads
                for ($i = $nd; $i <= $params[11]; ++$i) {
                    $cw[] = $this->get253StateCodeword(129, $i);
                }
            }
        }
        // add error correction codewords
        $cw = $this->getErrorCorrection($cw, $params[13], $params[14], $params[15]);
        // initialize empty arrays
        // $grid = array_fill(0, ($params[2] * $params[3]), 0);
        $grid = array();
        // get placement map
        $places = $this->getPlacemetMap($params[2], $params[3]);
        $i = 0;
        // region data row max index
        $rdri = ($params[4] - 1);
        // region data column max index
        $rdci = ($params[5] - 1);
        // for each vertical region
        for ($vr = 0; $vr < $params[9]; ++$vr) {
            // for each row on region
            for ($r = 0; $r < $params[4]; ++$r) {
                // get row
                $row = (($vr * $params[4]) + $r);
                // for each horizontal region
                for ($hr = 0; $hr < $params[8]; ++$hr) {
                    // for each column on region
                    for ($c = 0; $c < $params[5]; ++$c) {
                        // get column
                        $col = (($hr * $params[5]) + $c);
                        // braw bits by case
                        if ($r == 0) {
                            // top finder pattern
                            if ($c % 2) {
                                $grid[$row][$col] = 0;
                            } else {
                                $grid[$row][$col] = 1;
                            }
                        } elseif ($r == $rdri) {
                            // bottom finder pattern
                            $grid[$row][$col] = 1;
                        } elseif ($c == 0) {
                            // left finder pattern
                            $grid[$row][$col] = 1;
                        } elseif ($c == $rdci) {
                            // right finder pattern
                            if ($r % 2) {
                                $grid[$row][$col] = 1;
                            } else {
                                $grid[$row][$col] = 0;
                            }
                        } else {
                            if ($places[$i] < 2) {
                                $grid[$row][$col] = $places[$i];
                            } else {
                                // codeword ID
                                $cwId = (int) (floor($places[$i] / 10) - 1);
                                // codeword BIT mask
                                $cwBit = pow(2, (8 - ($places[$i] % 10)));
                                $grid[$row][$col] = (($cw[$cwId] & $cwBit) == 0) ? 0 : 1;
                            }
                            ++$i;
                        }
                    }
                }
            }
        }
        $this->barcodeArray['num_rows'] = $params[0];
        $this->barcodeArray['num_cols'] = $params[1];
        $this->barcodeArray['bcode'] = $grid;

        return false;
    }

    /**
     * Returns a barcode array which is readable by Dinesh Rabara
     * @return array barcode array readable by Dinesh Rabara;
     * @public
     */
    public function getBarcodeArray()
    {
        return $this->barcodeArray;
    }

    /**
     * @param int   $a
     * @param int   $b
     * @param array $log
     * @param array $alog
     * @param int   $gf
     *
     * @return int
     */
    protected function getGFProduct($a, $b, $log, $alog, $gf)
    {
        if (($a == 0) || ($b == 0)) {
            return 0;
        }

        return $alog[($log[$a] + $log[$b]) % ($gf - 1)];
    }

    /**
     * Add error correction codewords to data codewords array (ANNEX E).
     *
     * @param array $wd
     * @param int   $nb
     * @param int   $nd
     * @param int   $nc
     * @param int   $gf
     * @param int   $pp
     *
     * @return mixed
     */
    protected function getErrorCorrection($wd, $nb, $nd, $nc, $gf=256, $pp=301)
    {
        // generate the log ($log) and antilog ($alog) tables
        $log[0] = 0;
        $alog[0] = 1;
        for ($i = 1; $i < $gf; ++$i) {
            $alog[$i] = ($alog[($i - 1)] * 2);
            if ($alog[$i] >= $gf) {
                $alog[$i] ^= $pp;
            }
            $log[$alog[$i]] = $i;
        }
        ksort($log);
        // generate the polynomial coefficients (c)
        $c = array_fill(0, ($nc + 1), 0);
        $c[0] = 1;
        for ($i = 1; $i <= $nc; ++$i) {
            $c[$i] = $c[($i-1)];
            for ($j = ($i - 1); $j >= 1; --$j) {
                $c[$j] = $c[($j - 1)] ^ $this->getGFProduct($c[$j], $alog[$i], $log, $alog, $gf);
            }
            $c[0] = $this->getGFProduct($c[0], $alog[$i], $log, $alog, $gf);
        }
        ksort($c);
        // total number of data codewords
        $numWd = ($nb * $nd);
        // total number of error codewords
        $numWe = ($nb * $nc);
        // for each block
        for ($b = 0; $b < $nb; ++$b) {
            // create interleaved data block
            $block = array();
            for ($n = $b; $n < $numWd; $n += $nb) {
                $block[] = $wd[$n];
            }
            // initialize error codewords
            $we = array_fill(0, ($nc + 1), 0);
            // calculate error correction codewords for this block
            for ($i = 0; $i < $nd; ++$i) {
                $k = ($we[0] ^ $block[$i]);
                for ($j = 0; $j < $nc; ++$j) {
                    $we[$j] = ($we[($j + 1)] ^ $this->getGFProduct($k, $c[($nc - $j - 1)], $log, $alog, $gf));
                }
            }
            // add error codewords at the end of data codewords
            $j = 0;
            for ($i = $b; $i < $numWe; $i += $nb) {
                $wd[($numWd + $i)] = $we[$j];
                ++$j;
            }
        }
        // reorder codewords
        ksort($wd);

        return $wd;
    }

    /**
     * Return the 253-state codeword
     *
     * @param int $cwpad
     * @param int $cwpos
     *
     * @return int
     */
    protected function get253StateCodeword($cwpad, $cwpos)
    {
        $pad = ($cwpad + (((149 * $cwpos) % 253) + 1));
        if ($pad > 254) {
            $pad -= 254;
        }

        return $pad;
    }

    /**
     * Return the 255-state codeword
     *
     * @param int $cwpad
     * @param int $cwpos
     *
     * @return int
     */
    protected function get255StateCodeword($cwpad, $cwpos)
    {
        $pad = ($cwpad + (((149 * $cwpos) % 255) + 1));
        if ($pad > 255) {
            $pad -= 256;
        }

        return $pad;
    }

    /**
     * Returns true if the char belongs to the selected mode
     *
     * @param int $chr
     * @param int $mode
     *
     * @return bool
     */
    protected function isCharMode($chr, $mode)
    {
        $status = false;
        switch ($mode) {
            case self::ENC_ASCII: // ASCII character 0 to 127
                $status = (($chr >= 0) && ($chr <= 127));
                break;

            case self::ENC_C40: // Upper-case alphanumeric
                $status = (($chr == 32) || (($chr >= 48) && ($chr <= 57)) || (($chr >= 65) && ($chr <= 90)));
                break;

            case self::ENC_TXT: // Lower-case alphanumeric
                $status = (($chr == 32) || (($chr >= 48) && ($chr <= 57)) || (($chr >= 97) && ($chr <= 122)));
                break;

            case self::ENC_X12: // ANSI X12
                $status = (($chr == 13) || ($chr == 42) || ($chr == 62));
                break;

            case self::ENC_EDF: // ASCII character 32 to 94
                $status = (($chr >= 32) && ($chr <= 94));
                break;

            case self::ENC_BASE256: // Function character (FNC1, Structured Append, Reader Program, or Code Page)
                $status = (($chr == 232) || ($chr == 233) || ($chr == 234) || ($chr == 241));
                break;

            case self::ENC_ASCII_EXT: // ASCII character 128 to 255
                $status = (($chr >= 128) && ($chr <= 255));
                break;

            case self::ENC_ASCII_NUM: // ASCII digits
                $status = (($chr >= 48) && ($chr <= 57));
                break;

        }

        return $status;
    }

    /**
     * The look-ahead test scans the data to be encoded to find the best mode (Annex P - steps from J to S).
     *
     * @param string $data
     * @param int    $pos
     * @param int    $mode
     *
     * @return int
     */
    protected function lookAheadTest($data, $pos, $mode)
    {
        $dataLength = strlen($data);
        if ($pos >= $dataLength) {
            return $mode;
        }
        $charscount = 0; // count processed chars
        // STEP J
        if ($mode == self::ENC_ASCII) {
            $numch = array(0, 1, 1, 1, 1, 1.25);
        } else {
            $numch = array(1, 2, 2, 2, 2, 2.25);
            $numch[$mode] = 0;
        }
        while (true) {
            // STEP K
            if (($pos + $charscount) == $dataLength) {
                if ($numch[self::ENC_ASCII] <= ceil(min($numch[self::ENC_C40], $numch[self::ENC_TXT], $numch[self::ENC_X12], $numch[self::ENC_EDF], $numch[self::ENC_BASE256]))) {
                    return self::ENC_ASCII;
                }
                if ($numch[self::ENC_BASE256] < ceil(min($numch[self::ENC_ASCII], $numch[self::ENC_C40], $numch[self::ENC_TXT], $numch[self::ENC_X12], $numch[self::ENC_EDF]))) {
                    return self::ENC_BASE256;
                }
                if ($numch[self::ENC_EDF] < ceil(min($numch[self::ENC_ASCII], $numch[self::ENC_C40], $numch[self::ENC_TXT], $numch[self::ENC_X12], $numch[self::ENC_BASE256]))) {
                    return self::ENC_EDF;
                }
                if ($numch[self::ENC_TXT] < ceil(min($numch[self::ENC_ASCII], $numch[self::ENC_C40], $numch[self::ENC_X12], $numch[self::ENC_EDF], $numch[self::ENC_BASE256]))) {
                    return self::ENC_TXT;
                }
                if ($numch[self::ENC_X12] < ceil(min($numch[self::ENC_ASCII], $numch[self::ENC_C40], $numch[self::ENC_TXT], $numch[self::ENC_EDF], $numch[self::ENC_BASE256]))) {
                    return self::ENC_X12;
                }

                return self::ENC_C40;
            }
            // get char
            $chr = ord($data{($pos + $charscount)});
            $charscount++;
            // STEP L
            if ($this->isCharMode($chr, self::ENC_ASCII_NUM)) {
                $numch[self::ENC_ASCII] += (1 / 2);
            } elseif ($this->isCharMode($chr, self::ENC_ASCII_EXT)) {
                $numch[self::ENC_ASCII] = ceil($numch[self::ENC_ASCII]);
                $numch[self::ENC_ASCII] += 2;
            } else {
                $numch[self::ENC_ASCII] = ceil($numch[self::ENC_ASCII]);
                $numch[self::ENC_ASCII] += 1;
            }
            // STEP M
            if ($this->isCharMode($chr, self::ENC_C40)) {
                $numch[self::ENC_C40] += (2 / 3);
            } elseif ($this->isCharMode($chr, self::ENC_ASCII_EXT)) {
                $numch[self::ENC_C40] += (8 / 3);
            } else {
                $numch[self::ENC_C40] += (4 / 3);
            }
            // STEP N
            if ($this->isCharMode($chr, self::ENC_TXT)) {
                $numch[self::ENC_TXT] += (2 / 3);
            } elseif ($this->isCharMode($chr, self::ENC_ASCII_EXT)) {
                $numch[self::ENC_TXT] += (8 / 3);
            } else {
                $numch[self::ENC_TXT] += (4 / 3);
            }
            // STEP O
            if ($this->isCharMode($chr, self::ENC_X12) || $this->isCharMode($chr, self::ENC_C40)) {
                $numch[self::ENC_X12] += (2 / 3);
            } elseif ($this->isCharMode($chr, self::ENC_ASCII_EXT)) {
                $numch[self::ENC_X12] += (13 / 3);
            } else {
                $numch[self::ENC_X12] += (10 / 3);
            }
            // STEP P
            if ($this->isCharMode($chr, self::ENC_EDF)) {
                $numch[self::ENC_EDF] += (3 / 4);
            } elseif ($this->isCharMode($chr, self::ENC_ASCII_EXT)) {
                $numch[self::ENC_EDF] += (17 / 4);
            } else {
                $numch[self::ENC_EDF] += (13 / 4);
            }
            // STEP Q
            if ($this->isCharMode($chr, self::ENC_BASE256)) {
                $numch[self::ENC_BASE256] += 4;
            } else {
                $numch[self::ENC_BASE256] += 1;
            }
            // STEP R
            if ($charscount >= 4) {
                if (($numch[self::ENC_ASCII] + 1) <= min($numch[self::ENC_C40], $numch[self::ENC_TXT], $numch[self::ENC_X12], $numch[self::ENC_EDF], $numch[self::ENC_BASE256])) {
                    return self::ENC_ASCII;
                }
                if ((($numch[self::ENC_BASE256] + 1) <= $numch[self::ENC_ASCII])
                    || (($numch[self::ENC_BASE256] + 1) < min($numch[self::ENC_C40], $numch[self::ENC_TXT], $numch[self::ENC_X12], $numch[self::ENC_EDF]))) {
                    return self::ENC_BASE256;
                }
                if (($numch[self::ENC_EDF] + 1) < min($numch[self::ENC_ASCII], $numch[self::ENC_C40], $numch[self::ENC_TXT], $numch[self::ENC_X12], $numch[self::ENC_BASE256])) {
                    return self::ENC_EDF;
                }
                if (($numch[self::ENC_TXT] + 1) < min($numch[self::ENC_ASCII], $numch[self::ENC_C40], $numch[self::ENC_X12], $numch[self::ENC_EDF], $numch[self::ENC_BASE256])) {
                    return self::ENC_TXT;
                }
                if (($numch[self::ENC_X12] + 1) < min($numch[self::ENC_ASCII], $numch[self::ENC_C40], $numch[self::ENC_TXT], $numch[self::ENC_EDF], $numch[self::ENC_BASE256])) {
                    return self::ENC_X12;
                }
                if (($numch[self::ENC_C40] + 1) < min($numch[self::ENC_ASCII], $numch[self::ENC_TXT], $numch[self::ENC_EDF], $numch[self::ENC_BASE256])) {
                    if ($numch[self::ENC_C40] < $numch[self::ENC_X12]) {
                        return self::ENC_C40;
                    }
                    if ($numch[self::ENC_C40] == $numch[self::ENC_X12]) {
                        $k = ($pos + $charscount + 1);
                        while ($k < $dataLength) {
                            $tmpchr = ord($data{$k});
                            if ($this->isCharMode($tmpchr, self::ENC_X12)) {
                                return self::ENC_X12;
                            } elseif (!($this->isCharMode($tmpchr, self::ENC_X12) || $this->isCharMode($tmpchr, self::ENC_C40))) {
                                break;
                            }
                            ++$k;
                        }

                        return self::ENC_C40;
                    }
                }
            }
        } // end of while

        return true;
    }

    /**
     * Get the switching codeword to a new encoding mode (latch codeword)
     *
     * @param int $mode
     *
     * @return int
     */
    protected function getSwitchEncodingCodeword($mode)
    {
        $cw = 0;

        switch ($mode) {
            case self::ENC_ASCII: // ASCII character 0 to 127
                $cw = 254;
                break;

            case self::ENC_C40: // Upper-case alphanumeric
                $cw = 230;
                break;

            case self::ENC_TXT: // Lower-case alphanumeric
                $cw = 239;
                break;

            case self::ENC_X12: // ANSI X12
                $cw = 238;
                break;

            case self::ENC_EDF: // ASCII character 32 to 94
                $cw = 240;
                break;

            case self::ENC_BASE256: // Function character (FNC1, Structured Append, Reader Program, or Code Page)
                $cw = 231;
                break;

        }

        return $cw;
    }

    /**
     * Choose the minimum matrix size and return the max number of data codewords.
     *
     * @param int $numcw
     *
     * @return int
     */
    protected function getMaxDataCodewords($numcw)
    {
        foreach ($this->symbattr as $matrix) {
            if ($matrix[11] >= $numcw) {
                return $matrix[11];
            }
        }

        return 0;
    }

    /**
     * Get high level encoding using the minimum symbol data characters for ECC 200
     *
     * @param string $data
     *
     * @return array|bool
     */
    protected function getHighLevelEncoding($data)
    {
        // STEP A. Start in ASCII encodation.
        $enc = self::ENC_ASCII; // current encoding mode
        $chr = 0;
        $pos = 0; // current position
        $cw = array(); // array of codewords to be returned
        $cwNum = 0; // number of data codewords
        $dataLenght = strlen($data); // number of chars
        while ($pos < $dataLenght) {
            switch ($enc) {
                case self::ENC_ASCII : // STEP B. While in ASCII encodation
                    if (($dataLenght > 1) && ($pos < ($dataLenght - 1)) && ($this->isCharMode(ord($data{($pos)}), self::ENC_ASCII_NUM) && $this->isCharMode(ord($data{($pos + 1)}), self::ENC_ASCII_NUM))) {
                        // 1. If the next data sequence is at least 2 consecutive digits, encode the next two digits as a double digit in ASCII mode.
                        $cw[] = (intval(substr($data, $pos, 2)) + 130);
                        ++$cwNum;
                        $pos += 2;
                    } else {
                        // 2. If the look-ahead test (starting at step J) indicates another mode, switch to that mode.
                        $newenc = $this->lookAheadTest($data, $pos, $enc);
                        if ($newenc != $enc) {
                            // switch to new encoding
                            $enc = $newenc;
                            $cw[] = $this->getSwitchEncodingCodeword($enc);
                            ++$cwNum;
                        } else {
                            // get new byte
                            $chr = ord($data{($pos)});
                            ++$pos;
                            if ($this->isCharMode($chr, self::ENC_ASCII_EXT)) {
                                // 3. If the next data character is extended ASCII (greater than 127) encode it in ASCII mode first using the Upper Shift (value 235) character.
                                $cw[] = 235;
                                $cw[] = ($chr - 127);
                                $cwNum += 2;
                            } else {
                                // 4. Otherwise process the next data character in ASCII encodation.
                                $cw[] = ($chr + 1);
                                ++$cwNum;
                            }
                        }
                    }
                    break;
                case self::ENC_C40 : // Upper-case alphanumeric
                case self::ENC_TXT : // Lower-case alphanumeric
                case self::ENC_X12 : // ANSI X12
                    $tempCw = array();
                    $p = 0;
                    $epos = $pos;
                    // get charset ID
                    $setId = $this->chsetId[$enc];
                    // get basic charset for current encoding
                    $charset = $this->chset[$setId];
                    do {
                    // 2. process the next character in C40 encodation.
                    $chr = ord($data{($epos)});
                    ++$epos;
                    // check for extended character
                    if ($chr & 0x80) {
                        if ($enc == self::ENC_X12) {
                            return false;
                        }
                        $chr = ($chr & 0x7f);
                        $tempCw[] = 1; // shift 2
                        $tempCw[] = 30; // upper shift
                        $p += 2;
                    }
                    if (isset($charset[$chr])) {
                        $tempCw[] = $charset[$chr];
                        ++$p;
                    } else {
                        if (isset($this->chset['SH1'][$chr])) {
                            $tempCw[] = 0; // shift 1
                            $shiftset = $this->chset['SH1'];
                        } elseif (isset($chr, $this->chset['SH2'][$chr])) {
                            $tempCw[] = 1; // shift 2
                            $shiftset = $this->chset['SH2'];
                        } elseif (($enc == self::ENC_C40) && isset($this->chset['S3C'][$chr])) {
                            $tempCw[] = 2; // shift 3
                            $shiftset = $this->chset['S3C'];
                        } elseif (($enc == self::ENC_TXT) && isset($this->chset['S3T'][$chr])) {
                            $tempCw[] = 2; // shift 3
                            $shiftset = $this->chset['S3T'];
                        } else {
                            return false;
                        }
                        $tempCw[] = $shiftset[$chr];
                        $p += 2;
                    }
                    if ($p >= 3) {
                        $c1 = array_shift($tempCw);
                        $c2 = array_shift($tempCw);
                        $c3 = array_shift($tempCw);
                        $p -= 3;
                        $tmp = ((1600 * $c1) + (40 * $c2) + $c3 + 1);
                        $cw[] = ($tmp >> 8);
                        $cw[] = ($tmp % 256);
                        $cwNum += 2;
                        $pos = $epos;
                        // 1. If the C40 encoding is at the point of starting a new double symbol character and if the look-ahead test (starting at step J) indicates another mode, switch to that mode.
                        $newenc = $this->lookAheadTest($data, $pos, $enc);
                        if ($newenc != $enc) {
                            $enc = $newenc;
                            $cw[] = $this->getSwitchEncodingCodeword($enc);
                            ++$cwNum;
                            break;
                        }
                    }
                    } while (($p > 0) && ($epos < $dataLenght));
                    // process last data (if any)
                    if ($p > 0) {
                    // get remaining number of data symbols
                    $cwr = ($this->getMaxDataCodewords($cwNum + 2) - $cwNum);
                    if (($cwr == 1) && ($p == 1)) {
                        // d. If one symbol character remains and one C40 value (data character) remains to be encoded
                        $c1 = array_shift($tempCw);
                        --$p;
                        $cw[] = ($c1 + 1);
                        ++$cwNum;
                    } elseif (($cwr == 2) && ($p == 1)) {
                        // c. If two symbol characters remain and only one C40 value (data character) remains to be encoded
                        $c1 = array_shift($tempCw);
                        --$p;
                        $cw[] = 254;
                        $cw[] = ($c1 + 1);
                        $cwNum += 2;
                    } elseif (($cwr == 2) && ($p == 2)) {
                        // b. If two symbol characters remain and two C40 values remain to be encoded
                        $c1 = array_shift($tempCw);
                        $c2 = array_shift($tempCw);
                        $p -= 2;
                        $tmp = ((1600 * $c1) + (40 * $c2) + 1);
                        $cw[] = ($tmp >> 8);
                        $cw[] = ($tmp % 256);
                        $cwNum += 2;
                    } else {
                        // switch to ASCII encoding
                        $enc = self::ENC_ASCII;
                        $cw[] = $this->getSwitchEncodingCodeword($enc);
                        ++$cwNum;
                    }
                    }
                    break;
                case self::ENC_EDF : // F. While in EDIFACT (EDF) encodation
                    // initialize temporary array with 0 lenght
                    $tempCw = array();
                    $epos = $pos;
                    $fieldLenght = 0;
                    while ($epos < $dataLenght) {
                        // 2. process the next character in EDIFACT encodation.
                        $chr = ord($data{($epos)});
                        ++$epos;
                        $tempCw[] = $chr;
                        ++$fieldLenght;
                        if (($fieldLenght == 4) || ($epos == $dataLenght)) {
                            if ($fieldLenght < 4) {
                                // set unlatch character
                                $tempCw[] = 0x1f;
                                ++$fieldLenght;
                                $enc = self::ENC_ASCII;
                                // fill empty characters
                                for ($i = $fieldLenght; $i < 4; ++$i) {
                                    $tempCw[] = 0;
                                }
                            }
                            // encodes four data characters in three codewords
                            $cw[] = (($tempCw[0] & 0x3F) << 2) + (($tempCw[1] & 0x30) >> 4);
                            $cw[] = (($tempCw[1] & 0x0F) << 4) + (($tempCw[2] & 0x3C) >> 2);
                            $cw[] = (($tempCw[2] & 0x03) << 6) + ($tempCw[3] & 0x3F);
                            $cwNum += 3;
                            $tempCw = array();
                            $pos = $epos;
                            $fieldLenght = 0;
                        }
                        // 1. If the EDIFACT encoding is at the point of starting a new triple symbol character and if the look-ahead test (starting at step J) indicates another mode, switch to that mode.
                        if ($fieldLenght == 0) {
                            // get remaining number of data symbols
                            $cwr = ($this->getMaxDataCodewords($cwNum + 2) - $cwNum);
                            if ($cwr < 3) {
                                // return to ascii without unlatch
                                $enc = self::ENC_ASCII;
                                break; // exit from EDIFACT mode
                            } else {
                                $newenc = $this->lookAheadTest($data, $pos, $enc);
                                if ($newenc != $enc) {
                                    // 1. If the look-ahead test (starting at step J) indicates another mode, switch to that mode.
                                    $enc = $newenc;
                                    $cw[] = $this->getSwitchEncodingCodeword($enc);
                                    ++$cwNum;
                                    break; // exit from EDIFACT mode
                                }
                            }
                        }
                    }
                    break;
                case self::ENC_BASE256 : // G. While in Base 256 (B256) encodation
                    // initialize temporary array with 0 lenght
                    $tempCw = array();
                    $fieldLenght = 0;
                    while (($pos < $dataLenght) && ($fieldLenght <= 1555)) {
                        $newenc = $this->lookAheadTest($data, $pos, $enc);
                        if ($newenc != $enc) {
                            // 1. If the look-ahead test (starting at step J) indicates another mode, switch to that mode.
                            $enc = $newenc;
                            $cw[] = $this->getSwitchEncodingCodeword($enc);
                            ++$cwNum;
                            break; // exit from B256 mode
                        } else {
                            // 2. Otherwise, process the next character in Base 256 encodation.
                            $chr = ord($data{($pos)});
                            ++$pos;
                            $tempCw[] = $chr;
                            ++$fieldLenght;
                        }
                    }
                    // set field lenght
                    if ($fieldLenght <= 249) {
                        $cw[] = $fieldLenght;
                        ++$cwNum;
                    } else {
                        $cw[] = (floor($fieldLenght / 250) + 249);
                        $cw[] = ($fieldLenght % 250);
                        $cwNum += 2;
                    }
                    if (!empty($tempCw)) {
                        // add B256 field
                        foreach ($tempCw as $p => $cht) {
                            $cw[] = $this->get255StateCodeword($chr, ($cwNum + $p));
                        }
                    }
                    break;

            } // end of switch enc
        } // end of while
        // set last used encoding
        $this->lastEnc = $enc;

        return $cw;
    }

    /**
     * Places "chr+bit" with appropriate wrapping within array[] (Annex F - ECC 200 symbol character placement)
     *
     * @param array $marr
     * @param int   $nrow
     * @param int   $ncol
     * @param int   $row
     * @param int   $col
     * @param int   $chr
     * @param int   $bit
     *
     * @return mixed
     */
    protected function placeModule($marr, $nrow, $ncol, $row, $col, $chr, $bit)
    {
        if ($row < 0) {
            $row += $nrow;
            $col += (4 - (($nrow + 4) % 8));
        }
        if ($col < 0) {
            $col += $ncol;
            $row += (4 - (($ncol + 4) % 8));
        }
        $marr[(($row * $ncol) + $col)] = ((10 * $chr) + $bit);

        return $marr;
    }

    /**
     * Places the 8 bits of a utah-shaped symbol character (Annex F - ECC 200 symbol character placement)
     *
     * @param array $marr
     * @param int   $nrow
     * @param int   $ncol
     * @param int   $row
     * @param int   $col
     * @param int   $chr
     *
     * @return mixed
     */
    protected function placeUtah($marr, $nrow, $ncol, $row, $col, $chr)
    {
        $marr = $this->placeModule($marr, $nrow, $ncol, $row-2, $col-2, $chr, 1);
        $marr = $this->placeModule($marr, $nrow, $ncol, $row-2, $col-1, $chr, 2);
        $marr = $this->placeModule($marr, $nrow, $ncol, $row-1, $col-2, $chr, 3);
        $marr = $this->placeModule($marr, $nrow, $ncol, $row-1, $col-1, $chr, 4);
        $marr = $this->placeModule($marr, $nrow, $ncol, $row-1, $col, $chr, 5);
        $marr = $this->placeModule($marr, $nrow, $ncol, $row, $col-2, $chr, 6);
        $marr = $this->placeModule($marr, $nrow, $ncol, $row, $col-1, $chr, 7);
        $marr = $this->placeModule($marr, $nrow, $ncol, $row, $col, $chr, 8);

        return $marr;
    }

    /**
     * Places the 8 bits of the first special corner case (Annex F - ECC 200 symbol character placement)
     *
     * @param array $marr
     * @param int   $nrow
     * @param int   $ncol
     * @param int   $chr
     *
     * @return mixed
     */
    protected function placeCornerA($marr, $nrow, $ncol, $chr)
    {
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow-1, 0, $chr, 1);
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow-1, 1, $chr, 2);
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow-1, 2, $chr, 3);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol-2, $chr, 4);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol-1, $chr, 5);
        $marr = $this->placeModule($marr, $nrow, $ncol, 1, $ncol-1, $chr, 6);
        $marr = $this->placeModule($marr, $nrow, $ncol, 2, $ncol-1, $chr, 7);
        $marr = $this->placeModule($marr, $nrow, $ncol, 3, $ncol-1, $chr, 8);

        return $marr;
    }

    /**
     * Places the 8 bits of the second special corner case (Annex F - ECC 200 symbol character placement)
     *
     * @param array $marr
     * @param int   $nrow
     * @param int   $ncol
     * @param int   $chr
     *
     * @return mixed
     */
    protected function placeCornerB($marr, $nrow, $ncol, $chr)
    {
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow-3, 0, $chr, 1);
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow-2, 0, $chr, 2);
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow-1, 0, $chr, 3);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol-4, $chr, 4);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol-3, $chr, 5);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol-2, $chr, 6);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol-1, $chr, 7);
        $marr = $this->placeModule($marr, $nrow, $ncol, 1, $ncol-1, $chr, 8);

        return $marr;
    }

    /**
     * Places the 8 bits of the third special corner case (Annex F - ECC 200 symbol character placement)
     *
     * @param array $marr
     * @param int   $nrow
     * @param int   $ncol
     * @param int   $chr
     *
     * @return mixed
     */
    protected function placeCornerC($marr, $nrow, $ncol, $chr)
    {
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow-3, 0, $chr, 1);
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow-2, 0, $chr, 2);
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow-1, 0, $chr, 3);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol-2, $chr, 4);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol-1, $chr, 5);
        $marr = $this->placeModule($marr, $nrow, $ncol, 1, $ncol-1, $chr, 6);
        $marr = $this->placeModule($marr, $nrow, $ncol, 2, $ncol-1, $chr, 7);
        $marr = $this->placeModule($marr, $nrow, $ncol, 3, $ncol-1, $chr, 8);

        return $marr;
    }

    /**
     * Places the 8 bits of the fourth special corner case (Annex F - ECC 200 symbol character placement)
     *
     * @param array $marr
     * @param int   $nrow
     * @param int   $ncol
     * @param int   $chr
     *
     * @return mixed
     */
    protected function placeCornerD($marr, $nrow, $ncol, $chr)
    {
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow-1, 0, $chr, 1);
        $marr = $this->placeModule($marr, $nrow, $ncol, $nrow-1, $ncol-1, $chr, 2);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol-3, $chr, 3);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol-2, $chr, 4);
        $marr = $this->placeModule($marr, $nrow, $ncol, 0, $ncol-1, $chr, 5);
        $marr = $this->placeModule($marr, $nrow, $ncol, 1, $ncol-3, $chr, 6);
        $marr = $this->placeModule($marr, $nrow, $ncol, 1, $ncol-2, $chr, 7);
        $marr = $this->placeModule($marr, $nrow, $ncol, 1, $ncol-1, $chr, 8);

        return $marr;
    }

    /**
     * Build a placement map (Annex F - ECC 200 symbol character placement)
     *
     * @param int $nrow
     * @param int $ncol
     *
     * @return array|mixed
     */
    protected function getPlacemetMap($nrow, $ncol)
    {
        // initialize array with zeros
        $marr = array_fill(0, ($nrow * $ncol), 0);
        // set starting values
        $chr = 1;
        $row = 4;
        $col = 0;
        do {
            // repeatedly first check for one of the special corner cases, then
            if (($row == $nrow) && ($col == 0)) {
                $marr = $this->placeCornerA($marr, $nrow, $ncol, $chr);
                ++$chr;
            }
            if (($row == ($nrow - 2)) && ($col == 0) && ($ncol % 4)) {
                $marr = $this->placeCornerB($marr, $nrow, $ncol, $chr);
                ++$chr;
            }
            if (($row == ($nrow - 2)) && ($col == 0) && (($ncol % 8) == 4)) {
                $marr = $this->placeCornerC($marr, $nrow, $ncol, $chr);
                ++$chr;
            }
            if (($row == ($nrow + 4)) && ($col == 2) && (!($ncol % 8))) {
                $marr = $this->placeCornerD($marr, $nrow, $ncol, $chr);
                ++$chr;
            }
            // sweep upward diagonally, inserting successive characters,
            do {
                if (($row < $nrow) && ($col >= 0) && (!$marr[(($row * $ncol) + $col)])) {
                    $marr = $this->placeUtah($marr, $nrow, $ncol, $row, $col, $chr);
                    ++$chr;
                }
                $row -= 2;
                $col += 2;
            } while (($row >= 0) && ($col < $ncol));
            ++$row;
            $col += 3;
            // & then sweep downward diagonally, inserting successive characters,...
            do {
                if (($row >= 0) && ($col < $ncol) && (!$marr[(($row * $ncol) + $col)])) {
                    $marr = $this->placeUtah($marr, $nrow, $ncol, $row, $col, $chr);
                    ++$chr;
                }
                $row += 2;
                $col -= 2;
            } while (($row < $nrow) && ($col >= 0));
            $row += 3;
            ++$col;
            // ... until the entire array is scanned
        } while (($row < $nrow) || ($col < $ncol));
        // lastly, if the lower righthand corner is untouched, fill in fixed pattern
        if (!$marr[(($nrow * $ncol) - 1)]) {
            $marr[(($nrow * $ncol) - 1)] = 1;
            $marr[(($nrow * $ncol) - $ncol - 2)] = 1;
        }

        return $marr;
    }
}
