<?php

namespace TomasVotruba\BarcodeBundle\Plugins;

final class qrcode
{
    /**
     * @var bool
     */
    public const QRCODEDEFS = true;

    /**
     * @var int
     */
    public const // Indicate that definitions for this class are set
    QR_MODE_NL = -1;

    /**
     * @var int
     */
    public const // Encoding modes (characters which can be encoded in QRcode)
    QR_MODE_NM = 0;

    /**
     * @var int
     */
    public const // Encoding mode numeric (0-9). 3 characters are encoded to 10bit length. In theory, 7089 characters or less can be stored in a QRcode.
    QR_MODE_AN = 1;

    /**
     * @var int
     */
    public const // Encoding mode alphanumeric (0-9A-Z $%*+-./:) 45characters. 2 characters are encoded to 11bit length. In theory, 4296 characters or less can be stored in a QRcode.
    QR_MODE_8B = 2;

    /**
     * @var int
     */
    public const // Encoding mode 8bit byte data. In theory, 2953 characters or less can be stored in a QRcode.
    QR_MODE_KJ = 3;

    /**
     * @var int
     */
    public const // Encoding mode KANJI. A KANJI character (multibyte character) is encoded to 13bit length. In theory, 1817 characters or less can be stored in a QRcode.
    QR_MODE_ST = 4;

    /**
     * @var int
     */
    public const // Encoding mode STRUCTURED (currently unsupported)
    QR_ECLEVEL_L = 0;

    /**
     * @var int
     */
    public const // Error correction level L : About 7% or less errors can be corrected.
    QR_ECLEVEL_M = 1;

    /**
     * @var int
     */
    public const // Error correction level M : About 15% or less errors can be corrected.
    QR_ECLEVEL_Q = 2;

    /**
     * @var int
     */
    public const // Error correction level Q : About 25% or less errors can be corrected.
    QR_ECLEVEL_H = 3;

    /**
     * @var int
     */
    public const // Error correction level H : About 30% or less errors can be corrected.

    // Version. Size of QRcode is defined as version. Version is from 1 to 40.
    // Version 1 is 21*21 matrix. And 4 modules increases whenever 1 version increases.
    // So version 40 is 177*177 matrix.

    QRSPEC_VERSION_MAX = 40;

    /**
     * @var int
     */
    public const // Maximum QR Code version.
    QRSPEC_WIDTH_MAX = 177;

    /**
     * @var int
     */
    public const // Maximum matrix size for maximum version (version 40 is 177*177 matrix).
    QRCAP_WIDTH = 0;

    /**
     * @var int
     */
    public const // Matrix index to get width from $capacity array.
    QRCAP_WORDS = 1;

    /**
     * @var int
     */
    public const // Matrix index to get number of words from $capacity array.
    QRCAP_REMINDER = 2;

    /**
     * @var int
     */
    public const // Matrix index to get remainder from $capacity array.
    QRCAP_EC = 3;

    /**
     * @var int
     */
    public const // Matrix index to get error correction level from $capacity array.
    STRUCTURE_HEADER_BITS = 20;

    /**
     * @var int
     */
    public const // Number of header bits for structured mode
    MAX_STRUCTURED_SYMBOLS = 16;

    /**
     * @var int
     */
    public const // Max number of symbols for structured mode
    N1 = 3;

    /**
     * @var int
     */
    public const // Down point base value for case 1 mask pattern (concatenation of same color in a line or a column)
    N2 = 3;

    /**
     * @var int
     */
    public const // Down point base value for case 2 mask pattern (module block of same color)
    N3 = 40;

    /**
     * @var int
     */
    public const // Down point base value for case 3 mask pattern (1:1:3:1:1(dark:bright:dark:bright:dark)pattern in a line or a column)
    N4 = 10;

    /**
     * @var bool
     */
    public const // Down point base value for case 4 mask pattern (ration of dark modules in whole)
    QR_FIND_BEST_MASK = true;

    /**
     * @var int
     */
    public const // if true, estimates best mask (spec. default, but extremally slow; set to false to significant performance boost but (propably) worst quality code
    QR_FIND_FROM_RANDOM = 2;

    /**
     * @var int
     */
    public const // if false, checks all masks available, otherwise value tells count of masks need to be checked, mask id are got randomly
    QR_DEFAULT_MASK = 2; // when QR_FIND_BEST_MASK === false

    /**
     * Barcode array to be returned which is readable by Dinesh Rabara.
     */
    private array $barcodeArray = [];

    /**
     * QR code version. Size of QRcode is defined as version. Version is from 1 to 40. Version 1 is 21*21 matrix. And 4 modules increases whenever 1 version increases. So version 40 is 177*177 matrix.
     */
    private int $version = 0;

    /**
     * Levels of error correction. See definitions for possible values.
     */
    private int $level = self::QR_ECLEVEL_L;

    /**
     * Encoding mode.
     */
    private int $hint = self::QR_MODE_8B;

    /**
     * Boolean flag, if true the input string will be converted to uppercase.
     */
    private bool $casesensitive = true;

    /**
     * Structured QR code (not supported yet).
    /**
     * Mask data.
     */
    private ?array $data = null;

    // FrameFiller

    /**
     * Width.
     */
    private $width;

    /**
     * Frame.
     */
    private $frame;

    /**
     * X position of bit.
     */
    private $x;

    /**
     * Y position of bit.
     */
    private $y;

    /**
     * Direction.
     */
    private ?int $dir = null;

    /**
     * Single bit value.
     */
    private ?int $bit = null;

    // ---- QRrawcode ----

    /**
     * Data code.
     */
    private array $datacode = [];

    /**
     * Error correction code.
     */
    private $ecccode = [];

    /**
     * Blocks.
     */
    private $blocks;

    /**
     * Reed-Solomon blocks.
     */
    private array $rsblocks = []; //of RSblock

    /**
     * Counter.
     */
    private ?int $count = null;

    /**
     * @var int
     */
    private $dataLength;

    /**
     * Error correction length.
     * @var int
     */
    protected $eccLength;

    /**
     * Value b1.
     */
    private $b1;

    // ---- QRmask ----

    /**
     * Run length.
     */
    private $runLength = [];

    // ---- QRsplit ----

    /**
     * Input data string.
     */
    private $dataStr = '';

    /**
     * Input items.
     */
    private $items;

    // Reed-Solomon items

    /**
     * Reed-Solomon items.
     */
    private array $rsitems = [];

    /**
     * Array of frames.
     */
    private array $frames = [];

    /**
     * Alphabet-numeric convesion table.
     */
    private array $anTable = [
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1, //
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1, //
        36,
        -1,
        -1,
        -1,
        37,
        38,
        -1,
        -1,
        -1,
        -1,
        39,
        40,
        -1,
        41,
        42,
        43, //
        0,
        1,
        2,
        3,
        4,
        5,
        6,
        7,
        8,
        9,
        44,
        -1,
        -1,
        -1,
        -1,
        -1, //
        -1,
        10,
        11,
        12,
        13,
        14,
        15,
        16,
        17,
        18,
        19,
        20,
        21,
        22,
        23,
        24, //
        25,
        26,
        27,
        28,
        29,
        30,
        31,
        32,
        33,
        34,
        35,
        -1,
        -1,
        -1,
        -1,
        -1, //
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1, //
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1,
        -1, //
    ];

    /**
     * Array Table of the capacity of symbols.
     * See Table 1 (pp.13) and Table 12-16 (pp.30-36), JIS X0510:2004.
     */
    private array $capacity = [
        [0, 0, 0, [0, 0, 0, 0]], //
        [21, 26, 0, [7, 10, 13, 17]], //  1
        [25, 44, 7, [10, 16, 22, 28]], //
        [29, 70, 7, [15, 26, 36, 44]], //
        [33, 100, 7, [20, 36, 52, 64]], //
        [37, 134, 7, [26, 48, 72, 88]], //  5
        [41, 172, 7, [36, 64, 96, 112]], //
        [45, 196, 0, [40, 72, 108, 130]], //
        [49, 242, 0, [48, 88, 132, 156]], //
        [53, 292, 0, [60, 110, 160, 192]], //
        [57, 346, 0, [72, 130, 192, 224]], // 10
        [61, 404, 0, [80, 150, 224, 264]], //
        [65, 466, 0, [96, 176, 260, 308]], //
        [69, 532, 0, [104, 198, 288, 352]], //
        [73, 581, 3, [120, 216, 320, 384]], //
        [77, 655, 3, [132, 240, 360, 432]], // 15
        [81, 733, 3, [144, 280, 408, 480]], //
        [85, 815, 3, [168, 308, 448, 532]], //
        [89, 901, 3, [180, 338, 504, 588]], //
        [93, 991, 3, [196, 364, 546, 650]], //
        [97, 1085, 3, [224, 416, 600, 700]], // 20
        [101, 1156, 4, [224, 442, 644, 750]], //
        [105, 1258, 4, [252, 476, 690, 816]], //
        [109, 1364, 4, [270, 504, 750, 900]], //
        [113, 1474, 4, [300, 560, 810, 960]], //
        [117, 1588, 4, [312, 588, 870, 1050]], // 25
        [121, 1706, 4, [336, 644, 952, 1110]], //
        [125, 1828, 4, [360, 700, 1020, 1200]], //
        [129, 1921, 3, [390, 728, 1050, 1260]], //
        [133, 2051, 3, [420, 784, 1140, 1350]], //
        [137, 2185, 3, [450, 812, 1200, 1440]], // 30
        [141, 2323, 3, [480, 868, 1290, 1530]], //
        [145, 2465, 3, [510, 924, 1350, 1620]], //
        [149, 2611, 3, [540, 980, 1440, 1710]], //
        [153, 2761, 3, [570, 1036, 1530, 1800]], //
        [157, 2876, 0, [570, 1064, 1590, 1890]], // 35
        [161, 3034, 0, [600, 1120, 1680, 1980]], //
        [165, 3196, 0, [630, 1204, 1770, 2100]], //
        [169, 3362, 0, [660, 1260, 1860, 2220]], //
        [173, 3532, 0, [720, 1316, 1950, 2310]], //
        [177, 3706, 0, [750, 1372, 2040, 2430]], // 40
    ];

