<?php
$app->get('/varidatNeviGetir', function ($request, $response, $args) {
    $netice = [NevGetir('VaridatNevleri', 1, $this)];
    return $this->response->withJson($netice);
});

function varidatGetir($pOKytNo)
{
    return tablodanKayitlariGetir($app, ' Varidatlar ', '*', 'OKytNo = '. $pOKytNo);
}

$app->get('/varidatlarYekunu/{ilkTarih}/{sonTarih}', function ($request, $response, $args) {
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $varidatlar = $this->db->query(
            "SELECT IFNULL(Sum(Mikdar), 0) As Yekun
            FROM Varidatlar
            Where Tarih Between :ilkTarih And :sonTarih",
            array("ilkTarih" => $args['ilkTarih'], "sonTarih" => $args['sonTarih']));
        $netice = NeticeOlustur(Tamam, Veriler, $varidatlar);        
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->get('/varidatlar/{ilkTarih}/{sonTarih}', function ($request, $response, $args) {
    //return $response->write("Hello " . $args['ilkTarih']. ' ' . $args['sonTarih']);
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $varidatlar = $this->db->query(
            "SELECT OKytNo, KaydTarihi, modification_time, Tarih, (Select NevIsmi From VaridatNevleri Where OKytNo = RbtVaridatNevleri) As Nev, RbtVaridatNevleri, Mikdar, Izah,
             (Select SiraNo From VaridatNevleri Where OKytNo = RbtVaridatNevleri) As SiraNo
            FROM Varidatlar
            Where Tarih Between :ilkTarih And :sonTarih
            Order By SiraNo",
            array("ilkTarih" => $args['ilkTarih'], "sonTarih" => $args['sonTarih']));
        $netice = NeticeOlustur(Tamam, Veriler, $varidatlar);        
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->put('/varidat', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $eklenenKayitAdedi = $this->db->query(
            "Update Varidatlar 
             Set Tarih = :Tarih, RbtVaridatNevleri = :RbtVaridatNevleri, 
             Mikdar = :Mikdar, Izah = :Izah
             Where OKytNo = :OKytNo",
            array("Tarih" => $input['Tarih'], "RbtVaridatNevleri" => $input['RbtVaridatNevleri'],
                "Mikdar" => $input['Mikdar'], "Izah" => $input['Izah'], "OKytNo" => $input['OKytNo']));        
        $input['Nev'] = NevGetir(' VaridatNevleri ', $input['RbtVaridatNevleri'], $this);        
        $netice = NeticeOlustur(Tamam, Veriler, $input);
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->post('/varidat', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $eklenenKayitAdedi = $this->db->query("Insert Into Varidatlar (Tarih, RbtVaridatNevleri, Mikdar, Izah) VALUES(:Tarih,:RbtVaridatNevleri, :Mikdar, :Izah)",
            array("Tarih" => $input['Tarih'], "RbtVaridatNevleri" => $input['RbtVaridatNevleri'],
                "Mikdar" => $input['Mikdar'], "Izah" => $input['Izah']));
        //Bak bunu hemen al. Başka bir işlem yaptıktan sonra alıyorsun, sonra 0 geliyor.
        $input['OKytNo'] = $this->db->sonEklenenKayitNoGetir();
        $input['Nev'] = NevGetir(' VaridatNevleri ', $input['RbtVaridatNevleri'], $this);        
        $netice = NeticeOlustur(Tamam, Veriler, $input);
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->delete('/varidat/{OKytNo}', function ($request, $response, $args) {
    $OKytNo = $args['OKytNo'];
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {        
        $silinenKayitAdedi = $this->db->query(
            "Delete From Varidatlar
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

$app->get('/varidatnevleri', function ($request, $response, $args) {
    $varidatnevleri = $this->db->query("SELECT * FROM VaridatNevleri Order By OKytNo");
    return $this->response->withJson([$varidatnevleri]);
});