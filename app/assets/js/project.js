let sayfadakiKayitAdedi = 8;
let gelirlerDizi = new Array();
let bootpagGelirler = null;
let harcamalarDizi = new Array();
let bootpagHarcamalar = null;
let varidatlarDizi = new Array();
let bootpagVaridatlar = null;

let gelirlerYekunu;
let harcamalarYekunu;
let varidatlarYekunu;
let eksikFazla;

async function umumiYekunuGetirP() {
    let promise = new Promise((resolve, reject) => {
        let ilkTrh = document.getElementById("ilkTarih").value,
            sonTrh = document.getElementById("sonTarih").value;
        $.getJSON("ss/slim/umumiYekun/" + ilkTrh + '/' + sonTrh, function(data) {
            resolve(data);
        });
    });
    let response = await promise;
    return response;
}

function umumiYekunuGetir() {
    umumiYekunuGetirP()
        .then(response => {
            if (response.Netice === "Tamam") {
                gelirlerYekunu = response.Veriler[0].gelirlerYekunu;
                harcamalarYekunu = response.Veriler[0].harcamalarYekunu;
                varidatlarYekunu = response.Veriler[0].varidatlarYekunu;
                yekunHesabEtYaz();
            } else {
                if (response.Netice === "Hata")
                    hataGoster(response.Hata);
            }
        });
}

function yekunHesabEtYaz() {
    eksikFazla = parseFloat(varidatlarYekunu - (gelirlerYekunu - harcamalarYekunu)).toFixed(2);
    document.getElementById("GelirlerYekunu").innerHTML = gelirlerYekunu + ' - ';
    document.getElementById("HarcamalarYekunu").innerHTML = harcamalarYekunu + ' - ';
    document.getElementById("VaridatYekunu").innerHTML = varidatlarYekunu + ' = ';
    document.getElementById("EksikFazla").innerHTML = eksikFazla;
    console.log('Eksik Fazla: ' + varidatlarYekunu + ' . ' + gelirlerYekunu + ' . ' +
        harcamalarYekunu + ' . ' + eksikFazla);
}

function ilkTarihSonTarihAyarla() {
    let tarih = new Date();
    //tarih = new Date(2019, 0, 14);
    const donem = donemGetir(tarih);
    document.getElementById("ilkTarih").value = donem.ilkTarih;
    document.getElementById("sonTarih").value = donem.sonTarih;
}

function gelirlerSayfalamaOlustur(pAktifSahifeNo) {
    umumiYekunuGetir();
    bootpagGelirler = sayfalamaOlustur('divGelirSahifeleme', gelirleriListele, gelirlerDizi.length, sayfadakiKayitAdedi, 5, pAktifSahifeNo);
}

function harcamalarSayfalamaOlustur(pAktifSahifeNo) {
    umumiYekunuGetir();
    bootpagHarcamalar = sayfalamaOlustur('divHarcamaSahifeleme', harcamalariListele, harcamalarDizi.length, sayfadakiKayitAdedi, 5, pAktifSahifeNo);
}

function varidatlarSayfalamaOlustur(pAktifSahifeNo) {
    umumiYekunuGetir();
    bootpagVaridatlar = sayfalamaOlustur('divVaridatlarSahifeleme', varidatlariListele, varidatlarDizi.length, sayfadakiKayitAdedi, 5, pAktifSahifeNo);
}

function kayitlariGetir() {
    umumiYekunuGetir();
    gelirleriGetir();
    harcamalariGetir();
    varidatlariGetir();
}

$(document).ready(function() {
    ilkTarihSonTarihAyarla();
    kayitlariGetir();
});

function changePageTitle(page_title) {
    /* $('#page-title').text(page_title);
     document.title = page_title;*/
}


var getJSONAsG = function(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.responseType = 'json';
    xhr.onload = function() {
        var status = xhr.status;
        if (status === 200) {
            callback(null, xhr.response);
        } else {
            callback(status, xhr.response);
        }
    };
    xhr.send();
};

function veriGeldi($birSey, $veri) {
    alert($veri);
}

///getJSONAsG('http://', veriGeldi);