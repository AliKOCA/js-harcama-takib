function varidatyiDuzeltmeyeHazirla(pIndex) {
  hucrelereVaridatAktar(pIndex);
  varidatFormuModuAyarla('Güncelle');
}

function varidatDuzeltmeyiIptalEt() {
  varidatHucreleriniBosalt();
  varidatFormuModuAyarla('Kaydet');
}

function varidatFormuModuAyarla(pMod) {
  if (pMod === 'Kaydet') {
    document.getElementById("btnVaridatKaydet").innerText = "Kaydı Ekle";
    document.getElementById("btnVaridatGuncellemeyiIptalEt").style.display = "none";
  } else {
    document.getElementById("btnVaridatKaydet").innerText = "Kaydı Güncelle";
    document.getElementById("btnVaridatGuncellemeyiIptalEt").style.display = "block";
  }
}

function hucrelereVaridatAktar(pIndex) {
  document.getElementById("VaridatOKytNo").value = varidatlarDizi[pIndex].OKytNo;
  document.getElementById("VaridatTarih").value = varidatlarDizi[pIndex].Tarih;
  document.getElementById("RbtVaridatNevleri").value =
    varidatlarDizi[pIndex].RbtVaridatNevleri;
  document.getElementById("VaridatMikdar").value = varidatlarDizi[pIndex].Mikdar;
  document.getElementById("VaridatIzah").value = varidatlarDizi[pIndex].Izah;
  document.getElementById("VaridatIndexNo").value = pIndex;

}
