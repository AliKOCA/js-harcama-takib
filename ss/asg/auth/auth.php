<?php
function neticeyiYaz($pNeticeKodu)
{
    header('Content-type: application/json');
    $neticeKodlarim = new NeticeKodlari;
    $neticeYazi = $neticeKodlarim->koddanNeticeGetir($pNeticeKodu);
    $netice = array('Kod' => $pNeticeKodu, 'Netice' => $neticeYazi);
    echo json_encode($netice);
}

function neticeyiYazKodveNeticeden($pNeticeKodu, $pNetice)
{
    header('Content-type: application/json');
    $netice = array('Kod' => $pNeticeKodu, 'Netice' => $pNetice);
    echo json_encode($netice);
}

function neticeyiYazDiziden($pDizi)
{
    header('Content-type: application/json');
    echo json_encode($pDizi);
}

class Kullanici
{
    private $host = 'aile.bulutu';
    private $neticeKodlarim;
    public $Database;
    private $Modul = '';

    private function ModulAyarla($pModul)
    {
        $this->Modul = $pModul;
    }

    private function DatabaseAyarla()
    {
        $Database = new PGDB('');
        $Database->pdo();
        $this->Database = $Database;
    }

    public function __construct()
    {
        $yol = __DIR__ . '/../tmp';
        ini_set('session.save_path', $yol);
        //echo 'Yol: ' . $yol . '<br>';
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->neticeKodlarim = new NeticeKodlari;
        $this->DatabaseAyarla();
    }

    public function __destruct()
    {
    }

    public function neticeDizisiDoldur($pNeticeKodu)
    {
        $netice = $this->neticeKodlarim->koddanNeticeGetir($pNeticeKodu);
        if (is_null($netice)) {
            $netice = 'Tanımsız hata kodu!';
        }
        return array('Kod' => $pNeticeKodu, 'Netice' => $netice);
    }

    public function neticeDizisiDoldur2($pNeticeKodu, $pNetice)
    {
        return array('Kod' => $pNeticeKodu, 'Netice' => $pNetice);
    }

    public function selectSorguLoguEkle($pModul, $pSorgu)
    {
        $netice = -1;
        $SKK_id = $this->sessiondaki_kayitli_kullanici_vt_id();
        $Log_id = -1;
        if (is_numeric($SKK_id)) {
            $netice = 0;
            if ($SKK_id > 0) {
                $Log_id = $this->Database->insert('sch_umumi.log_sorguSelect',
                    ['rbt__kullanicilar' => $SKK_id, 'Modul' => $pModul,
                        'Sorgu' => $pSorgu], 'id');
                $netice = $Log_id;
            }
        }
        return $netice;
    }

    public function kullaniciVeritabanindaVarmi($pKullanici)
    {
        //03 veritabanında yok
        //04 sorgudan 1 den fazla kayıt geldi. Gelmemesi gerekli.
        //08 kullanıcı veritabanında var ama faal değil.
        //18 kullanıcı veritabanında var ve faal durumda.

        $netice = $this->neticeDizisiDoldur('03');
        $kullanicilar = $this->Database->where('kullanici_ismi', "$pKullanici")->get('sch_umumi.kullanicilar');
        $gelenKayitAdedi = $this->Database->kayitAdediGetir();

        if ($gelenKayitAdedi > 1) {
            $netice = $this->neticeDizisiDoldur('04');
        }

        if ($gelenKayitAdedi == 1) {
            $faal = false;
            $satir = $kullanicilar[0];
            $faal = $satir['faal'];
            if ($faal) {
                $netice = $this->neticeDizisiDoldur('18');
            } else {
                $netice = $this->neticeDizisiDoldur('08');
            }
        }
        return $netice;
    }

    public function sessiondakiKullanici()
    {
        $netice = $this->neticeDizisiDoldur('05');
        if (isset($_SESSION['kayitli_kullanici'])) {
            $netice = $this->neticeDizisiDoldur2('41', $_SESSION['kayitli_kullanici']);
        }
        return $netice;
    }

    public function sessiondaki_kayitli_kullanici_vt_id()
    {
        $netice = -1;
        $sessiondaki_kayitli_kullanici = $this->sessiondaki_kayitli_kullanici();
        if ($sessiondaki_kayitli_kullanici != '') {
            $kullanicilar = $this->Database->where('kullanici_ismi', "$sessiondaki_kayitli_kullanici")->get('sch_umumi.kullanicilar');
            $gelenKayitAdedi = $this->Database->kayitAdediGetir();
            if ($gelenKayitAdedi == 1) {
                $netice = $kullanicilar[0]['id'];
            }
        }
        return $netice;
    }