    /**
     * Array Length indicator.
     */
    private array $lengthTableBits = [
        [10, 12, 14],
        [9, 11, 13],
        [8, 16, 16],
        [8, 10, 12],
    ];

    /**
     * Array Table of the error correction code (Reed-Solomon block).
     * See Table 12-16 (pp.30-36), JIS X0510:2004.
     */
    private array $eccTable = [
        [[0, 0], [0, 0], [0, 0], [0, 0]], //
        [[1, 0], [1, 0], [1, 0], [1, 0]], //  1
        [[1, 0], [1, 0], [1, 0], [1, 0]], //
        [[1, 0], [1, 0], [2, 0], [2, 0]], //
        [[1, 0], [2, 0], [2, 0], [4, 0]], //
        [[1, 0], [2, 0], [2, 2], [2, 2]], //  5
        [[2, 0], [4, 0], [4, 0], [4, 0]], //
        [[2, 0], [4, 0], [2, 4], [4, 1]], //
        [[2, 0], [2, 2], [4, 2], [4, 2]], //
        [[2, 0], [3, 2], [4, 4], [4, 4]], //
        [[2, 2], [4, 1], [6, 2], [6, 2]], // 10
        [[4, 0], [1, 4], [4, 4], [3, 8]], //
        [[2, 2], [6, 2], [4, 6], [7, 4]], //
        [[4, 0], [8, 1], [8, 4], [12, 4]], //
        [[3, 1], [4, 5], [11, 5], [11, 5]], //
        [[5, 1], [5, 5], [5, 7], [11, 7]], // 15
        [[5, 1], [7, 3], [15, 2], [3, 13]], //
        [[1, 5], [10, 1], [1, 15], [2, 17]], //
        [[5, 1], [9, 4], [17, 1], [2, 19]], //
        [[3, 4], [3, 11], [17, 4], [9, 16]], //
        [[3, 5], [3, 13], [15, 5], [15, 10]], // 20
        [[4, 4], [17, 0], [17, 6], [19, 6]], //
        [[2, 7], [17, 0], [7, 16], [34, 0]], //
        [[4, 5], [4, 14], [11, 14], [16, 14]], //
        [[6, 4], [6, 14], [11, 16], [30, 2]], //
        [[8, 4], [8, 13], [7, 22], [22, 13]], // 25
        [[10, 2], [19, 4], [28, 6], [33, 4]], //
        [[8, 4], [22, 3], [8, 26], [12, 28]], //
        [[3, 10], [3, 23], [4, 31], [11, 31]], //
        [[7, 7], [21, 7], [1, 37], [19, 26]], //
        [[5, 10], [19, 10], [15, 25], [23, 25]], // 30
        [[13, 3], [2, 29], [42, 1], [23, 28]], //
        [[17, 0], [10, 23], [10, 35], [19, 35]], //
        [[17, 1], [14, 21], [29, 19], [11, 46]], //
        [[13, 6], [14, 23], [44, 7], [59, 1]], //
        [[12, 7], [12, 26], [39, 14], [22, 41]], // 35
        [[6, 14], [6, 34], [46, 10], [2, 64]], //
        [[17, 4], [29, 14], [49, 10], [24, 46]], //
        [[4, 18], [13, 32], [48, 14], [42, 32]], //
        [[20, 4], [40, 7], [43, 22], [10, 67]], //
        [[19, 6], [18, 31], [34, 34], [20, 61]], // 40
    ];

    /**
     * Array Positions of alignment patterns.
     * This array includes only the second and the third position of the alignment patterns. Rest of them can be calculated from the distance between them.
     * See Table 1 in Appendix E (pp.71) of JIS X0510:2004.
     */
    private array $alignmentPattern = [
        [0, 0],
        [0, 0],
        [18, 0],
        [22, 0],
        [26, 0],
        [30, 0], //  1- 5
        [34, 0],
        [22, 38],
        [24, 42],
        [26, 46],
        [28, 50], //  6-10
        [30, 54],
        [32, 58],
        [34, 62],
        [26, 46],
        [26, 48], // 11-15
        [26, 50],
        [30, 54],
        [30, 56],
        [30, 58],
        [34, 62], // 16-20
        [28, 50],
        [26, 50],
        [30, 54],
        [28, 54],
        [32, 58], // 21-25
        [30, 58],
        [34, 62],
        [26, 50],
        [30, 54],
        [26, 52], // 26-30
        [30, 56],
        [34, 60],
        [30, 58],
        [34, 62],
        [30, 54], // 31-35
        [24, 50],
        [28, 54],
        [32, 58],
        [26, 54],
        [30, 58], // 35-40
    ];

    /**
     * Array Version information pattern (BCH coded).
     * See Table 1 in Appendix D (pp.68) of JIS X0510:2004.
     * size: [QRSPEC_VERSION_MAX - 6]
     */
    private array $versionPattern = [
        0x07c94,
        0x085bc,
        0x09a99,
        0x0a4d3,
        0x0bbf6,
        0x0c762,
        0x0d847,
        0x0e60d, //
        0x0f928,
        0x10b78,
        0x1145d,
        0x12a17,
        0x13532,
        0x149a6,
        0x15683,
        0x168c9, //
        0x177ec,
        0x18ec4,
        0x191e1,
        0x1afab,
        0x1b08e,
        0x1cc1a,
        0x1d33f,
        0x1ed75, //
        0x1f250,
        0x209d5,
        0x216f0,
        0x228ba,
        0x2379f,
        0x24b0b,
        0x2542e,
        0x26a64, //
        0x27541,
        0x28c69,
    ];

    /**
     * Array Format information
     */
    private array $formatInfo = [
        [0x77c4, 0x72f3, 0x7daa, 0x789d, 0x662f, 0x6318, 0x6c41, 0x6976], //
        [0x5412, 0x5125, 0x5e7c, 0x5b4b, 0x45f9, 0x40ce, 0x4f97, 0x4aa0], //
        [0x355f, 0x3068, 0x3f31, 0x3a06, 0x24b4, 0x2183, 0x2eda, 0x2bed], //
        [0x1689, 0x13be, 0x1ce7, 0x19d0, 0x0762, 0x0255, 0x0d0c, 0x083b], //
    ];

    /**
     * This is the class constructor - creates a QRcode object
     *
     * @param string $code
     */
    public function __construct($code, string $eclevel = 'L')
    {
        $barcodeArray = [];
        if ((is_null($code)) || ($code == '\0') || ($code == '')) {
            return;
        }

        // set error correction level
        $levelKey = array_search($eclevel, ['L', 'M', 'Q', 'H'], true);
        if (is_string($levelKey)) {
            $this->level = $levelKey;
        }

        if (($this->hint != self::QR_MODE_8B) && ($this->hint != self::QR_MODE_KJ)) {
            return;
        }

        if (($this->version < 0) || ($this->version > self::QRSPEC_VERSION_MAX)) {
            return;
        }

        $this->items = [];
        $this->encodeString($code);
        if (is_null($this->data)) {
            return;
        }

        $qrTab = $this->binarize($this->data);
        $size = is_countable($qrTab) ? count($qrTab) : 0;
        $barcodeArray['num_rows'] = $size;
        $barcodeArray['num_cols'] = $size;
        $barcodeArray['bcode'] = [];
        foreach ($qrTab as $line) {
            $arrAdd = [];
            foreach (str_split($line) as $char) {
                $arrAdd[] = ($char == '1') ? 1 : 0;
            }

            $barcodeArray['bcode'][] = $arrAdd;
        }

        $this->barcodeArray = $barcodeArray;
    }

    /**
     * Returns a barcode array which is readable by Dinesh Rabara
     */
    public function getBarcodeArray(): array
    {
        return $this->barcodeArray;
    }

    /**
     * Convert the frame in binary form
     *
     * @return mixed
     */
    private function binarize(array $frame)
    {
        $len = count($frame);
        // the frame is square (width = height)
        foreach ($frame as &$frameLine) {
            for ($i = 0; $i < $len; ++$i) {
                $frameLine[$i] = ((ord($frameLine[$i]) & 1) !== 0) ? '1' : '0';
            }
        }

        return $frame;
    }

    /**
     * Encode the input string to QR code
     *
     * @param string $string
     */
    private function encodeString($string)
    {
        $this->dataStr = $string;
        if (! $this->casesensitive) {
            $this->toUpper();
        }

        $ret = $this->splitString();
        if ($ret < 0) {
            return null;
        }

        $this->encodeMask(-1);
    }

    private function encodeMask(int $mask)
    {
        $spec = [0, 0, 0, 0, 0];
        $this->datacode = $this->getByteStream($this->items);
        if (is_null($this->datacode)) {
            return null;
        }

        $spec = $this->getEccSpec($this->version, $this->level, $spec);
        $this->b1 = $this->rsBlockNum1($spec);
        $this->dataLength = $this->rsDataLength($spec);
        $this->eccLength = $this->rsEccLength($spec);
        $this->ecccode = array_fill(0, $this->eccLength, 0);
        $this->blocks = $this->rsBlockNum($spec);
        $ret = $this->init($spec);
        if ($ret < 0) {
            return null;
        }

        $this->count = 0;
        $this->width = $this->getWidth($this->version);
        $this->frame = $this->newFrame($this->version);
        $this->x = $this->width - 1;
        $this->y = $this->width - 1;
        $this->dir = -1;
        $this->bit = -1;
        // inteleaved data and ecc codes
        for ($i = 0; $i < ($this->dataLength + $this->eccLength); ++$i) {
            $code = $this->getCode();
            $bit = 0x80;
            for ($j = 0; $j < 8; ++$j) {
                $addr = $this->getNextPosition();
                $this->setFrameAt($addr, 0x02 | (($bit & $code) != 0));
                $bit >>= 1;
            }
        }

        // remainder bits
        $j = $this->getRemainder($this->version);
        for ($i = 0; $i < $j; ++$i) {
            $addr = $this->getNextPosition();
            $this->setFrameAt($addr, 0x02);
        }

        // masking
        $this->runLength = array_fill(0, self::QRSPEC_WIDTH_MAX + 1, 0);
        if ($mask < 0) {
            if (self::QR_FIND_BEST_MASK) {
                $masked = $this->mask($this->width, $this->frame, $this->level);
            } else {
                $masked = $this->makeMask($this->width, $this->frame, (self::QR_DEFAULT_MASK % 8), $this->level);
            }
        } else {
            $masked = $this->makeMask($this->width, $this->frame, $mask, $this->level);
        }

        if ($masked == null) {
            return null;
        }

        $this->data = $masked;
    }

