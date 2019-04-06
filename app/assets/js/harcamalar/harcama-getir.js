async function harcamalariGetirP_Evvelki() {
    let promise = new Promise((resolve, reject) => {
        $.getJSON("ss/slim/harcamalar", function (data) {
            resolve(data);
        });
    });
    let response = await promise;
    return response;
}

async function harcamalariGetirP() {
    let promise = new Promise((resolve, reject) => {
        let ilkTrh = document.getElementById("ilkTarih").value,
            sonTrh = document.getElementById("sonTarih").value;
        $.getJSON("ss/slim/harcamalar/" + ilkTrh + '/' + sonTrh, function (data) {
            resolve(data);
        });
    });
    let response = await promise;
    return response;
}

function harcamalariGetir() {
    harcamalariGetirP()
        .then(response => {
            if (response.Netice === "Tamam") {
                harcamalarDizi = response.Veriler;
                //alert(harcamalarDizi.length)
                harcamalarSayfalamaOlustur(1);
            } else {
                if (response.Netice === "Hata")
                    hataGoster(response.Hata);
            }
            harcamalariListele(1);
        });
}

function harcamalariYaz(pMuhteviyat) {
    $('#harcama-tablo-govde').html(pMuhteviyat);
}

function harcamalariListele(pSahifeNo) {
    var harcamalar_html = '';
    if (harcamalarDizi.length > 0) {
        var intA;
        //console.log('İlk Eleman: ' + bootpagHarcamalar.ilkKayitNo());
        //console.log('Son Eleman: ' + bootpagHarcamalar.sonKayitNo());
        for (intA = bootpagHarcamalar.ilkKayitNo(); intA <= bootpagHarcamalar.sonKayitNo(); intA++) {
            let harcama = harcamalarDizi[intA];
            harcamalar_html += "<tr>";
            harcamalar_html += "<td>" + formatDate(harcama.Tarih) + "</td>";
            harcamalar_html += "<td>" + harcama.Nev + "</td>";
            harcamalar_html += "<td>" + harcama.Mikdar + " TL</td>";
            harcamalar_html += "<td>" + harcama.Izah + "</td>";
            harcamalar_html += "<td>";
            harcamalar_html += "<button class='btn btn-info m-r-10px update-product-button btn-sm' onclick='harcamayiDuzeltmeyeHazirla(" + intA + ")'>";
            harcamalar_html += "<span class='fa fa-edit'></span> Düzelt";
            harcamalar_html += "</button>";
            harcamalar_html += "<button class='btn btn-danger delete-product-button btn-sm' onclick='harcamayiSilmeyeHazirla(" + intA + ")'>";
            harcamalar_html += "<span class='fa fa-remove'></span> Sil";
            harcamalar_html += "</button>";
            harcamalar_html += "</td>";
            harcamalar_html += "</tr>";
        }
        harcamalariYaz(harcamalar_html);
    }
}
