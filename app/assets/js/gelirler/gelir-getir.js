async function gelirleriGetirP_Evvelki() {
    let promise = new Promise((resolve, reject) => {
        $.getJSON("ss/slim/gelirler", function (data) {
            resolve(data);
        });
    });
    let response = await promise;
    return response;
}

async function gelirleriGetirP() {
    let promise = new Promise((resolve, reject) => {
        let ilkTrh = document.getElementById("ilkTarih").value,
            sonTrh = document.getElementById("sonTarih").value;
        $.getJSON("ss/slim/gelirler/" + ilkTrh + '/' + sonTrh, function (data) {
            resolve(data);
        });
    });
    let response = await promise;
    return response;
}

function gelirleriGetir() {
    gelirleriGetirP()
        .then(response => {
            if (response.Netice === "Tamam") {
                gelirlerDizi = response.Veriler;
                gelirlerSayfalamaOlustur(1);
            } else {
                if (response.Netice === "Hata")
                    hataGoster(response.Hata);
            }
            gelirleriListele(1);
        });
}

function gelirleriYaz(pMuhteviyat) {
    $('#gelir-tablo-govde').html(pMuhteviyat);
}

function gelirleriListele(pSahifeNo) {
    var gelirler_html = '';
    if (gelirlerDizi.length > 0) {
        var intA;
        //console.log('İlk Eleman: ' + bootpagGelirler.ilkKayitNo());
        //console.log('Son Eleman: ' + bootpagGelirler.sonKayitNo());        
        for (intA = bootpagGelirler.ilkKayitNo(); intA <= bootpagGelirler.sonKayitNo(); intA++) {
            gelir = gelirlerDizi[intA];
            gelirler_html += "<tr>";
            gelirler_html += "<td>" + formatDate(gelir.Tarih) + "</td>";
            gelirler_html += "<td>" + gelir.Nev + "</td>";
            gelirler_html += "<td>" + gelir.Mikdar + " TL</td>";
            gelirler_html += "<td>" + gelir.Izah + "</td>";
            gelirler_html += "<td>";
            gelirler_html += "<button class='btn btn-info m-r-10px update-product-button btn-sm' onclick='geliriDuzeltmeyeHazirla(" + intA + ")'>";
            gelirler_html += "<span class='fa fa-edit'></span> Düzelt";
            gelirler_html += "</button>";
            gelirler_html += "<button class='btn btn-danger delete-product-button btn-sm' onclick='geliriSilmeyeHazirla(" + intA + ")'>";
            gelirler_html += "<span class='fa fa-remove'></span> Sil";
            gelirler_html += "</button>";
            gelirler_html += "</td>";
            gelirler_html += "</tr>";
        }
    }
    gelirleriYaz(gelirler_html);
}