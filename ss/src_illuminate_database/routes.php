<?php

/*
header('Content-Type: application/json');

ini_set("max_execution_time", "-1");
ini_set("memory_limit", "-1");
ignore_user_abort(true);
set_time_limit(0);
 */

$app->get('/harcamalar', function ($request, $response, $args) {    
    $harcamalar =  $this->db->query("SELECT id, KaydTarihi, modification_time, Tarih, (Select NevIsmi From HarcamaNevleri Where id = RbtHarcamaNevleri) As Nev, RbtHarcamaNevleri, Mikdar, Izah
                                     FROM Harcamalar
                                     Order By Tarih Desc, id Desc");
    return $this->response->withJson([$harcamalar]);
});

$app->post('/harcama', function ($request, $response, $args) {
    $netice = [];
//    $netice = ['Netice' => 'Hata','Veriler' => ""];
    $input = $request->getParsedBody();
    $netice = [];
    $Izah = '';
    $sorgu = 'Insert Into Harcamalar (Tarih, RbtHarcamaNevleri, Mikdar, Izah) VALUES (?, ?, ?, ?)';
    try {
        if($input['Izah'] == null)
        {
            $Izah = '';
        }else
        {
            $Izah = $input['Izah'];
        }
    /*
    $eklenecekler = ['Tarih' => $dt, 'RbtHarcamaNevleri'=>$input['RbtHarcamaNevleri'],
                     'Mikdar'=>$input['Mikdar'], 'Izah'=> $Izah ];*/
    //$return = $this->db->insert('Harcamalar', $eklenecekler, ['id']);
    $eklenecekler = ['a' => 'Tarih', 'b'=>'RbtHarcamaNevleri' ];

    $return = $this->db->get('t1');
    $netice = ['Netice' => 'Tamam','Veriler' => $return];
    
    //$netice = ['Netice' => 'Bilgi','Veriler' => $input];
} catch (Exception $e) {
    $netice = ['Netice' => 'Hata','Veriler' => $e];
}

    return $this->response->withJson($netice);
});

$app->get('/harcamanevleri', function ($request, $response, $args) {
    $harcamanevleri =  $this->db->query("SELECT * FROM HarcamaNevleri");
    return $this->response->withJson([$harcamanevleri]);
});

$app->post('/odeme/arama', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $sicil = [];
    $netice = [];
    $sorgu = 'SELECT * FROM sch_2022.odeme Where 1 = 1 ';
    if (isset($input['sicil'])) {
        $sicil = $input['sicil'];
        if (isset($sicil['sicil_no'])) {
            $sorgu = $sorgu . ' And sicil_id = ' . $sicil['sicil_no'];
        }

        $sth = $this->db->prepare($sorgu);
        $sth->execute();
        $SicilKayitlari = $sth->fetchAll();
        $logNetice = $this->kullanici->selectSorguLoguEkle('Primsiz', $sorgu);
        $netice = ['SicilKayitlari' => $SicilKayitlari];
    }
    return $this->response->withJson($netice);
});

$app->post('/nufus/arama', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $sicil = [];
    $sorgu = 'SELECT * FROM sch_2022.nufus Where 1 = 1 ';
    if (isset($input['sicil'])) {
        $sicil = $input['sicil'];
        if (isset($sicil['tc_kimlik_no'])) {
            $sorgu = $sorgu . ' And tc_kimlik_no = ' . $sicil['tc_kimlik_no'];
        }
        if (isset($sicil['sicil_no'])) {
            $sorgu = $sorgu . ' And sicil_no = ' . $sicil['sicil_no'];
        }
        if (isset($sicil['ad'])) {
            $sorgu = $sorgu . " And ad like '" . $sicil['ad'] . "%'";
        }
        if (isset($sicil['soyad'])) {
            $sorgu = $sorgu . " And soyad like  '" . $sicil['soyad'] . "%'";
        }

    } else {
        //$ad = '';
    }
    $sth = $this->db->prepare($sorgu);
    /*
    $sth->bindParam("ad", $input['ad']);
    $sth->bindParam("soyad", $input['soyad']);
     */
    $sth->execute();
    $SicilKayitlari = $sth->fetchAll();
    $logNetice = $this->kullanici->selectSorguLoguEkle('Primsiz', $sorgu);
    $netice = ['SicilKayitlari' => $SicilKayitlari];
    return $this->response->withJson($netice);
});

$app->post('/sicil/arama', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $sicil = [];
    $sorgu = 'SELECT * FROM sch_2022.sicil Where 1 = 1 ';
    if (isset($input['sicil'])) {
        $sicil = $input['sicil'];
        if (isset($sicil['tc_kimlik_no'])) {
            $sorgu = $sorgu . ' And tc_kimlik_no = ' . $sicil['tc_kimlik_no'];
        }
        if (isset($sicil['sicil_no'])) {
            $sorgu = $sorgu . ' And sicil_no = ' . $sicil['sicil_no'];
        }
        if (isset($sicil['ad'])) {
            $sorgu = $sorgu . " And ad like '" . $sicil['ad'] . "%'";
        }
        if (isset($sicil['soyad'])) {
            $sorgu = $sorgu . " And soyad like  '" . $sicil['soyad'] . "%'";
        }

    } else {
        //$ad = '';
    }
    $sth = $this->db->prepare($sorgu);
    /*
    $sth->bindParam("ad", $input['ad']);
    $sth->bindParam("soyad", $input['soyad']);
     */
    $sth->execute();
    $SicilKayitlari = $sth->fetchAll();
    $logNetice = $this->kullanici->selectSorguLoguEkle('Primsiz', $sorgu);
    $netice = ['SicilKayitlari' => $SicilKayitlari];
    return $this->response->withJson($netice);
});

