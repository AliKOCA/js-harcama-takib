function varidatyiSilmeyeHazirla(pIndex) {
    let cevab = confirm("Bu kaydı silmek istiyor musunuz?  :" + pIndex);
    if (cevab) {
        varidatyiSil(pIndex);
    }
}

function varidatyiSil(pIndex) {
    let OKytNo = varidatlarDizi[pIndex].OKytNo;
    $.ajax({
        url: "ss/slim/varidat/" + OKytNo,
        type: "DELETE",
        success: function (response) {
            if (response.Netice === "Tamam") {
                anahtarliDiziElemaniSil(varidatlarDizi, 'OKytNo', OKytNo);
                let sayfa = bootpagVaridatlar.cariSahife();
                varidatlarSayfalamaOlustur(sayfa);
                varidatlariListele(sayfa);
            } else {
                if (response.Netice === "Hata") hataGoster(response.Hata);
            }
        },
        error: function (xhr, resp, text) {
            console.log(xhr, resp, text);
            hataGoster("error: " + text);
        }
    });
    return false;
}