    /**
     * Set frame value at specified position
     *
     * @param array $at
     */
    private function setFrameAt($at, int $val): void
    {
        $this->frame[$at['y']][$at['x']] = chr($val);
    }

    /**
     * Get frame value at specified position
     *
     * @param array $at
     */
    private function getFrameAt($at): int
    {
        return ord($this->frame[$at['y']][$at['x']]);
    }

    /**
     * Return the next frame position
     *
     * @return array|null
     */
    private function getNextPosition()
    {
        do {
            if ($this->bit == -1) {
                $this->bit = 0;

                return [
                    'x' => $this->x,
                    'y' => $this->y,
                ];
            }

            $x = $this->x;
            $y = $this->y;
            $w = $this->width;
            if ($this->bit == 0) {
                --$x;
                ++$this->bit;
            } else {
                ++$x;
                $y += $this->dir;
                --$this->bit;
            }

            if ($this->dir < 0) {
                if ($y < 0) {
                    $y = 0;
                    $x -= 2;
                    $this->dir = 1;
                    if ($x == 6) {
                        --$x;
                        $y = 9;
                    }
                }
            } elseif ($y == $w) {
                $y = $w - 1;
                $x -= 2;
                $this->dir = -1;
                if ($x == 6) {
                    --$x;
                    $y -= 8;
                }
            }

            if (($x < 0) || ($y < 0)) {
                return null;
            }

            $this->x = $x;
            $this->y = $y;
        } while (ord($this->frame[$y][$x]) & 0x80);

        return [
            'x' => $x,
            'y' => $y,
        ];
    }

    /**
     * Initialize code
     *
     * @param array $spec
     *
     * @return int
     */
    private function init($spec)
    {
        $dl = $this->rsDataCodes1($spec);
        $el = $this->rsEccCodes1($spec);
        $rs = $this->init_rs(8, 0x11d, 0, 1, $el, 255 - $dl - $el);
        $blockNo = 0;
        $dataPos = 0;
        $eccPos = 0;
        $endfor = $this->rsBlockNum1($spec);
        for ($i = 0; $i < $endfor; ++$i) {
            $ecc = array_slice($this->ecccode, $eccPos);
            $this->rsblocks[$blockNo] = [];
            $this->rsblocks[$blockNo]['dataLength'] = $dl;
            $this->rsblocks[$blockNo]['data'] = array_slice($this->datacode, $dataPos);
            $this->rsblocks[$blockNo]['eccLength'] = $el;
            $ecc = $this->encode_rs_char($rs, $this->rsblocks[$blockNo]['data'], $ecc);
            $this->rsblocks[$blockNo]['ecc'] = $ecc;
            $this->ecccode = array_merge(array_slice($this->ecccode, 0, $eccPos), $ecc);
            $dataPos += $dl;
            $eccPos += $el;
            ++$blockNo;
        }

        if ($this->rsBlockNum2($spec) == 0) {
            return 0;
        }

        $dl = $this->rsDataCodes2($spec);
        $el = $this->rsEccCodes2($spec);
        $rs = $this->init_rs(8, 0x11d, 0, 1, $el, 255 - $dl - $el);
        if ($rs == null) {
            return -1;
        }

        $endfor = $this->rsBlockNum2($spec);
        for ($i = 0; $i < $endfor; ++$i) {
            $ecc = array_slice($this->ecccode, $eccPos);
            $this->rsblocks[$blockNo] = [];
            $this->rsblocks[$blockNo]['dataLength'] = $dl;
            $this->rsblocks[$blockNo]['data'] = array_slice($this->datacode, $dataPos);
            $this->rsblocks[$blockNo]['eccLength'] = $el;
            $ecc = $this->encode_rs_char($rs, $this->rsblocks[$blockNo]['data'], $ecc);
            $this->rsblocks[$blockNo]['ecc'] = $ecc;
            $this->ecccode = array_merge(array_slice($this->ecccode, 0, $eccPos), $ecc);
            $dataPos += $dl;
            $eccPos += $el;
            ++$blockNo;
        }

        return 0;
    }

    /**
     * Return Reed-Solomon block code.
     *
     * @return int
     */
    private function getCode()
    {
        if ($this->count < $this->dataLength) {
            $row = $this->count % $this->blocks;
            $col = (int) ($this->count / $this->blocks);
            if ($col >= $this->rsblocks[0]['dataLength']) {
                $row += $this->b1;
            }

            $ret = $this->rsblocks[$row]['data'][$col];
        } elseif ($this->count < $this->dataLength + $this->eccLength) {
            $row = ($this->count - $this->dataLength) % $this->blocks;
            $col = (int) (($this->count - $this->dataLength) / $this->blocks);
            $ret = $this->rsblocks[$row]['ecc'][$col];
        } else {
            return 0;
        }

        ++$this->count;

        return $ret;
    }

    /**
     * Write Format Information on frame and returns the number of black bits
     *
     * @param array &$frame
     * @param int   $mask
     *
     * @return int
     */
    private function writeFormatInformation(int $width, &$frame, $mask, int $level)
    {
        $blacks = 0;
        $format = $this->getFormatInfo($mask, $level);
        for ($i = 0; $i < 8; ++$i) {
            if (($format & 1) !== 0) {
                $blacks += 2;
                $v = 0x85;
            } else {
                $v = 0x84;
            }

            $frame[8][$width - 1 - $i] = chr($v);
            if ($i < 6) {
                $frame[$i][8] = chr($v);
            } else {
                $frame[$i + 1][8] = chr($v);
            }

            $format >>= 1;
        }

        for ($i = 0; $i < 7; ++$i) {
            if (($format & 1) !== 0) {
                $blacks += 2;
                $v = 0x85;
            } else {
                $v = 0x84;
            }

            $frame[$width - 7 + $i][8] = chr($v);
            if ($i == 0) {
                $frame[8][7] = chr($v);
            } else {
                $frame[8][6 - $i] = chr($v);
            }

            $format >>= 1;
        }

        return $blacks;
    }

    private function mask0(int $x, int $y): int
    {
        return ($x + $y) & 1;
    }

    private function mask1(int $x, int $y): int
    {
        return ($y & 1);
    }

    private function mask2(int $x, int $y): int
    {
        return ($x % 3);
    }

    private function mask3(int $x, int $y): int
    {
        return ($x + $y) % 3;
    }

    private function mask4(int $x, int $y): int
    {
        return (((int) ($y / 2)) + ((int) ($x / 3))) & 1;
    }

    private function mask5(int $x, int $y): int
    {
        return (($x * $y) & 1) + ($x * $y) % 3;
    }

    private function mask6(int $x, int $y): int
    {
        return ((($x * $y) & 1) + ($x * $y) % 3) & 1;
    }

    private function mask7(int $x, int $y): int
    {
        return ((($x * $y) % 3) + (($x + $y) & 1)) & 1;
    }

    /**
     * Return bitmask
     */
    private function generateMaskNo(int $maskNo, int $width, array $frame): array
    {
        $bitMask = array_fill(0, $width, array_fill(0, $width, 0));
        for ($y = 0; $y < $width; ++$y) {
            for ($x = 0; $x < $width; ++$x) {
                if ((ord($frame[$y][$x]) & 0x80) !== 0) {
                    $bitMask[$y][$x] = 0;
                } else {
                    // calling mask0() - mask7()
                    $maskFunc = call_user_func([$this, 'mask' . $maskNo], $x, $y);
                    $bitMask[$y][$x] = ($maskFunc === 0) ? 1 : 0;
                }
            }
        }

        return $bitMask;
    }

    private function makeMaskNo(int $maskNo, int $width, array $s, array &$d, bool $maskGenOnly = false): ?int
    {
        $b = 0;
        $bitMask = $this->generateMaskNo($maskNo, $width, $s);
        if ($maskGenOnly) {
            return null;
        }

        $d = $s;
        for ($y = 0; $y < $width; ++$y) {
            for ($x = 0; $x < $width; ++$x) {
                if ($bitMask[$y][$x] == 1) {
                    $d[$y][$x] = chr(ord($s[$y][$x]) ^ ((int) ($bitMask[$y][$x])));
                }

                $b += ord($d[$y][$x]) & 1;
            }
        }

        return $b;
    }

    private function makeMask(int $width, array $frame, int $maskNo, int $level): array
    {
        $masked = array_fill(0, $width, str_repeat("\0", $width));
        $this->makeMaskNo($maskNo, $width, $frame, $masked);
        $this->writeFormatInformation($width, $masked, $maskNo, $level);

        return $masked;
    }

    /**
     * calcN1N3
     */
    private function calcN1N3(int $length): int
    {
        $demerit = 0;
        for ($i = 0; $i < $length; ++$i) {
            if ($this->runLength[$i] >= 5) {
                $demerit += (self::N1 + ($this->runLength[$i] - 5));
            }

            if (($i & 1) !== 0 && (($i >= 3) && ($i < ($length - 2)) && ($this->runLength[$i] % 3 == 0))) {
                $fact = (int) ($this->runLength[$i] / 3);
                if (($this->runLength[$i - 2] == $fact)
                    && ($this->runLength[$i - 1] == $fact)
                    && ($this->runLength[$i + 1] == $fact)
                    && ($this->runLength[$i + 2] == $fact)
                ) {
                    if (($this->runLength[$i - 3] < 0) || ($this->runLength[$i - 3] >= (4 * $fact))) {
                        $demerit += self::N3;
                    } elseif ((($i + 3) >= $length) || ($this->runLength[$i + 3] >= (4 * $fact))) {
                        $demerit += self::N3;
                    }
                }
            }
        }

        return $demerit;
    }