    public function sessiondaki_kayitli_kullanici()
    {
        $netice = '';
        if (isset($_SESSION['kayitli_kullanici'])) {
            $netice = $_SESSION['kayitli_kullanici'];
        }
        return $netice;
    }

    public function kullaniciLoginOlmusMu()
    {
        $netice = $this->neticeDizisiDoldur('21');
        $sessiondakiKullanici_Kod = $this->sessiondakiKullanici()["Kod"];
        if ($sessiondakiKullanici_Kod == '41') {
            $netice = $this->neticeDizisiDoldur('22');
        }
        return $netice;
    }

    public function sessionDakiKullaniciyiAyarla($pKullanici)
    {
        $_SESSION['kayitli_kullanici'] = $pKullanici;
        $this->sessiondaki_kayitli_kullaniciyi_vt_loga_kaydet($pKullanici);
        return $this->neticeDizisiDoldur('19');
    }

    public function Database_Sorgu_Cumlesi()
    {
        return $this->Database->sorguCumlesi();

    }

    public function sessiondaki_kayitli_kullaniciyi_vt_loga_kaydet()
    {
        $netice = -1;
        $sessiondaki_kayitli_kullanici_vt_id = $this->sessiondaki_kayitli_kullanici_vt_id();
        //print 'id: ' . $sessiondaki_kayitli_kullanici_vt_id;
        if (is_numeric($sessiondaki_kayitli_kullanici_vt_id)) {
            if ($sessiondaki_kayitli_kullanici_vt_id > 0) {
                $id = $this->Database->insert('sch_umumi.log_giris',
                    ['rbt__kullanicilar' => $sessiondaki_kayitli_kullanici_vt_id], 'id');
//'Modul' => $this->Modul,
                //  print 'id: ' . sessiondaki_kayitli_kullanici_vt_id;
            }
        }
        return $netice;
    }

    public function kullaniciyiSessiondanCikart()
    {
        $_SESSION['kayitli_kullanici'] = '';
        unset($_SESSION['kayitli_kullanici']);
        session_destroy();
        //echo 'Php çıkarttım.';
    }

    public function kullaniciyiTeyidEtSesionaYazLDAP($domain, $kismi, $ksifresi)
    {
        $kismi_ve_domain = $kismi . '@' . $domain;
        $netice = $this->kullaniciVeritabanindaVarmi($kismi);
        if ($netice["Kod"] == '18') {
            $netice = $this->kullaniciyiTeyidEtLDAP($kismi_ve_domain, $ksifresi);
            if ($netice["Kod"] == '11') {
                $netice = $this->sessionDakiKullaniciyiAyarla($kismi);
                $netice = $this->sessiondakiKullanici();
            }
        }
        return $netice;
    }

    public function kullaniciyiTeyidEtLDAP($kismi, $ksifresi)
    {
        /*Maalesef hostname den erişilemeyecek ip ler de geldiği için sadece
        172 başlayanları alarak çözmeye çalıştık. İleride başka arızalarda çıkabilir.

         */
        $netice = $this->neticeDizisiDoldur('01');
        $ip = '000';
        $intA = 0;
        if (isset($kismi) or isset($ksifresi)) {
            if ((strlen(trim($kismi)) > 2) and (strlen(trim($ksifresi)) > 2)) {
                while (substr($ip, 0, 3) != '172') {
                    $ip = gethostbyname($this->host);
                    $intA++;
                    if ($intA >= 10) {
                        exit;
                    }
                }
                //
                try {
                    $ldap = ldap_connect($ip);
                    //print('ldap_connect ip: '. $ip);
                    //print(' kismi: ' . $kismi);
                    if ($ldap) {
                        $ldapbind = ldap_bind($ldap, $kismi, $ksifresi);
                        if ($ldapbind) {
                            $netice = $this->neticeDizisiDoldur('11');
                        } else {
                            $netice = $this->neticeDizisiDoldur('01');
                            print(' $ldapbind: Yok!');
                        }
                    } else {
                        $netice = $this->neticeDizisiDoldur('02');
                    }
                } catch (Exception $mHata) {
                    $netice = $mHata->getMessage();
                }
            } else {
                return $this->neticeDizisiDoldur('06');
            }
        } else {
            return $this->neticeDizisiDoldur('07');
        }
        return $netice;
    }
}
