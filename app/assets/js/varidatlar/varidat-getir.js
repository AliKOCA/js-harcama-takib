async function varidatlariGetirP_Evvelki() {
    let promise = new Promise((resolve, reject) => {
        $.getJSON("ss/slim/varidatlar", function (data) {
            resolve(data);
        });
    });
    let response = await promise;
    return response;
}

async function varidatlariGetirP() {
    let promise = new Promise((resolve, reject) => {
        let ilkTrh = document.getElementById("ilkTarih").value,
            sonTrh = document.getElementById("sonTarih").value;
        $.getJSON("ss/slim/varidatlar/" + ilkTrh + '/' + sonTrh, function (data) {
            resolve(data);
        });
    });
    let response = await promise;
    return response;
}

function varidatlariGetir() {
    varidatlariGetirP()
        .then(response => {
            if (response.Netice === "Tamam") {
                varidatlarDizi = response.Veriler;
                //alert(varidatlarDizi.length)
                varidatlarSayfalamaOlustur(1);
            } else {
                if (response.Netice === "Hata")
                    hataGoster(response.Hata);
            }
            varidatlariListele(1);
        });
}

function varidatlariYaz(pMuhteviyat) {
    $('#varidat-tablo-govde').html(pMuhteviyat);
}

function varidatlariListele(pSahifeNo) {
    var varidatlar_html = '';
    if (varidatlarDizi.length > 0) {
        var intA;
        //console.log('İlk Eleman: ' + bootpagVaridatlar.ilkKayitNo());
        //console.log('Son Eleman: ' + bootpagVaridatlar.sonKayitNo());
        for (intA = bootpagVaridatlar.ilkKayitNo(); intA <= bootpagVaridatlar.sonKayitNo(); intA++) {
            let varidat = varidatlarDizi[intA];
            varidatlar_html += "<tr>";
            varidatlar_html += "<td>" + formatDate(varidat.Tarih) + "</td>";
            varidatlar_html += "<td>" + varidat.Nev + "</td>";
            varidatlar_html += "<td>" + varidat.Mikdar + " TL</td>";
            varidatlar_html += "<td>" + varidat.Izah + "</td>";
            varidatlar_html += "<td>";
            varidatlar_html += "<button class='btn btn-info m-r-10px update-product-button btn-sm' onclick='varidatyiDuzeltmeyeHazirla(" + intA + ")'>";
            varidatlar_html += "<span class='fa fa-edit'></span> Düzelt";
            varidatlar_html += "</button>";
            varidatlar_html += "<button class='btn btn-danger delete-product-button btn-sm' onclick='varidatyiSilmeyeHazirla(" + intA + ")'>";
            varidatlar_html += "<span class='fa fa-remove'></span> Sil";
            varidatlar_html += "</button>";
            varidatlar_html += "</td>";
            varidatlar_html += "</tr>";
        }
        varidatlariYaz(varidatlar_html);
    }
}
