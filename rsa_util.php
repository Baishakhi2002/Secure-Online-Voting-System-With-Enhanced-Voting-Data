<?php
require_once 'db_connection.php';
session_start();

function generateRSAKeys($key1, $key2)
{
    $p = 0;
    while (!isPrime($p)) {
        $p = rand(100, 200);
    }

    $q = 0;
    while (!isPrime($q) || $q == $p) {
        $q = rand(200, 300);
    }

    $n = $p * $q;
    $phi_n = ($p - 1) * ($q - 1);

    $e = 5;
    if (($p == 6) or ($q == 6)) {
        $e = 7;
    }

    for ($i = 1; $i < $n; $i++) {
        $temp = ($phi_n * $i + 1) / $e;
        if (strpos($temp, ".") == false) {
            break;
        }
    }

    $d = modInverse($e, $phi_n);

    return [
        'n' => $n,
        'e' => $e,
        'd' => $d
    ];
}

function isPrime($n)
{
    if ($n <= 1) {
        return false;
    }

    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) {
            return false;
        }
    }

    return true;
}



function modularExponentiation($base, $exponent, $modulus)
{
    $result = 1;
    while ($exponent > 0) {
        if ($exponent % 2 == 1) {
            $result = ($result * $base) % $modulus;
        }
        $exponent = $exponent >> 1;
        $base = ($base * $base) % $modulus;
    }
    return $result;
}


function rsaEncrypt($plainValue, $e, $n)
{
    return modularExponentiation($plainValue, $e, $n);
}


function rsaDecrypt($encryptedValue, $d, $n)
{
    return modularExponentiation($encryptedValue, $d, $n);
}


function modInverse($a, $m)
{
    if ($m == 0) {
        return null;
    }

    $m0 = $m;
    $y = 0;
    $x = 1;

    if ($m == 1) {
        return 0;
    }

    while ($a > 1) {
        $q = intdiv($a, $m);
        $t = $m;

        $m = $a % $m;
        $a = $t;
        $t = $y;

        $y = $x - $q * $y;
        $x = $t;
    }

    if ($x < 0) {
        $x += $m0;
    }

    return $x;
}
?>