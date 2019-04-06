function geliriSilmeyeHazirla(pIndex) {
    let cevab = confirm("Bu kaydı silmek istiyor musunuz?  :" + pIndex);
    if (cevab) {
        geliriSil(pIndex);
    }
}

function geliriSil(pIndex) {
    let OKytNo = gelirlerDizi[pIndex].OKytNo;
    $.ajax({
        url: "ss/slim/gelir/" + OKytNo,
        type: "DELETE",
        success: function (response) {
            if (response.Netice === "Tamam") {
                anahtarliDiziElemaniSil(gelirlerDizi, 'OKytNo', OKytNo);
                let sayfa = bootpagGelirler.cariSahife();
                gelirlerSayfalamaOlustur(sayfa);
                gelirleriListele(sayfa);
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
