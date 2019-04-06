function harcamayiSilmeyeHazirla(pIndex) {
  let cevab = confirm("Bu kaydı silmek istiyor musunuz?  :" + pIndex);
  if (cevab) {
    harcamayiSil(pIndex);
  }
}

function harcamayiSil(pIndex) {
  let OKytNo = harcamalarDizi[pIndex].OKytNo;
  $.ajax({
    url: "ss/slim/harcama/" + OKytNo,
    type: "DELETE",
    success: function(response) {
      if (response.Netice === "Tamam") {
        anahtarliDiziElemaniSil(harcamalarDizi, "OKytNo", OKytNo);
        let sayfa = bootpagHarcamalar.cariSahife();
        harcamalarSayfalamaOlustur(sayfa);
        harcamalariListele(sayfa);
      } else {
        if (response.Netice === "Hata") hataGoster(response.Hata);
      }
    },
    error: function(xhr, resp, text) {
      console.log(xhr, resp, text);
      hataGoster("error: " + text);
    }
  });
  return false;
}
