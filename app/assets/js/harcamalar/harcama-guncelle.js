function harcamayiDuzeltmeyeHazirla(pIndex) {
  hucrelereHarcamaAktar(pIndex);
  harcamaFormuModuAyarla('Güncelle');
}

function harcamaDuzeltmeyiIptalEt() {
  harcamaHucreleriniBosalt();
  harcamaFormuModuAyarla('Kaydet');
}

function harcamaFormuModuAyarla(pMod) {
  if (pMod === 'Kaydet') {
    document.getElementById("btnKaydet").innerText = "Kaydı Ekle";
    document.getElementById("btnGuncellemeyiIptalEt").style.display = "none";
  } else {
    document.getElementById("btnKaydet").innerText = "Kaydı Güncelle";
    document.getElementById("btnGuncellemeyiIptalEt").style.display = "block";
  }
}

function hucrelereHarcamaAktar(pIndex) {
  document.getElementById("HarcamaOKytNo").value = harcamalarDizi[pIndex].OKytNo;
  document.getElementById("HarcamaTarih").value = harcamalarDizi[pIndex].Tarih;
  document.getElementById("RbtHarcamaNevleri").value =
    harcamalarDizi[pIndex].RbtHarcamaNevleri;
  document.getElementById("HarcamaMikdar").value = harcamalarDizi[pIndex].Mikdar;
  document.getElementById("HarcamaIzah").value = harcamalarDizi[pIndex].Izah;
  document.getElementById("HarcamaIndexNo").value = pIndex;

}
