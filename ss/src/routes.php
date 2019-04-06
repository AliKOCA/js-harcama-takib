<?php
require "../asg/ensar/sabitler.php";

function NeticeOlustur($pNetice, $pDiziIsmi, $pDiziVerisi)
{
    $netice = ['Netice' => $pNetice, $pDiziIsmi => $pDiziVerisi];
    return $netice;
}

function tablodanKayitlariGetir($pApp, $pTablo, $pAlanlar, $pSerait)
{
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $sorgu = "SELECT ". $pAlanlar ." FROM " . $pTablo;
        if($pSerait){
            $sorgu += "Where " + $pSerait;
        }
        $kayitlar = $pApp->db->query($sorgu);
        $netice = NeticeOlustur(Tamam, Veriler, $kayitlar);
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
}

function NevGetir($pTablo, $pHarcamaNevOKytNo, $pApp)
{
    $netice = [];
    try {
        $netice = $pApp->db->query("SELECT NevIsmi FROM " . $pTablo . " Where OKytNo = :OKytNo",
            array("OKytNo" => $pHarcamaNevOKytNo));
    } catch (Exception $e) {
        $netice = $e->getMessage();
    } finally {
        if (count($netice) > 0) {
            $netice = $netice[0]['NevIsmi'];
        } else {
            $netice = '';
        }        
    }
    return $netice;
}

require "access.php";

require "routes-umumi.php";
require "routes-harcamalar.php";
require "routes-gelirler.php";
require "routes-varidatlar.php";

require "map.php";