$app->post('/aylikodeme/arama', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $sicil = [];
    $sorgu = 'SELECT * FROM sch_2022.aylik_odeme Where 1 = 1 ';
    if (isset($input['sicil'])) {
        $sicil = $input['sicil'];
        if (isset($sicil['tc_kimlik_no'])) {
            $sorgu = $sorgu . ' And tc_kimlik_no = ' . $sicil['tc_kimlik_no'];
        }
        if (isset($sicil['sicil_no'])) {
            $sorgu = $sorgu . ' And sicil_id = ' . $sicil['sicil_no'];
        }
        if (isset($sicil['ad'])) {
            $sorgu = $sorgu . " And ad like '" . $sicil['ad'] . "%'";
        }
        if (isset($sicil['soyad'])) {
            $sorgu = $sorgu . " And soyad like  '" . $sicil['soyad'] . "%'";
        }
        $sorgu = $sorgu . ' Order By  odeme_gun ';
    } else {
        //$ad = '';
    }
    $sth = $this->db->prepare($sorgu);

    $sth->execute();
    $SicilKayitlari = $sth->fetchAll();
    $logNetice = $this->kullanici->selectSorguLoguEkle('Primsiz', $sorgu);
    $netice = ['SicilKayitlari' => $SicilKayitlari];
    return $this->response->withJson($netice);
});

$app->post('/onlinegiden/arama', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $sicil = [];
    $netice = [];
    $sorgu = 'SELECT * FROM sch_2022.online_giden Where 1 = 1 ';
    if (isset($input['sicil'])) {
        $sicil = $input['sicil'];
        if (isset($sicil['tc_kimlik_no'])) {
            $sorgu = $sorgu . ' And kimlik_no = ' . $sicil['tc_kimlik_no'];
        }
        if (isset($sicil['sicil_no'])) {
            $sorgu = $sorgu . ' And sicil_no = ' . $sicil['sicil_no'];
        }
        if (isset($sicil['ad'])) {
            $sorgu = $sorgu . " And adi like '" . $sicil['ad'] . "%'";
        }
        if (isset($sicil['soyad'])) {
            $sorgu = $sorgu . " And soyadi like  '" . $sicil['soyad'] . "%'";
        }
        $sth = $this->db->prepare($sorgu);
        $sth->execute();
        $SicilKayitlari = $sth->fetchAll();
        $logNetice = $this->kullanici->selectSorguLoguEkle('Primsiz', $sorgu);
        $netice = ['SicilKayitlari' => $SicilKayitlari];
       // $netice = ['Sorgu' => $sorgu];
    } else {
        $netice = ['Netice' => "input['sicil'] Yok!"];
    }
    
    return $this->response->withJson($netice);
});

// get all todos
$app->get('/todos', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM tasks ORDER BY task");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

$app->get('/todos/[{status}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM tasks Where status = :pstatus ORDER BY task");
    $sth->bindParam("pstatus", $args['status']);
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// Retrieve todo with id
$app->get('/todo/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM tasks WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $todos = $sth->fetchObject();
    return $this->response->withJson($todos);
});

// Search for todo with given search teram in their name
$app->get('/todos/search/[{query}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM tasks WHERE UPPER(task) LIKE :query ORDER BY task");
    $query = "%" . $args['query'] . "%";
    $sth->bindParam("query", $query);
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// Add a new todo
$app->post('/todo', function ($request, $response) {
    $input = $request->getParsedBody();
    $sql = "INSERT INTO tasks (task, status) VALUES (:task, :status)";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("task", $input['task']);
    if (isset($input['status'])) {
        $status = $input['status'];
    } else {
        $status = 0;
    }
    $sth->bindParam("status", $status);
    $sth->execute();
    $sonEklenenId = $this->db->lastInsertId();
/* Eklenen Kaydı Getir */
    $sth = $this->db->prepare("SELECT * FROM tasks WHERE id=:id");
    $sth->bindParam("id", $sonEklenenId);
    $sth->execute();
    $vazife = $sth->fetchObject();
/*- Eklenen Kaydı Getir */
    $netice = ['Netice' => 'Tamam', 'Mesaj' => 'Kayıt güncellendi.', 'Vazife' => $vazife];
    return $this->response->withJson($netice);
});

// DELETE a todo with given id
$app->delete('/todo/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("DELETE FROM tasks WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $netice = ['Netice' => 'Tamam', 'Mesaj' => 'Kayıt silindi.'];
    return $this->response->withJson($netice);
});

// Update todo with given id
$app->put('/todo/[{id}]', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $sql = "UPDATE tasks SET task=:task, status=:status  WHERE id=:id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("id", $args['id']);
    $sth->bindParam("task", $input['task']);
    $sth->bindParam("status", $input['status']);
    $sth->execute();
    $input['id'] = $args['id'];
    $netice = ['Netice' => 'Tamam', 'Mesaj' => 'Kayıt güncellendi.'];
    return $this->response->withJson($netice);
});
