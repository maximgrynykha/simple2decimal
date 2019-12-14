<?php
    class FractionsConverter 
    {
        public static $hexFractions = [
            "e28592" => (1 / 10), "e28591" => (1 / 9), "e2859b" => (1 / 8),
            "e28590" => (1 / 7),  "e28599" => (1 / 6), "e28595" => (1 / 5),
            "c2bc"   => (1 / 4),  "e28593" => (1 / 3), "e2859c" => (3 / 8),
            "e28596" => (2 / 5),  "c2bd"   => (1 / 2), "e28597" => (3 / 5),
            "e2859d" => (5 / 8),  "e28594" => (2 / 3), "c2be"   => (3 / 4),
            "e28598" => (4 / 5),  "e2859a" => (5 / 6), "e2859e" => (7 / 8)
        ];

        public static function print(string $simpleFraction, string $decimalFraction)
        {
            return "<div><strong>$simpleFraction</strong> simple fraction = " . "<strong>".$decimalFraction."</strong>" . " decimal fraction" . "</div>";
        }

        public static function convert(string $fraction)
        {
            if (is_numeric($fraction)) {
                $result = $fraction;
            }
            else {
                $hexString = bin2hex(str_replace([" ", ","], "", trim($fraction)));

                $fraction_pos = null;
                foreach (str_split($hexString) as $position => $char) {
                    if (!is_numeric($char)) {
                        $fraction_pos = $position;
                        break;
                    }
                }

                $integerPart  = mb_substr($hexString, 0, $fraction_pos);
                $fractionPart = mb_substr($hexString, $fraction_pos);

                if (array_key_exists($fractionPart, self::$hexFractions)) {
                    $result = ($integerPart = hex2bin($integerPart))
                        ? $integerPart + self::$hexFractions[$fractionPart]
                        : self::$hexFractions[$fractionPart];
                }
            }
            return self::print($fraction, $result);
        }
    }
    echo FractionsConverter::convert("120½");
    echo FractionsConverter::convert("120⅔");
    echo FractionsConverter::convert("120¾");
    echo FractionsConverter::convert("120.75");
    echo "<br><br>";

    foreach(FractionsConverter::$hexFractions as $hexFraction => $fraction) {
        echo FractionsConverter::convert(hex2bin($hexFraction));
    }
?>
<style>
    div {
        height: 20px;
        margin: 0 auto;
        padding: 10px;
        background: lightgreen;
        font-family: sans-serif;
        text-align: left;
        color: #555;
    }
    div:nth-child(odd) {
        background: #eee;
    }
    div:nth-child(even) {
        background: #e2e2e2;
    }
</style>