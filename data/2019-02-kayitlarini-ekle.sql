use asg_hss;
/* Gelir Nevleri*/
Insert Into GelirNevleri (NevIsmi,AnaOKytNo) VALUES
	('Maaş', 0),
	('İkramiye', 0),
	('Döner Sermaye', 0),
	('Maaş Farkı', 0),	
	('Ek Ödeme', 0),
	('Sair', 0),	
;
Insert Into GelirNevleri (NevIsmi,AnaOKytNo) VALUES('Sair', 0);

/* Varidat Nevleri*/
Insert Into VaridatNevleri (NevIsmi,AnaOKytNo, SiraNo) VALUES
	('Nakit', 0, 1),
	('Ma''denî', 0, 2),
	('1. Hafta', 0,3),
	('2. Hafta', 0,4),
	('3. Hafta', 0,5),
	('4. Hafta', 0,6),
	('KT', 0,7),	
    ('ZB', 0,8),
    ('Sair-1', 0,9),
    ('Sair-2', 0,10);
   
/* Harcama Nevleri*/
Insert Into HarcamaNevleri (NevIsmi,AnaOKytNo) VALUES
	('Sağlık', 0),
	('Gıda', 0),
	('Yakıt', 0),
	('Fatura', 0),	
	('Kırt-Eğitim', 0),	
	('Yol', 0),	
	('İkamet', 0),	
	('Temizlik', 0),
	('Hırd-Elt', 0),
	('Araba', 0),
	('Giyim-Tekstil', 0),
	('Mutfak', 0);

SELECT @AnaOKytNo := OKytNo from HarcamaNevleri WHERE NevIsmi = 'Gıda';
Insert Into HarcamaNevleri (NevIsmi,AnaOKytNo) VALUES	
	('Meyve', @AnaOKytNo),	
	('Sebze', @AnaOKytNo),	
	('Kahvaltılık', @AnaOKytNo),	
	('Şarküteri', @AnaOKytNo),	
	('Kuru-Baklagiller', @AnaOKytNo),
	('Unlu Mamüller', @AnaOKytNo);	
	
SELECT @AnaOKytNo := OKytNo from HarcamaNevleri WHERE NevIsmi = 'Kuru-Baklagiller';	
Insert Into HarcamaNevleri (NevIsmi,AnaOKytNo) VALUES	
	('Kuru Fasülye', @AnaOKytNo),	
	('Barbunya', @AnaOKytNo),	
	('Nohut', @AnaOKytNo),	
	('Mercimek', @AnaOKytNo);	
	
SELECT @AnaOKytNo := OKytNo from HarcamaNevleri WHERE NevIsmi = 'Unlu Mamüller';	
Insert Into HarcamaNevleri (NevIsmi,AnaOKytNo) VALUES	
	('Ekmek', @AnaOKytNo),	
	('Bisküvi', @AnaOKytNo);		

SELECT @AnaOKytNo := OKytNo from HarcamaNevleri WHERE NevIsmi = 'Giyim-Tekstil';	
Insert Into HarcamaNevleri (NevIsmi,AnaOKytNo) VALUES	
	('Örtü', @AnaOKytNo),
	('Ayakkabı', @AnaOKytNo),	
	('Giyim', @AnaOKytNo);	
	