    /**
     * evaluateSymbol
     *
     * @param array $frame
     *
     * @return int
     */
    private function evaluateSymbol(int $width, $frame)
    {
        $demerit = 0;
        $frameYM = [];

        for ($y = 0; $y < $width; ++$y) {
            $head = 0;
            $this->runLength[0] = 1;
            $frameY = $frame[$y];
            if ($y > 0) {
                $frameYM = $frame[$y - 1];
            }

            for ($x = 0; $x < $width; ++$x) {
                if (($x > 0) && ($y > 0)) {
                    $b22 = ord($frameY[$x]) & ord($frameY[$x - 1]) & ord($frameYM[$x]) & ord($frameYM[$x - 1]);
                    $w22 = ord($frameY[$x]) | ord($frameY[$x - 1]) | ord($frameYM[$x]) | ord($frameYM[$x - 1]);
                    if ((($b22 | ($w22 ^ 1)) & 1) !== 0) {
                        $demerit += self::N2;
                    }
                }

                if (($x == 0) && (ord($frameY[$x]) & 1)) {
                    $this->runLength[0] = -1;
                    $head = 1;
                    $this->runLength[$head] = 1;
                } elseif ($x > 0) {
                    if (((ord($frameY[$x]) ^ ord($frameY[$x - 1])) & 1) !== 0) {
                        ++$head;
                        $this->runLength[$head] = 1;
                    } else {
                        ++$this->runLength[$head];
                    }
                }
            }

            $demerit += $this->calcN1N3($head + 1);
        }

        for ($x = 0; $x < $width; ++$x) {
            $head = 0;
            $this->runLength[0] = 1;
            for ($y = 0; $y < $width; ++$y) {
                if (($y == 0) && (ord($frame[$y][$x]) & 1)) {
                    $this->runLength[0] = -1;
                    $head = 1;
                    $this->runLength[$head] = 1;
                } elseif ($y > 0) {
                    if (((ord($frame[$y][$x]) ^ ord($frame[$y - 1][$x])) & 1) !== 0) {
                        ++$head;
                        $this->runLength[$head] = 1;
                    } else {
                        ++$this->runLength[$head];
                    }
                }
            }

            $demerit += $this->calcN1N3($head + 1);
        }

        return $demerit;
    }

    /**
     * mask
     *
     * @return array
     */
    private function mask(int $width, array $frame, int $level)
    {
        $minDemerit = PHP_INT_MAX;
        $checkedMasks = [0, 1, 2, 3, 4, 5, 6, 7];
        $howManuOut = 8 - (self::QR_FIND_FROM_RANDOM % 9);
        for ($i = 0; $i < $howManuOut; ++$i) {
            $remPos = random_int(0, count($checkedMasks) - 1);
            unset($checkedMasks[$remPos]);
            $checkedMasks = array_values($checkedMasks);
        }

        $bestMask = $frame;
        foreach ($checkedMasks as $checkedMask) {
            $mask = array_fill(0, $width, str_repeat("\0", $width));
            $blacks = $this->makeMaskNo($checkedMask, $width, $frame, $mask);
            $blacks += $this->writeFormatInformation($width, $mask, $checkedMask, $level);
            $blacks = (int) (100 * $blacks / ($width * $width));
            $demerit = (int) (abs($blacks - 50) / 5) * self::N4;
            $demerit += $this->evaluateSymbol($width, $mask);
            if ($demerit < $minDemerit) {
                $minDemerit = $demerit;
                $bestMask = $mask;
            }
        }

        return $bestMask;
    }

    /**
     * Return true if the character at specified position is a number
     *
     * @param string $str
     * @param int    $pos
     */
    private function isdigitat($str, $pos): bool
    {
        if ($pos >= strlen($str)) {
            return false;
        }

        return ((ord($str[$pos]) >= ord('0')) && (ord($str[$pos]) <= ord('9')));
    }

    /**
     * Return true if the character at specified position is an alphanumeric character
     *
     * @param string $str
     * @param int    $pos
     *
     * @return bool
     */
    private function isalnumat($str, $pos)
    {
        if ($pos >= strlen($str)) {
            return false;
        }

        return ($this->lookAnTable(ord($str[$pos])) >= 0);
    }

    /**
     * identifyMode
     *
     * @param int $pos
     */
    private function identifyMode($pos): int
    {
        if ($pos >= strlen($this->dataStr)) {
            return self::QR_MODE_NL;
        }

        $c = $this->dataStr[$pos];
        if ($this->isdigitat($this->dataStr, $pos)) {
            return self::QR_MODE_NM;
        } elseif ($this->isalnumat($this->dataStr, $pos)) {
            return self::QR_MODE_AN;
        } elseif ($this->hint == self::QR_MODE_KJ) {
            if ($pos + 1 < strlen($this->dataStr)) {
                $d = $this->dataStr[$pos + 1];
                $word = (ord($c) << 8) | ord($d);
                if (($word >= 0x8140 && $word <= 0x9ffc) || ($word >= 0xe040 && $word <= 0xebbf)) {
                    return self::QR_MODE_KJ;
                }
            }
        }

        return self::QR_MODE_8B;
    }

    /**
     * eatNum
     * @return int run
     */
    private function eatNum()
    {
        $ln = $this->lengthIndicator(self::QR_MODE_NM, $this->version);
        $p = 0;
        while ($this->isdigitat($this->dataStr, $p)) {
            ++$p;
        }

        $run = $p;
        $mode = $this->identifyMode($p);
        if ($mode == self::QR_MODE_8B) {
            $dif = $this->estimateBitsModeNum($run) + 4 + $ln
                + $this->estimateBitsMode8(1) // + 4 + l8
                - $this->estimateBitsMode8($run + 1); // - 4 - l8
            if ($dif > 0) {
                return $this->eat8();
            }
        }

        if ($mode == self::QR_MODE_AN) {
            $dif = $this->estimateBitsModeNum($run) + 4 + $ln
                + $this->estimateBitsModeAn(1) // + 4 + la
                - $this->estimateBitsModeAn($run + 1);
            // - 4 - la
            if ($dif > 0) {
                return $this->eatAn();
            }
        }

        $this->items = $this->appendNewInputItem($this->items, self::QR_MODE_NM, $run, str_split($this->dataStr));

        return $run;
    }

    /**
     * eatAn
     * @return int run
     */
    private function eatAn()
    {
        $la = $this->lengthIndicator(self::QR_MODE_AN, $this->version);
        $ln = $this->lengthIndicator(self::QR_MODE_NM, $this->version);
        $p = 1;
        while ($this->isalnumat($this->dataStr, $p)) {
            if ($this->isdigitat($this->dataStr, $p)) {
                $q = $p;
                while ($this->isdigitat($this->dataStr, $q)) {
                    ++$q;
                }

                $dif = $this->estimateBitsModeAn($p) // + 4 + la
                    + $this->estimateBitsModeNum($q - $p) + 4 + $ln
                    - $this->estimateBitsModeAn($q); // - 4 - la
                if ($dif < 0) {
                    break;
                } else {
                    $p = $q;
                }
            } else {
                ++$p;
            }
        }

        $run = $p;
        if (! $this->isalnumat($this->dataStr, $p)) {
            $dif = $this->estimateBitsModeAn($run) + 4 + $la
                + $this->estimateBitsMode8(1) // + 4 + l8
                - $this->estimateBitsMode8($run + 1); // - 4 - l8
            if ($dif > 0) {
                return $this->eat8();
            }
        }

        $this->items = $this->appendNewInputItem($this->items, self::QR_MODE_AN, $run, str_split($this->dataStr));

        return $run;
    }

    /**
     * eatKanji
     *
     * @return int
     */
    private function eatKanji()
    {
        $p = 0;
        while ($this->identifyMode($p) == self::QR_MODE_KJ) {
            $p += 2;
        }

        $run = $p;
        $this->items = $this->appendNewInputItem($this->items, self::QR_MODE_KJ, $p, str_split($this->dataStr));

        return $run;
    }

    /**
     * eat8
     *
     * @return int run
     */
    private function eat8()
    {
        $la = $this->lengthIndicator(self::QR_MODE_AN, $this->version);
        $ln = $this->lengthIndicator(self::QR_MODE_NM, $this->version);
        $p = 1;
        $dataStrLen = strlen($this->dataStr);
        while ($p < $dataStrLen) {
            $mode = $this->identifyMode($p);
            if ($mode == self::QR_MODE_KJ) {
                break;
            }

            if ($mode == self::QR_MODE_NM) {
                $q = $p;
                while ($this->isdigitat($this->dataStr, $q)) {
                    ++$q;
                }

                $dif = $this->estimateBitsMode8($p) // + 4 + l8
                    + $this->estimateBitsModeNum($q - $p) + 4 + $ln
                    - $this->estimateBitsMode8($q); // - 4 - l8
                if ($dif < 0) {
                    break;
                } else {
                    $p = $q;
                }
            } elseif ($mode == self::QR_MODE_AN) {
                $q = $p;
                while ($this->isalnumat($this->dataStr, $q)) {
                    ++$q;
                }

                $dif = $this->estimateBitsMode8($p) // + 4 + l8
                    + $this->estimateBitsModeAn($q - $p) + 4 + $la
                    - $this->estimateBitsMode8($q); // - 4 - l8
                if ($dif < 0) {
                    break;
                } else {
                    $p = $q;
                }
            } else {
                ++$p;
            }
        }

        $run = $p;
        $this->items = $this->appendNewInputItem($this->items, self::QR_MODE_8B, $run, str_split($this->dataStr));

        return $run;
    }

