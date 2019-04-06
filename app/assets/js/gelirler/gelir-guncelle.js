function geliriDuzeltmeyeHazirla(pIndex) {
  hucrelereGelirAktar(pIndex);
  gelirFormuModuAyarla('Güncelle');
}

function gelirDuzeltmeyiIptalEt() {
  gelirHucreleriniBosalt();
  gelirFormuModuAyarla('Kaydet');
}

function gelirFormuModuAyarla(pMod) {
  if (pMod === 'Kaydet') {
    document.getElementById("btnGelirKaydet").innerText = "Kaydı Ekle";
    document.getElementById("btnGelirGuncellemeyiIptalEt").style.display = "none";
  } else {
    document.getElementById("btnGelirKaydet").innerText = "Kaydı Güncelle";
    document.getElementById("btnGelirGuncellemeyiIptalEt").style.display = "block";
  }
}

function hucrelereGelirAktar(pIndex) {
  document.getElementById("GelirOKytNo").value = gelirlerDizi[pIndex].OKytNo;
  document.getElementById("GelirTarih").value = gelirlerDizi[pIndex].Tarih;
  document.getElementById("RbtGelirNevleri").value =
    gelirlerDizi[pIndex].RbtGelirNevleri;
  document.getElementById("GelirMikdar").value = gelirlerDizi[pIndex].Mikdar;
  document.getElementById("GelirIzah").value = gelirlerDizi[pIndex].Izah;
  document.getElementById("GelirIndexNo").value = pIndex;
}
