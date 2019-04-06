let sonKaydedilenHarcamaTarihi = null;

function harcamaNevleri() {
  return new Promise((resolve, reject) => {
    $.getJSON("ss/slim/harcamanevleri", function (data) {
      var categories_options_html = "";
      $.each(data[0], function (key, val) {
        categories_options_html +=
          "<option value='" + val.OKytNo + "'>" + val.NevIsmi + "</option>";
      });
      resolve(categories_options_html);
    });
  });
}
async function harcamaNevleriGetir() {
  categories_options_html = await harcamaNevleri();
  $("#RbtHarcamaNevleri").html(categories_options_html);
  document.getElementById("RbtHarcamaNevleri").value = "";
}

function harcamaHucreleriniBosalt() {
  if (sonKaydedilenHarcamaTarihi) {
    document.getElementById("HarcamaTarih").value = yilAyGunTarih(sonKaydedilenHarcamaTarihi);
  } else {
    document.getElementById("HarcamaTarih").value = "";
  }
  document.getElementById("RbtHarcamaNevleri").value = "";
  document.getElementById("HarcamaMikdar").value = "";
  document.getElementById("HarcamaIzah").value = "";
  document.getElementById("HarcamaOKytNo").value = null;
  document.getElementById("HarcamaIndexNo").value = null;
}

$(document).ready(function () {
  harcamaHucreleriniBosalt();
  harcamaNevleriGetir();
});

function harcamayiKaydet(form) {
  let OKytNo = document.getElementById('HarcamaOKytNo').value;
  //console.log(OKytNo)
  let form_data = JSON.stringify($(form).serializeObject());
  let talep_tipi;
  if (OKytNo) {
    talep_tipi = 'PUT';
  } else {
    talep_tipi = 'POST';
  }
  $.ajax({
    url: "ss/slim/harcama",
    type: talep_tipi,
    contentType: "application/json",
    data: form_data,
    success: function (response) {
      if (response.Netice === "Tamam") {
        if (talep_tipi === 'POST') {
          harcamalarDizi.unshift(response.Veriler);
          sonKaydedilenHarcamaTarihi = new Date(document.getElementById("HarcamaTarih").value);
        } else {
          //OKytNo dan bul, update et. 
          anahtarliDiziElemaniGuncelle(harcamalarDizi, 'OKytNo', OKytNo, response.Veriler);
          harcamaFormuModuAyarla('Kaydet');
        }
        harcamalarSayfalamaOlustur(bootpagHarcamalar.cariSahife());
        harcamalariListele(bootpagHarcamalar.cariSahife());
        harcamaHucreleriniBosalt();
        document.getElementById("HarcamaTarih").focus();
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