    /**
     * splitString
     *
     * @return int
     */
    private function splitString()
    {
        while (strlen($this->dataStr) > 0) {
            if ($this->dataStr == '') {
                return 0;
            }

            $mode = $this->identifyMode(0);
            switch ($mode) {
                case self::QR_MODE_NM:
                    {
                        $length = $this->eatNum();
                        break;
                    }
                case self::QR_MODE_AN:
                    {
                        $length = $this->eatAn();
                        break;
                    }
                case self::QR_MODE_KJ:
                    {
                        $length = $this->hint == self::QR_MODE_KJ ? $this->eatKanji() : $this->eat8();

                        break;
                    }
                default:
                    {
                        $length = $this->eat8();
                        break;
                    }
            }

            if ($length == 0) {
                return 0;
            }

            if ($length < 0) {
                return -1;
            }

            $this->dataStr = substr($this->dataStr, $length);
        }

        return 0;
    }

    /**
     * toUpper
     *
     * @return string
     */
    private function toUpper()
    {
        $stringLen = strlen($this->dataStr);
        $p = 0;
        while ($p < $stringLen) {
            $mode = $this->identifyMode(substr($this->dataStr, $p));
            if ($mode == self::QR_MODE_KJ) {
                $p += 2;
            } else {
                if ((ord($this->dataStr[$p]) >= ord('a')) && (ord($this->dataStr[$p]) <= ord('z'))) {
                    $this->dataStr[$p] = chr(ord($this->dataStr[$p]) - 32);
                }

                ++$p;
            }
        }

        return $this->dataStr;
    }

    /**
     * newInputItem
     *
     * @param int   $mode
     * @param int   $size
     * @param array $data
     * @param array $bstream
     *
     * @return array|null
     */
    private function newInputItem($mode, $size, $data, $bstream = null)
    {
        $setData = array_slice($data, 0, $size);
        if (count($setData) < $size) {
            $setData = array_merge($setData, array_fill(0, ($size - count($setData)), 0));
        }

        if (! $this->check($mode, $size, $setData)) {
            return null;
        }

        $inputitem = [];
        $inputitem['mode'] = $mode;
        $inputitem['size'] = $size;
        $inputitem['data'] = $setData;
        $inputitem['bstream'] = $bstream;

        return $inputitem;
    }

