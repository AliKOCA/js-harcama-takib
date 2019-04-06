let sonKaydedilenGelirTarihi = null;

function gelirNevleri() {
  return new Promise((resolve, reject) => {
    $.getJSON("ss/slim/gelirnevleri", function (data) {
      var categories_options_html = "";
      $.each(data[0], function (key, val) {
        categories_options_html +=
          "<option value='" + val.OKytNo + "'>" + val.NevIsmi + "</option>";
      });
      resolve(categories_options_html);
    });
  });
}
async function gelirNevleriGetir() {
  categories_options_html = await gelirNevleri();
  $("#RbtGelirNevleri").html(categories_options_html);
  document.getElementById("RbtGelirNevleri").value = "";
}

function gelirHucreleriniBosalt() {
  if (sonKaydedilenGelirTarihi) {
    document.getElementById("GelirTarih").value = yilAyGunTarih(sonKaydedilenGelirTarihi);
  } else {
    document.getElementById("GelirTarih").value = "";
  }
  document.getElementById("RbtGelirNevleri").value = "";
  document.getElementById("GelirMikdar").value = "";
  document.getElementById("GelirIzah").value = "";
  document.getElementById('GelirOKytNo').value = "";
  document.getElementById('GelirIndexNo').value = "";
}

$(document).ready(function () {
  gelirHucreleriniBosalt();
  gelirNevleriGetir();
});

function geliriKaydet(form) {
  let OKytNo = document.getElementById('GelirOKytNo').value;
  //console.log(OKytNo)
  let form_data = JSON.stringify($(form).serializeObject());
  let talep_tipi;
  if (OKytNo) {
    talep_tipi = 'PUT';
  } else {
    talep_tipi = 'POST';
  }
  $.ajax({
    url: "ss/slim/gelir",
    type: talep_tipi,
    contentType: "application/json",
    data: form_data,
    success: function (response) {
      if (response.Netice === "Tamam") {
        if (talep_tipi === 'POST') {
          gelirlerDizi.unshift(response.Veriler);
          sonKaydedilenGelirTarihi = new Date(document.getElementById("GelirTarih").value);
        } else {
          //OKytNo dan bul, update et. 
          anahtarliDiziElemaniGuncelle(gelirlerDizi, 'OKytNo', OKytNo, response.Veriler);
          gelirFormuModuAyarla('Kaydet');
        }
        gelirlerSayfalamaOlustur(bootpagGelirler.cariSahife());
        gelirleriListele(bootpagGelirler.cariSahife());
        gelirHucreleriniBosalt();
        document.getElementById("GelirTarih").focus();
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

