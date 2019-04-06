<?php
$app->get('/gelirnevigetir', function ($request, $response, $args) {
    $netice = [NevGetir(' GelirNevleri ', 1, $this)];    
    return $this->response->withJson($netice);
});

function gelirGetir($pOKytNo)
{
    return tablodanKayitlariGetir($app, ' Gelirler ', '*', 'OKytNo = '. $pOKytNo);
}

$app->get('/gelirlerYekunu/{ilkTarih}/{sonTarih}', function ($request, $response, $args) {
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $gelirler = $this->db->query(
            "SELECT IFNULL(Sum(Mikdar), 0) As Yekun
            FROM Gelirler
            Where Tarih Between :ilkTarih And :sonTarih",
            array("ilkTarih" => $args['ilkTarih'], "sonTarih" => $args['sonTarih']));
        $netice = NeticeOlustur(Tamam, Veriler, $gelirler);        
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->get('/gelirnevleri', function ($request, $response, $args) {
    $Gelirnevleri = $this->db->query("SELECT * FROM GelirNevleri Order By NevIsmi ");
    return $this->response->withJson([$Gelirnevleri]);
});

$app->get('/gelirler/{ilkTarih}/{sonTarih}', function ($request, $response, $args) {
    //return $response->write("Hello " . $args['ilkTarih']. ' ' . $args['sonTarih']);
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $Gelirler = $this->db->query("SELECT OKytNo, KaydTarihi, modification_time, Tarih, (Select NevIsmi From GelirNevleri Where OKytNo = RbtGelirNevleri) As Nev, RbtGelirNevleri, Mikdar, Izah
                                     FROM Gelirler
                                     Where Tarih Between :ilkTarih And :sonTarih
                                     Order By Tarih Desc, OKytNo Desc",
            array("ilkTarih" => $args['ilkTarih'], "sonTarih" => $args['sonTarih']));
        $netice = NeticeOlustur(Tamam, Veriler, $Gelirler);
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->put('/gelir', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $eklenenKayitAdedi = $this->db->query(
            "Update Gelirler 
             Set Tarih = :Tarih, RbtGelirNevleri = :RbtGelirNevleri, 
             Mikdar = :Mikdar, Izah = :Izah
             Where OKytNo = :OKytNo",
            array("Tarih" => $input['Tarih'], "RbtGelirNevleri" => $input['RbtGelirNevleri'],
                "Mikdar" => $input['Mikdar'], "Izah" => $input['Izah'], "OKytNo" => $input['OKytNo']));        
        $input['Nev'] = NevGetir(' GelirNevleri ', $input['RbtGelirNevleri'], $this);        
        $netice = NeticeOlustur(Tamam, Veriler, $input);
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->post('/gelir', function ($request, $response, $args) {
    $netice = [];
    $input = $request->getParsedBody();
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        //$netice = NeticeOlustur(BlokDisi, Hata, $input);  
        $eklenenKayitAdedi = $this->db->query("Insert Into Gelirler (Tarih, RbtGelirNevleri, Mikdar, Izah) VALUES(:Tarih,:RbtGelirNevleri, :Mikdar, :Izah)",
            array("Tarih" => $input['Tarih'], "RbtGelirNevleri" => $input['RbtGelirNevleri'],
                 "Mikdar" => $input['Mikdar'], "Izah" => $input['Izah']));
        //Bak bunu hemen al. Başka bir işlem yaptıktan sonra alıyorsun, sonra 0 geliyor.
        $input['OKytNo'] = $this->db->sonEklenenKayitNoGetir();
        $input['Nev'] = NevGetir(' GelirNevleri ', $input['RbtGelirNevleri'], $this);
        $netice = NeticeOlustur(Tamam, Veriler, $input);
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->delete('/gelir/{OKytNo}', function ($request, $response, $args) {
    $OKytNo = $args['OKytNo'];
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {        
        $silinenKayitAdedi = $this->db->query(
            "Delete From Gelirler
             Where OKytNo = :OKytNo",
            array("OKytNo" => $OKytNo));
        $netice = NeticeOlustur(Tamam, Veriler, ["OKytNo" => $OKytNo,
        "SilinenKayitAdedi"=>$silinenKayitAdedi]);        
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }    
});