    /**
     * encodeModeNum
     *
     * @param array $inputitem
     * @param int   $version
     *
     * @return mixed
     */
    private function encodeModeNum($inputitem, $version)
    {
        $words = (int) ($inputitem['size'] / 3);
        $inputitem['bstream'] = [];
        $val = 0x1;
        $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 4, $val);
        $inputitem['bstream'] = $this->appendNum(
            $inputitem['bstream'],
            $this->lengthIndicator(self::QR_MODE_NM, $version),
            $inputitem['size']
        );
        for ($i = 0; $i < $words; ++$i) {
            $val = (ord($inputitem['data'][$i * 3]) - ord('0')) * 100;
            $val += (ord($inputitem['data'][$i * 3 + 1]) - ord('0')) * 10;
            $val += (ord($inputitem['data'][$i * 3 + 2]) - ord('0'));
            $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 10, $val);
        }

        if ($inputitem['size'] - $words * 3 == 1) {
            $val = ord($inputitem['data'][$words * 3]) - ord('0');
            $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 4, $val);
        } elseif (($inputitem['size'] - ($words * 3)) == 2) {
            $val = (ord($inputitem['data'][$words * 3]) - ord('0')) * 10;
            $val += (ord($inputitem['data'][$words * 3 + 1]) - ord('0'));
            $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 7, $val);
        }

        return $inputitem;
    }

    /**
     * encodeModeAn
     *
     * @param array $inputitem
     * @param int   $version
     *
     * @return mixed
     */
    private function encodeModeAn($inputitem, $version)
    {
        $words = (int) ($inputitem['size'] / 2);
        $inputitem['bstream'] = [];
        $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 4, 0x02);
        $inputitem['bstream'] = $this->appendNum(
            $inputitem['bstream'],
            $this->lengthIndicator(self::QR_MODE_AN, $version),
            $inputitem['size']
        );
        for ($i = 0; $i < $words; ++$i) {
            $val = $this->lookAnTable(ord($inputitem['data'][$i * 2])) * 45;
            $val += (int) ($this->lookAnTable(ord($inputitem['data'][($i * 2) + 1])));
            $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 11, $val);
        }

        if (($inputitem['size'] & 1) !== 0) {
            $val = $this->lookAnTable(ord($inputitem['data'][($words * 2)]));
            $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 6, $val);
        }

        return $inputitem;
    }

    /**
     * encodeMode8
     *
     * @param array $inputitem
     * @param int   $version
     *
     * @return mixed
     */
    private function encodeMode8($inputitem, $version)
    {
        $inputitem['bstream'] = [];
        $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 4, 0x4);
        $inputitem['bstream'] = $this->appendNum(
            $inputitem['bstream'],
            $this->lengthIndicator(self::QR_MODE_8B, $version),
            $inputitem['size']
        );
        for ($i = 0; $i < $inputitem['size']; ++$i) {
            $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 8, ord($inputitem['data'][$i]));
        }

        return $inputitem;
    }

    /**
     * encodeModeKanji
     *
     * @param array $inputitem
     * @param int   $version
     *
     * @return mixed
     */
    private function encodeModeKanji($inputitem, $version)
    {
        $inputitem['bstream'] = [];
        $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 4, 0x8);
        $inputitem['bstream'] = $this->appendNum(
            $inputitem['bstream'],
            $this->lengthIndicator(self::QR_MODE_KJ, $version),
            (int) ($inputitem['size'] / 2)
        );
        for ($i = 0; $i < $inputitem['size']; $i += 2) {
            $val = (ord($inputitem['data'][$i]) << 8) | ord($inputitem['data'][$i + 1]);
            if ($val <= 0x9ffc) {
                $val -= 0x8140;
            } else {
                $val -= 0xc140;
            }

            $h = ($val >> 8) * 0xc0;
            $val = ($val & 0xff) + $h;
            $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 13, $val);
        }

        return $inputitem;
    }

    /**
     * encodeModeStructure
     *
     * @param array $inputitem
     *
     * @return mixed
     */
    private function encodeModeStructure($inputitem)
    {
        $inputitem['bstream'] = [];
        $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 4, 0x03);
        $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 4, ord($inputitem['data'][1]) - 1);
        $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 4, ord($inputitem['data'][0]) - 1);
        $inputitem['bstream'] = $this->appendNum($inputitem['bstream'], 8, ord($inputitem['data'][2]));

        return $inputitem;
    }

    /**
     * encodeBitStream
     *
     * @param array $inputitem
     * @param int   $version
     *
     * @return mixed
     */
    private function encodeBitStream($inputitem, $version)
    {
        $inputitem['bstream'] = [];
        $words = $this->maximumWords($inputitem['mode'], $version);
        if ($inputitem['size'] > $words) {
            $st1 = $this->newInputItem($inputitem['mode'], $words, $inputitem['data']);
            $st2 = $this->newInputItem(
                $inputitem['mode'],
                $inputitem['size'] - $words,
                array_slice($inputitem['data'], $words)
            );
            $st1 = $this->encodeBitStream($st1, $version);
            $st2 = $this->encodeBitStream($st2, $version);
            $inputitem['bstream'] = [];
            $inputitem['bstream'] = $this->appendBitstream($inputitem['bstream'], $st1['bstream']);
            $inputitem['bstream'] = $this->appendBitstream($inputitem['bstream'], $st2['bstream']);
        } else {
            switch ($inputitem['mode']) {
                case self::QR_MODE_NM:
                    {
                        $inputitem = $this->encodeModeNum($inputitem, $version);
                        break;
                    }
                case self::QR_MODE_AN:
                    {
                        $inputitem = $this->encodeModeAn($inputitem, $version);
                        break;
                    }
                case self::QR_MODE_8B:
                    {
                        $inputitem = $this->encodeMode8($inputitem, $version);
                        break;
                    }
                case self::QR_MODE_KJ:
                    {
                        $inputitem = $this->encodeModeKanji($inputitem, $version);
                        break;
                    }
                case self::QR_MODE_ST:
                    {
                        $inputitem = $this->encodeModeStructure($inputitem);
                        break;
                    }
                default:
                    {
                        break;
                    }
            }
        }

        return $inputitem;
    }

    /**
     * Append data to an input object - The data is copied and appended to the input object.
     *
     * @param array $items
     *
     * @return array
     */
    private function appendNewInputItem($items, int $mode, int $size, array $data)
    {
        $newitem = $this->newInputItem($mode, $size, $data);
        if (! empty($newitem)) {
            $items[] = $newitem;
        }

        return $items;
    }

    /**
     * checkModeNum
     *
     * @param int   $size
     */
    private function checkModeNum($size, array $data): bool
    {
        for ($i = 0; $i < $size; ++$i) {
            if ((ord($data[$i]) < ord('0')) || (ord($data[$i]) > ord('9'))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Look up the alphabet-numeric convesion table (see JIS X0510:2004, pp.19).
     *
     * @return int
     */
    private function lookAnTable(int $c)
    {
        return (($c > 127) ? -1 : $this->anTable[$c]);
    }

    /**
     * checkModeAn
     *
     * @param int   $size
     */
    private function checkModeAn($size, array $data): bool
    {
        for ($i = 0; $i < $size; ++$i) {
            if ($this->lookAnTable(ord($data[$i])) == -1) {
                return false;
            }
        }

        return true;
    }

    /**
     * estimateBitsModeNum
     *
     * @param int $size
     *
     * @return int
     */
    private function estimateBitsModeNum($size)
    {
        $w = (int) ($size / 3);
        $bits = ($w * 10);
        if ($size - ($w * 3) == 1) {
            $bits += 4;
        } elseif ($size - ($w * 3) == 2) {
            $bits += 7;
        }

        return $bits;
    }

    /**
     * estimateBitsModeAn
     *
     * @param int $size
     *
     * @return int
     */
    private function estimateBitsModeAn($size)
    {
        $bits = (int) ($size * 5.5); // (size / 2 ) * 11
        if (($size & 1) !== 0) {
            $bits += 6;
        }

        return $bits;
    }

    /**
     * estimateBitsMode8
     *
     * @param int $size
     */
    private function estimateBitsMode8($size): int
    {
        return $size * 8;
    }

    /**
     * estimateBitsModeKanji
     *
     * @param int $size
     */
    private function estimateBitsModeKanji($size): int
    {
        return (int) ($size * 6.5); // (size / 2 ) * 13
    }

    /**
     * checkModeKanji
     *
     * @param int   $size
     */
    private function checkModeKanji($size, array $data): bool
    {
        if (($size & 1) !== 0) {
            return false;
        }

        for ($i = 0; $i < $size; $i += 2) {
            $val = (ord($data[$i]) << 8) | ord($data[$i + 1]);
            if (($val < 0x8140) || (($val > 0x9ffc) && ($val < 0xe040)) || ($val > 0xebbf)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate the input data.
     *
     * @param int   $mode
     * @param int   $size
     */
    private function check($mode, $size, array $data): bool
    {
        if ($size <= 0) {
            return false;
        }

        switch ($mode) {
            case self::QR_MODE_NM:
                return $this->checkModeNum($size, $data);
            case self::QR_MODE_AN:
                return $this->checkModeAn($size, $data);
            case self::QR_MODE_KJ:
                return $this->checkModeKanji($size, $data);
            case self::QR_MODE_8B:
            case self::QR_MODE_ST:
                return true;
            default:
                break;
        }

        return false;
    }

    /**
     * estimateBitStreamSize
     *
     * @param array $items
     * @param int   $version
     *
     * @return int
     */
    private function estimateBitStreamSize($items, $version)
    {
        $bits = 0;
        if ($version == 0) {
            $version = 1;
        }

        foreach ($items as $item) {
            switch ($item['mode']) {
                case self::QR_MODE_NM:
                    {
                        $bits = $this->estimateBitsModeNum($item['size']);
                        break;
                    }
                case self::QR_MODE_AN:
                    {
                        $bits = $this->estimateBitsModeAn($item['size']);
                        break;
                    }
                case self::QR_MODE_8B:
                    {
                        $bits = $this->estimateBitsMode8($item['size']);
                        break;
                    }
                case self::QR_MODE_KJ:
                    {
                        $bits = $this->estimateBitsModeKanji($item['size']);
                        break;
                    }
                case self::QR_MODE_ST:
                    {
                        return self::STRUCTURE_HEADER_BITS;
                    }
                default:
                    {
                        return 0;
                    }
            }

            $l = $this->lengthIndicator($item['mode'], $version);
            $m = 1 << $l;
            $num = (int) (($item['size'] + $m - 1) / $m);
            $bits += $num * (4 + $l);
        }

        return $bits;
    }

    /**
     * estimateVersion
     *
     * @param array $items
     *
     * @return int
     */
    private function estimateVersion($items)
    {
        $version = 0;

        do {
            $prev = $version;
            $bits = $this->estimateBitStreamSize($items, $prev);
            $version = $this->getMinimumVersion((int) (($bits + 7) / 8), $this->level);
            if ($version < 0) {
                return -1;
            }
        } while ($version > $prev);

        return $version;
    }

    /**
     * lengthOfCode
     *
     * @param int $mode
     * @param int $version
     * @param int $bits
     *
     * @return int
     */
    private function lengthOfCode($mode, $version, $bits)
    {
        $payload = $bits - 4 - $this->lengthIndicator($mode, $version);
        switch ($mode) {
            case self::QR_MODE_NM:
                {
                    $chunks = (int) ($payload / 10);
                    $remain = $payload - $chunks * 10;
                    $size = $chunks * 3;
                    if ($remain >= 7) {
                        $size += 2;
                    } elseif ($remain >= 4) {
                        ++$size;
                    }

                    break;
                }
            case self::QR_MODE_AN:
                {
                    $chunks = (int) ($payload / 11);
                    $remain = $payload - $chunks * 11;
                    $size = $chunks * 2;
                    if ($remain >= 6) {
                        ++$size;
                    }

                    break;
                }
            case self::QR_MODE_8B:
                {
                    $size = (int) ($payload / 8);
                    break;
                }
            case self::QR_MODE_KJ:
                {
                    $size = (int) (($payload / 13) * 2);
                    break;
                }
            case self::QR_MODE_ST:
                {
                    $size = (int) ($payload / 8);
                    break;
                }
            default:
                {
                    $size = 0;
                    break;
                }
        }

        $maxsize = $this->maximumWords($mode, $version);
        if ($size < 0) {
            $size = 0;
        }

        if ($size > $maxsize) {
            $size = $maxsize;
        }

        return $size;
    }

    /**
     * createBitStream
     *
     * @param array $items
     */
    private function createBitStream($items): array
    {
        $total = 0;
        foreach ($items as $key => $item) {
            $items[$key] = $this->encodeBitStream($item, $this->version);
            $bits = is_countable($items[$key]['bstream']) ? count($items[$key]['bstream']) : 0;
            $total += $bits;
        }

        return [$items, $total];
    }

    /**
     * convertData
     *
     * @param array $items
     *
     * @return int
     */
    private function convertData($items)
    {
        $ver = $this->estimateVersion($items);
        if ($ver > $this->version) {
            $this->version = $ver;
        }

        for (; ;) {
            $cbs = $this->createBitStream($items);
            $items = $cbs[0];
            $bits = $cbs[1];
            if ($bits < 0) {
                return -1;
            }

            $ver = $this->getMinimumVersion((int) (($bits + 7) / 8), $this->level);
            if ($ver < 0) {
                return -1;
            } elseif ($ver > $this->version) {
                $this->version = $ver;
            } else {
                break;
            }
        }

        return $items;
    }

    /**
     * Append Padding Bit to bitstream
     *
     * @param array $bstream
     *
     * @return array|null
     */
    private function appendPaddingBit($bstream)
    {
        if (is_null($bstream)) {
            return null;
        }

        $bits = count($bstream);
        $maxwords = $this->getDataLength($this->version, $this->level);
        $maxbits = $maxwords * 8;
        if ($maxbits == $bits) {
            return $bstream;
        }

        if ($maxbits - $bits < 5) {
            return $this->appendNum($bstream, $maxbits - $bits, 0);
        }

        $bits += 4;
        $words = (int) (($bits + 7) / 8);
        $padding = [];
        $padding = $this->appendNum($padding, $words * 8 - $bits + 4, 0);

        $padlen = $maxwords - $words;
        if ($padlen > 0) {
            $padbuf = [];
            for ($i = 0; $i < $padlen; ++$i) {
                $padbuf[$i] = (($i & 1) !== 0) ? 0x11 : 0xec;
            }

            $padding = $this->appendBytes($padding, $padlen, $padbuf);
        }

        return $this->appendBitstream($bstream, $padding);
    }

    /**
     * mergeBitStream
     *
     * @param array $items
     *
     * @return array|null
     */
    private function mergeBitStream($items)
    {
        $items = $this->convertData($items);
        if (! is_array($items)) {
            return null;
        }

        $bstream = [];
        foreach ($items as $item) {
            $bstream = $this->appendBitstream($bstream, $item['bstream']);
        }

        return $bstream;
    }

    /**
     * Returns a stream of bits
     *
     * @param array $items
     *
     * @return array|null
     */
    private function getBitStream($items)
    {
        $bstream = $this->mergeBitStream($items);

        return $this->appendPaddingBit($bstream);
    }

    /**
     * Pack all bit streams padding bits into a byte array.
     *
     * @param array $items
     *
     * @return array
     */
    private function getByteStream($items)
    {
        $bstream = $this->getBitStream($items);

        return $this->bitstreamToByte($bstream);
    }

    /**
     * Return an array with zeros
     *
     * @param int $setLength
     */
    private function allocate($setLength): array
    {
        return array_fill(0, $setLength, 0);
    }

    /**
     * Return new bitstream from number
     *
     * @param int $bits
     * @param int $num
     *
     * @return array
     */
    private function newFromNum($bits, $num)
    {
        $bstream = $this->allocate($bits);
        $mask = 1 << ($bits - 1);
        for ($i = 0; $i < $bits; ++$i) {
            $bstream[$i] = ($num & $mask) !== 0 ? 1 : 0;

            $mask >>= 1;
        }

        return $bstream;
    }

    /**
     * Return new bitstream from bytes
     *
     * @param int   $size
     *
     * @return array
     */
    private function newFromBytes($size, array $data)
    {
        $bstream = $this->allocate($size * 8);
        $p = 0;
        for ($i = 0; $i < $size; ++$i) {
            $mask = 0x80;
            for ($j = 0; $j < 8; ++$j) {
                $bstream[$p] = ($data[$i] & $mask) !== 0 ? 1 : 0;

                ++$p;
                $mask >>= 1;
            }
        }

        return $bstream;
    }

    /**
     * Append one bitstream to another
     *
     * @param array $bitstream
     * @param array $append
     *
     * @return array
     */
    private function appendBitstream($bitstream, $append)
    {
        if ((! is_array($append)) || (count($append) == 0)) {
            return $bitstream;
        }

        if (count($bitstream) == 0) {
            return $append;
        }

        return array_values(array_merge($bitstream, $append));
    }

    /**
     * Append one bitstream created from number to another
     *
     * @param array $bitstream
     * @param int   $bits
     * @param int   $num
     *
     * @return array|int
     */
    private function appendNum($bitstream, $bits, $num)
    {
        if ($bits == 0) {
            return 0;
        }

        $b = $this->newFromNum($bits, $num);

        return $this->appendBitstream($bitstream, $b);
    }

    /**
     * Append one bitstream created from bytes to another
     *
     * @param array $bitstream
     * @param int   $size
     *
     * @return array|int
     */
    private function appendBytes($bitstream, $size, array $data)
    {
        if ($size == 0) {
            return 0;
        }

        $b = $this->newFromBytes($size, $data);

        return $this->appendBitstream($bitstream, $b);
    }

    /**
     * Convert bitstream to bytes
     *
     * @param array $bstream
     *
     * @return array|null
     */
    private function bitstreamToByte($bstream)
    {
        if (is_null($bstream)) {
            return null;
        }

        $size = count($bstream);
        if ($size == 0) {
            return [];
        }

        $data = array_fill(0, (int) (($size + 7) / 8), 0);
        $bytes = (int) ($size / 8);
        $p = 0;
        for ($i = 0; $i < $bytes; ++$i) {
            $v = 0;
            for ($j = 0; $j < 8; ++$j) {
                $v <<= 1;
                $v |= $bstream[$p];
                ++$p;
            }

            $data[$i] = $v;
        }

        if (($size & 7) !== 0) {
            $v = 0;
            for ($j = 0; $j < ($size & 7); ++$j) {
                $v <<= 1;
                $v |= $bstream[$p];
                ++$p;
            }

            $data[$bytes] = $v;
        }

        return $data;
    }

    /**
     * Replace a value on the array at the specified position
     *
     * @param array  $srctab
     * @param int    $x
     * @param int    $y
     * @param bool   $replLen
     *
     * @return mixed
     */
    private function qrstrset($srctab, $x, $y, string $repl, $replLen = false)
    {
        $srctab[$y] = substr_replace(
            $srctab[$y],
            ($replLen) ? substr($repl, 0, $replLen) : $repl,
            $x,
            $replLen ?: strlen($repl)
        );

        return $srctab;
    }

    /**
     * Return maximum data code length (bytes) for the version.
     *
     * @return mixed
     */
    private function getDataLength(int $version, int $level)
    {
        return $this->capacity[$version][self::QRCAP_WORDS] - $this->capacity[$version][self::QRCAP_EC][$level];
    }

    /**
     * Return maximum error correction code length (bytes) for the version.
     *
     * @return mixed
     */
    private function getECCLength(int $version, int $level)
    {
        return $this->capacity[$version][self::QRCAP_EC][$level];
    }

    /**
     * Return the width of the symbol for the version.
     *
     * @return mixed
     */
    private function getWidth(int $version)
    {
        return $this->capacity[$version][self::QRCAP_WIDTH];
    }

    /**
     * Return the number of remainder bits.
     *
     * @return mixed
     */
    private function getRemainder(int $version)
    {
        return $this->capacity[$version][self::QRCAP_REMINDER];
    }

    /**
     * Return a version number that satisfies the input code length.
     *
     * @return int
     */
    private function getMinimumVersion(int $size, int $level)
    {
        for ($i = 1; $i <= self::QRSPEC_VERSION_MAX; ++$i) {
            $words = $this->capacity[$i][self::QRCAP_WORDS] - $this->capacity[$i][self::QRCAP_EC][$level];
            if ($words >= $size) {
                return $i;
            }
        }

        return -1;
    }

    /**
     * Return the size of length indicator for the mode and version.
     *
     * @param int $mode
     * @param int $version
     *
     * @return int
     */
    private function lengthIndicator($mode, $version)
    {
        if ($mode == self::QR_MODE_ST) {
            return 0;
        }

        if ($version <= 9) {
            $l = 0;
        } elseif ($version <= 26) {
            $l = 1;
        } else {
            $l = 2;
        }

        return $this->lengthTableBits[$mode][$l];
    }

    /**
     * Return the maximum length for the mode and version.
     *
     * @param int $mode
     * @param int $version
     *
     * @return int
     */
    private function maximumWords($mode, $version)
    {
        if ($mode == self::QR_MODE_ST) {
            return 3;
        }

        if ($version <= 9) {
            $l = 0;
        } elseif ($version <= 26) {
            $l = 1;
        } else {
            $l = 2;
        }

        $bits = $this->lengthTableBits[$mode][$l];
        $words = (1 << $bits) - 1;
        if ($mode == self::QR_MODE_KJ) {
            $words *= 2; // the number of bytes is required
        }

        return $words;
    }

    /**
     * Return an array of ECC specification.
     *
     * @return array
     */
    private function getEccSpec(int $version, int $level, array $spec)
    {
        if (count($spec) < 5) {
            $spec = [0, 0, 0, 0, 0];
        }

        $b1 = $this->eccTable[$version][$level][0];
        $b2 = $this->eccTable[$version][$level][1];
        $data = $this->getDataLength($version, $level);
        $ecc = $this->getECCLength($version, $level);
        if ($b2 == 0) {
            $spec[0] = $b1;
            $spec[1] = (int) ($data / $b1);
            $spec[2] = (int) ($ecc / $b1);
            $spec[3] = 0;
            $spec[4] = 0;
        } else {
            $spec[0] = $b1;
            $spec[1] = (int) ($data / ($b1 + $b2));
            $spec[2] = (int) ($ecc / ($b1 + $b2));
            $spec[3] = $b2;
            $spec[4] = $spec[1] + 1;
        }

        return $spec;
    }

    /**
     * Put an alignment marker.
     *
     * @param array $frame
     * @param int   $ox
     * @param int   $oy
     *
     * @return mixed
     */
    private function putAlignmentMarker($frame, $ox, $oy)
    {
        $finder = [
            "\xa1\xa1\xa1\xa1\xa1",
            "\xa1\xa0\xa0\xa0\xa1",
            "\xa1\xa0\xa1\xa0\xa1",
            "\xa1\xa0\xa0\xa0\xa1",
            "\xa1\xa1\xa1\xa1\xa1",
        ];
        $yStart = $oy - 2;
        $xStart = $ox - 2;
        for ($y = 0; $y < 5; ++$y) {
            $frame = $this->qrstrset($frame, $xStart, $yStart + $y, $finder[$y]);
        }

        return $frame;
    }

    /**
     * Put an alignment pattern.
     *
     * @param array $frame
     * @param int   $width
     *
     * @return mixed
     */
    private function putAlignmentPattern(int $version, $frame, $width)
    {
        if ($version < 2) {
            return $frame;
        }

        $d = $this->alignmentPattern[$version][1] - $this->alignmentPattern[$version][0];
        $w = $d < 0 ? 2 : (int) (($width - $this->alignmentPattern[$version][0]) / $d + 2);

        if ($w * $w - 3 == 1) {
            $x = $this->alignmentPattern[$version][0];
            $y = $this->alignmentPattern[$version][0];

            return $this->putAlignmentMarker($frame, $x, $y);
        }

        $cx = $this->alignmentPattern[$version][0];
        $wo = $w - 1;
        for ($x = 1; $x < $wo; ++$x) {
            $frame = $this->putAlignmentMarker($frame, 6, $cx);
            $frame = $this->putAlignmentMarker($frame, $cx, 6);
            $cx += $d;
        }

        $cy = $this->alignmentPattern[$version][0];
        for ($y = 0; $y < $wo; ++$y) {
            $cx = $this->alignmentPattern[$version][0];
            for ($x = 0; $x < $wo; ++$x) {
                $frame = $this->putAlignmentMarker($frame, $cx, $cy);
                $cx += $d;
            }

            $cy += $d;
        }

        return $frame;
    }

    /**
     * Return BCH encoded version information pattern that is used for the symbol of version 7 or greater. Use lower 18 bits.
     *
     * @return int
     */
    private function getVersionPattern(int $version)
    {
        if (($version < 7) || ($version > self::QRSPEC_VERSION_MAX)) {
            return 0;
        }

        return $this->versionPattern[($version - 7)];
    }

    /**
     * Return BCH encoded format information pattern.
     *
     * @param int $mask
     *
     * @return int
     */
    private function getFormatInfo($mask, int $level)
    {
        if (($mask < 0) || ($mask > 7)) {
            return 0;
        }

        if (($level < 0) || ($level > 3)) {
            return 0;
        }

        return $this->formatInfo[$level][$mask];
    }

    /**
     * Put a finder pattern.
     *
     * @param array $frame
     * @param int   $ox
     * @param int   $oy
     *
     * @return mixed
     */
    private function putFinderPattern($frame, $ox, $oy)
    {
        $finder = [
            "\xc1\xc1\xc1\xc1\xc1\xc1\xc1",
            "\xc1\xc0\xc0\xc0\xc0\xc0\xc1",
            "\xc1\xc0\xc1\xc1\xc1\xc0\xc1",
            "\xc1\xc0\xc1\xc1\xc1\xc0\xc1",
            "\xc1\xc0\xc1\xc1\xc1\xc0\xc1",
            "\xc1\xc0\xc0\xc0\xc0\xc0\xc1",
            "\xc1\xc1\xc1\xc1\xc1\xc1\xc1",
        ];
        for ($y = 0; $y < 7; ++$y) {
            $frame = $this->qrstrset($frame, $ox, ($oy + $y), $finder[$y]);
        }

        return $frame;
    }

    /**
     * Return a copy of initialized frame.
     *
     * @return array|mixed
     */
    private function createFrame(int $version)
    {
        $width = $this->capacity[$version][self::QRCAP_WIDTH];
        $frameLine = str_repeat("\0", $width);
        $frame = array_fill(0, $width, $frameLine);
        // Finder pattern
        $frame = $this->putFinderPattern($frame, 0, 0);
        $frame = $this->putFinderPattern($frame, $width - 7, 0);
        $frame = $this->putFinderPattern($frame, 0, $width - 7);
        // Separator
        $yOffset = $width - 7;
        for ($y = 0; $y < 7; ++$y) {
            $frame[$y][7] = "\xc0";
            $frame[$y][$width - 8] = "\xc0";
            $frame[$yOffset][7] = "\xc0";
            ++$yOffset;
        }

        $setPattern = str_repeat("\xc0", 8);
        $frame = $this->qrstrset($frame, 0, 7, $setPattern);
        $frame = $this->qrstrset($frame, $width - 8, 7, $setPattern);
        $frame = $this->qrstrset($frame, 0, $width - 8, $setPattern);
        // Format info
        $setPattern = str_repeat("\x84", 9);
        $frame = $this->qrstrset($frame, 0, 8, $setPattern);
        $frame = $this->qrstrset($frame, $width - 8, 8, $setPattern, 8);

        $yOffset = $width - 8;
        for ($y = 0; $y < 8; ++$y, ++$yOffset) {
            $frame[$y][8] = "\x84";
            $frame[$yOffset][8] = "\x84";
        }

        // Timing pattern
        $wo = $width - 15;
        for ($i = 1; $i < $wo; ++$i) {
            $frame[6][7 + $i] = chr(0x90 | ($i & 1));
            $frame[7 + $i][6] = chr(0x90 | ($i & 1));
        }

        // Alignment pattern
        $frame = $this->putAlignmentPattern($version, $frame, $width);
        // Version information
        if ($version >= 7) {
            $vinf = $this->getVersionPattern($version);
            $v = $vinf;
            for ($x = 0; $x < 6; ++$x) {
                for ($y = 0; $y < 3; ++$y) {
                    $frame[($width - 11) + $y][$x] = chr(0x88 | ($v & 1));
                    $v >>= 1;
                }
            }

            $v = $vinf;
            for ($y = 0; $y < 6; ++$y) {
                for ($x = 0; $x < 3; ++$x) {
                    $frame[$y][$x + ($width - 11)] = chr(0x88 | ($v & 1));
                    $v >>= 1;
                }
            }
        }

        // and a little bit...
        $frame[$width - 8][8] = "\x81";

        return $frame;
    }

    /**
     * Set new frame for the specified version.
     */
    private function newFrame(int $version)
    {
        if (($version < 1) || ($version > self::QRSPEC_VERSION_MAX)) {
            return null;
        }

        if (! isset($this->frames[$version])) {
            $this->frames[$version] = $this->createFrame($version);
        }

        if (is_null($this->frames[$version])) {
            return null;
        }

        return $this->frames[$version];
    }

    /**
     * Return block number 0
     *
     * @param array $spec
     *
     * @return mixed
     */
    private function rsBlockNum($spec)
    {
        return ($spec[0] + $spec[3]);
    }

    /**
     * Return block number 1
     *
     * @param array $spec
     *
     * @return mixed
     */
    private function rsBlockNum1($spec)
    {
        return $spec[0];
    }

    /**
     * Return data codes 1
     *
     * @param array $spec
     *
     * @return mixed
     */
    private function rsDataCodes1($spec)
    {
        return $spec[1];
    }

    /**
     * Return ecc codes 1
     *
     * @param array $spec
     *
     * @return mixed
     */
    private function rsEccCodes1($spec)
    {
        return $spec[2];
    }

    /**
     * Return block number 2
     *
     * @param array $spec
     *
     * @return mixed
     */
    private function rsBlockNum2($spec)
    {
        return $spec[3];
    }

    /**
     * Return data codes 2
     *
     * @param array $spec
     *
     * @return mixed
     */
    private function rsDataCodes2($spec)
    {
        return $spec[4];
    }

    /**
     * Return ecc codes 2
     *
     * @param array $spec
     *
     * @return mixed
     */
    private function rsEccCodes2($spec)
    {
        return $spec[2];
    }

    /**
     * Return data length
     *
     * @param array $spec
     *
     * @return mixed
     */
    private function rsDataLength($spec)
    {
        return ($spec[0] * $spec[1]) + ($spec[3] * $spec[4]);
    }

    /**
     * Return ecc length
     *
     * @param array $spec
     *
     * @return mixed
     */
    private function rsEccLength($spec)
    {
        return ($spec[0] + $spec[3]) * $spec[2];
    }

    /**
     * Initialize a Reed-Solomon codec and add it to existing rsitems
     *
     * @param int $nroots
     * @param int $pad
     *
     * @return array
     */
    private function init_rs(int $symsize, int $gfpoly, int $fcr, int $prim, $nroots, $pad)
    {
        foreach ($this->rsitems as $rs) {
            if (($rs['pad'] != $pad) || ($rs['nroots'] != $nroots) || ($rs['mm'] != $symsize)
                || ($rs['gfpoly'] != $gfpoly) || ($rs['fcr'] != $fcr) || ($rs['prim'] != $prim)
            ) {
                continue;
            }

            return $rs;
        }

        $rs = $this->init_rs_char($symsize, $gfpoly, $fcr, $prim, $nroots, $pad);
        array_unshift($this->rsitems, $rs);

        return $rs;
    }

    /**
     * modnn
     *
     * @param array $rs
     * @param int   $x
     *
     * @return int
     */
    private function modnn($rs, $x)
    {
        while ($x >= $rs['nn']) {
            $x -= $rs['nn'];
            $x = ($x >> $rs['mm']) + ($x & $rs['nn']);
        }

        return $x;
    }

    /**
     * Initialize a Reed-Solomon codec and returns an array of values.
     *
     * @param int $nroots
     * @param int $pad
     *
     * @return array|null
     */
    private function init_rs_char(int $symsize, int $gfpoly, int $fcr, int $prim, $nroots, $pad)
    {
        // Based on Reed solomon encoder by Phil Karn, KA9Q (GNU-LGPLv2)
        $rs = null;
        // Check parameter ranges
        if (($symsize < 0) || ($symsize > 8)) {
            return $rs;
        }

        if (($fcr < 0) || ($fcr >= (1 << $symsize))) {
            return $rs;
        }

        if (($prim <= 0) || ($prim >= (1 << $symsize))) {
            return $rs;
        }

        if (($nroots < 0) || ($nroots >= (1 << $symsize))) {
            return $rs;
        }

        if (($pad < 0) || ($pad >= ((1 << $symsize) - 1 - $nroots))) {
            return $rs;
        }

        $rs = [];
        $rs['mm'] = $symsize;
        $rs['nn'] = (1 << $symsize) - 1;
        $rs['pad'] = $pad;
        $rs['alpha_to'] = array_fill(0, ($rs['nn'] + 1), 0);
        $rs['index_of'] = array_fill(0, ($rs['nn'] + 1), 0);
        // PHP style macro replacement ;)
        $nn = &$rs['nn'];
        $a0 = &$nn;
        // Generate Galois field lookup tables
        $rs['index_of'][0] = $a0; // log(zero) = -inf
        $rs['alpha_to'][$a0] = 0; // alpha**-inf = 0
        $sr = 1;
        for ($i = 0; $i < $rs['nn']; ++$i) {
            $rs['index_of'][$sr] = $i;
            $rs['alpha_to'][$i] = $sr;
            $sr <<= 1;
            if (($sr & (1 << $symsize)) !== 0) {
                $sr ^= $gfpoly;
            }

            $sr &= $rs['nn'];
        }

        if ($sr != 1) {
            // field generator polynomial is not primitive!
            return null;
        }

        // Form RS code generator polynomial from its roots
        $rs['genpoly'] = array_fill(0, ($nroots + 1), 0);
        $rs['fcr'] = $fcr;
        $rs['prim'] = $prim;
        $rs['nroots'] = $nroots;
        $rs['gfpoly'] = $gfpoly;
        // Find prim-th root of 1, used in decoding
        for ($iprim = 1; $iprim % $prim != 0; $iprim += $rs['nn']) {
            ; // intentional empty-body loop!
        }

        $rs['iprim'] = (int) ($iprim / $prim);
        $rs['genpoly'][0] = 1;
        for ($i = 0, $root = $fcr * $prim; $i < $nroots; $i++, $root += $prim) {
            $rs['genpoly'][$i + 1] = 1;
            // Multiply rs->genpoly[] by  @**(root + x)
            for ($j = $i; $j > 0; --$j) {
                if ($rs['genpoly'][$j] != 0) {
                    $rs['genpoly'][$j] = $rs['genpoly'][$j - 1] ^ $rs['alpha_to'][$this->modnn($rs, $rs['index_of'][$rs['genpoly'][$j]] + $root)];
                } else {
                    $rs['genpoly'][$j] = $rs['genpoly'][$j - 1];
                }
            }

            // rs->genpoly[0] can never be zero
            $rs['genpoly'][0] = $rs['alpha_to'][$this->modnn($rs, $rs['index_of'][$rs['genpoly'][0]] + $root)];
        }

        // convert rs->genpoly[] to index form for quicker encoding
        for ($i = 0; $i <= $nroots; ++$i) {
            $rs['genpoly'][$i] = $rs['index_of'][$rs['genpoly'][$i]];
        }

        return $rs;
    }

    /**
     * Encode a Reed-Solomon codec and returns the parity array
     *
     * @param array $rs
     * @param array $data
     *
     * @return array
     */
    private function encode_rs_char($rs, $data, array $parity)
    {
        $nn = &$rs['nn']; // the total number of symbols in a RS block
        $alphaTo = &$rs['alpha_to']; // the address of an array of NN elements to convert Galois field elements in index (log) form to polynomial form
        $indexOf = &$rs['index_of']; // the address of an array of NN elements to convert Galois field elements in polynomial form to index (log) form
        $genPoly = &$rs['genpoly']; // an array of NROOTS+1 elements containing the generator polynomial in index form
        $nRoots = &$rs['nroots']; // the number of roots in the RS code generator polynomial, which is the same as the number of parity symbols in a block
        $pad = &$rs['pad']; // the number of pad symbols in a block
        $a0 = &$nn;
        $parity = ($parity === [] || $parity == null) ? array_fill(0, $nRoots, 0) : $parity;
        for ($i = 0; $i < ($nn - $nRoots - $pad); ++$i) {
            $feedback = $indexOf[$data[$i] ^ $parity[0]];
            if ($feedback != $a0) {
                // feedback term is non-zero
                // This line is unnecessary when GENPOLY[NROOTS] is unity, as it must
                // always be for the polynomials constructed by init_rs()
                $feedback = $this->modnn($rs, $nn - $genPoly[$nRoots] + $feedback);
                for ($j = 1; $j < $nRoots; ++$j) {
                    $parity[$j] ^= $alphaTo[$this->modnn($rs, $feedback + $genPoly[($nRoots - $j)])];
                }
            }

            // Shift
            array_shift($parity);
            $parity[] = $feedback != $a0 ? $alphaTo[$this->modnn($rs, $feedback + $genPoly[0])] : 0;
        }

        return $parity;
    }
} // end QRcode class
