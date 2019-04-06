let sonKaydedilenVaridatTarihi = null;

function varidatNevleri() {
  return new Promise((resolve, reject) => {
    $.getJSON("ss/slim/varidatnevleri", function (data) {
      var categories_options_html = "";
      $.each(data[0], function (key, val) {
        categories_options_html +=
          "<option value='" + val.OKytNo + "'>" + val.NevIsmi + "</option>";
      });
      resolve(categories_options_html);
    });
  });
}
async function varidatNevleriGetir() {
  categories_options_html = await varidatNevleri();
  $("#RbtVaridatNevleri").html(categories_options_html);
  document.getElementById("RbtVaridatNevleri").value = "";
}

function varidatHucreleriniBosalt() {
  if (sonKaydedilenVaridatTarihi) {
    document.getElementById("VaridatTarih").value = yilAyGunTarih(sonKaydedilenVaridatTarihi);
  } else {
    document.getElementById("VaridatTarih").value = "";
  }
  document.getElementById("RbtVaridatNevleri").value = "";
  document.getElementById("VaridatMikdar").value = "";
  document.getElementById("VaridatIzah").value = "";
  document.getElementById("VaridatOKytNo").value = null;
  document.getElementById("VaridatIndexNo").value = null;
}

$(document).ready(function () {
  varidatHucreleriniBosalt();
  varidatNevleriGetir();
});

function varidatiKaydet(form) {
  let OKytNo = document.getElementById('VaridatOKytNo').value;
  //console.log(OKytNo)
  let form_data = JSON.stringify($(form).serializeObject());
  let talep_tipi;
  if (OKytNo) {
    talep_tipi = 'PUT';
  } else {
    talep_tipi = 'POST';
  }
  $.ajax({
    url: "ss/slim/varidat",
    type: talep_tipi,
    contentType: "application/json",
    data: form_data,
    success: function (response) {
      if (response.Netice === "Tamam") {
        if (talep_tipi === 'POST') {
          varidatlarDizi.unshift(response.Veriler);
          sonKaydedilenVaridatTarihi = new Date(document.getElementById("VaridatTarih").value);
        } else {
          //OKytNo dan bul, update et. 
          anahtarliDiziElemaniGuncelle(varidatlarDizi, 'OKytNo', OKytNo, response.Veriler);
          varidatFormuModuAyarla('Kaydet');
        }
        varidatlarSayfalamaOlustur(bootpagVaridatlar.cariSahife());
        varidatlariListele(bootpagVaridatlar.cariSahife());
        varidatHucreleriniBosalt();
        document.getElementById("VaridatTarih").focus();
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
