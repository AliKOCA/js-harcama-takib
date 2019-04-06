<?php
class NeticeKodlari{

function koddanNeticeGetir($pKod){
    return $this->neticeKodlari[$pKod];
}

function koddanNeticeDizisiGetir($pKod){
    return array($pKod => $this->neticeKodlari[$pKod]);
}

private $neticeKodlari = array (
    '01'=>'Kullanıcı İsmi/Şifresi yanlış!',
    '02'=>'ldap sunuya erişim yapılamıyor!',
    '03'=>'Kayıtsız Kullanıcı!',
    '04'=>'Enjeksiyon!',
    '05'=>'Kullanıcı giriş yapmamış!',
    '06'=>'Kullanıcı İsmi/Şifresi 3 karakterden küçük!',
    '07'=>'Kullanıcı İsmi/Şifresi unset!',
    '08'=>'Kullanıcı kilitli!',
    '09'=>'Kullanıcı giriş yapmamış!',

    '11'=>'Kullanıcı İsmi/Şifresi doğru.',
    '12'=>'Kullanıcı zaten giriş yapmış.',
    '13'=>'',
    '14'=>'',
    '15'=>'Çıkış yapıldı.',
    '16'=>'',
    '17'=>'',
    '18'=>'Kullanıcı kayıtlı ve faal.',
    '19'=>'Sessinoandaki kullanıcı ayarlardı.',

    '21'=>'menfi',
    '22'=>'müsbet',

    '41'=>'Giriş yapan kullanıcı ismi',

    '50'=>'PHP Hatası.',

    '61'=>'Muamele Nevi Yok!',

    '99'=>'Ziyade netice kodu.',
);

}
