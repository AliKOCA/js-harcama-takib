<?php
require_once __DIR__ . '/auth.php';
try {
    $kullanici = new Kullanici;
} catch (Exception $e) {
    neticeyiYazKodveNeticeden("50", $e->getMessage());
    die();
}

$inputJSON = file_get_contents('php://input');
$parametreler = json_decode($inputJSON, true);

//neticeyiYaz2('111', $parametreler);
//exit;
$mn = '';
$kismi = '';
$ksifresi = '';
$domain = '@aile.bulutu';

if (isset($parametreler["mn"])) {
    $mn = trim($parametreler["mn"]);
}
if (isset($parametreler["kismi"])) {
    $kismi = trim($parametreler["kismi"]);
}
if (isset($parametreler["ksifresi"])) {
    $ksifresi = trim($parametreler["ksifresi"]);
}

//neticeyiYaz22($mn, $kismi, $ksifresi );
if (($mn == '')) {
    neticeyiYaz('61');
    exit;
}

if ($mn == 'gy') {
    //print('gy');
    $kullaniciVarMi = $kullanici->kullaniciVeritabanindaVarmi($kismi);
    if ($kullaniciVarMi["Kod"] == '18') {
        $loginOlmusMu = $kullanici->kullaniciLoginOlmusMu()["Kod"];
        switch ($loginOlmusMu) {
            case '22':
                neticeyiYaz('12');
                break;
            case '21':
                $post_neticesi = $kullanici->kullaniciyiTeyidEtSesionaYaz($domain, $kismi, $ksifresi);
                print('---21');
                neticeyiYazDiziden($post_neticesi);
                break;
            default:
        } //switch
    } else { //Kullanıcı veritabında yok veya kilitli
        neticeyiYazDiziden($kullaniciVarMi);
    }
}

if ($mn == 'kvarmi') {
    $netice = $kullanici->kullaniciVeritabanindaVarmi('veli.türk');

    neticeyiYazDiziden($netice);
}

if ($mn == 'cy') {
    $loginOlmusMu = $kullanici->kullaniciLoginOlmusMu()['Kod'];
    if ($loginOlmusMu == '22') {
        $kullanici->kullaniciyiSessiondanCikart();
        neticeyiYaz('15');
    } else {
        neticeyiYaz('05');
    }
}

if ($mn == 'gyk') {
    //neticeyiYaz('05');
    //exit;
    $loginOlanKullanici = $kullanici->sessiondakiKullanici();
    if ($loginOlanKullanici['Kod'] == '41') {
        neticeyiYazDiziden($loginOlanKullanici);
    } else {
        neticeyiYaz('05');
    }
}

if ($mn == 'gyk2') {
    $loginOlanKullanici = $kullanici->sessiondaki_kayitli_kullanici();
    neticeyiYazKodveNeticeden('41', $loginOlanKullanici);
}
