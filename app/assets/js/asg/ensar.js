$("body").on("keydown", "input, select, textarea", function(e) {
  var self = $(this),
    form = self.parents("form:eq(0)"),
    focusable,
    next;
  if (e.keyCode == 13) {
    focusable = form.find("input,a,select,button,textarea").filter(":visible");
    next = focusable.eq(focusable.index(this) + 1);
    if (next.length) {
      next.focus();
    } else {
      form.submit();
    }
    return false;
  }
});

function anahtarliDiziyeElemaniEkle(pAnaDizi, pEklenecek, pPoz) {
  //0 Elemanın silinmeyeceğini ifade eder.
  pAnaDizi.splice(pPoz, 0, pEklenecek);
}

function anahtarliDiziElemaniSil_jq(pAnaDizi, pAlan, pDeger) {
  let yeniDizi = $.grep(pAnaDizi, function(eleman) {
    return eleman[pAlan] != pDeger;
  });
  return yeniDizi;
}

function anahtarliDiziElemaniSil(pAnaDizi, pAlan, pDeger) {
  for (let i = 0; i < pAnaDizi.length; i++) {
    if (pAnaDizi[i][pAlan] == pDeger) {
      pAnaDizi.splice(i, 1);
      break;
    }
  }
}

function anahtarliDiziElemaniGuncelle(pAnaDizi, pAlan, pDeger, pVeriler) {
  pAnaDizi.forEach(function(diziElemani) {
    if (diziElemani[pAlan] == pDeger) {
      for (var k in diziElemani) {
        if (diziElemani.hasOwnProperty(k)) {
          diziElemani[k] = pVeriler[k];
        }
      }
    }
  });
}

function formatDate(stringDate) {
  var date = new Date(stringDate);
  return (
    ("0" + date.getDate()).slice(-2) +
    "." +
    ("0" + (date.getMonth() + 1)).slice(-2) +
    "." +
    date.getFullYear()
  );
}

$.fn.serializeObject = function() {
  var o = {};
  var a = this.serializeArray();
  $.each(a, function() {
    if (o[this.name] !== undefined) {
      if (!o[this.name].push) {
        o[this.name] = [o[this.name]];
      }
      o[this.name].push(this.value || "");
    } else {
      o[this.name] = this.value || "";
    }
  });
  return o;
};

function yilAyGunTarih(pTarih) {
  var day = ("0" + pTarih.getDate()).slice(-2);
  var month = ("0" + (pTarih.getMonth() + 1)).slice(-2);
  return pTarih.getFullYear() + "-" + month + "-" + day;
}

function donemGetir(ilkTarih) {
  var gun = ilkTarih.getDate();
  if (gun < 15) {
    ilkTarih.setMonth(ilkTarih.getMonth() - 1);
  }
  ilkTarih.setDate(15);
  var sonTarih = new Date(ilkTarih);
  sonTarih.setMonth(sonTarih.getMonth() + 1);
  sonTarih.setDate(14);
  return {
    ilkTarih: yilAyGunTarih(ilkTarih),
    sonTarih: yilAyGunTarih(sonTarih)
  };
}
