use asg_hss;

/*Drop Table IF EXISTS HarcamaNevleri;*/

CREATE TABLE IF NOT EXISTS Kullanicilar(
	OKytNo			Int		Not Null AUTO_INCREMENT,
    KaydTarihi     		DATETIME DEFAULT CURRENT_TIMESTAMP,
    modification_time 	DATETIME ON UPDATE CURRENT_TIMESTAMP,	
	isim 				VarChar(180) NOT NULL,
	kisim 				VarChar(180) NOT NULL,
	kmail 				VarChar(180) NOT NULL,	
	ksifre 				VarChar(180) NOT NULL,
		CONSTRAINT PK__Kullanicilar__OKytNo PRIMARY KEY(OKytNo)
);

CREATE TABLE IF NOT EXISTS HarcamaNevleri(
	OKytNo			Int		Not Null AUTO_INCREMENT,
    KaydTarihi     		DATETIME DEFAULT CURRENT_TIMESTAMP,
    modification_time 	DATETIME ON UPDATE CURRENT_TIMESTAMP,	
	NevIsmi 			VarChar(180) NOT NULL,
	AnaOKytNo			Int     Not Null Default 0,
	OrgKodu 			varchar(100) NULL,
	Seviye 				int NULL,
	SiraNo 				int NULL,
	Kullaniliyor 		BOOLEAN NOT NULL DEFAULT FALSE,
	AltKategoriVarMi 	BOOLEAN NOT NULL DEFAULT FALSE,	
	CONSTRAINT PK__HarcamaNevleri__OKytNo PRIMARY KEY(OKytNo),
	CONSTRAINT HarcamaNevlerim_UN UNIQUE KEY (NevIsmi)
);

/*Drop Table Harcamalar;*/
CREATE TABLE IF NOT EXISTS Harcamalar(
	OKytNo				Int				Not Null AUTO_INCREMENT,
    KaydTarihi     		DATETIME 		DEFAULT CURRENT_TIMESTAMP,
    modification_time 	DATETIME 		ON UPDATE CURRENT_TIMESTAMP,	
	Tarih 				Date 			NOT NULL,
	RbtHarcamaNevleri	Int				Not Null,
	Mikdar				Decimal(10,2)	Not Null,
	Izah				VarChar(100)	Null,	
	CONSTRAINT PK__Harcamalar__OKytNo PRIMARY KEY(OKytNo),
	CONSTRAINT FK__Harcamalar__RbtHarcamaNevleri FOREIGN KEY (RbtHarcamaNevleri) REFERENCES HarcamaNevleri(OKytNo)	
);

CREATE TABLE IF NOT EXISTS GelirNevleri(
	OKytNo			Int		Not Null AUTO_INCREMENT,
    KaydTarihi     		DATETIME DEFAULT CURRENT_TIMESTAMP,
    modification_time 	DATETIME ON UPDATE CURRENT_TIMESTAMP,	
	NevIsmi 			VarChar(180) NOT NULL,
	AnaOKytNo			Int     Not Null Default 0,
	OrgKodu 			varchar(100) NULL,
	Seviye 				int NULL,
	SiraNo 				int NULL,
	Kullaniliyor 		BOOLEAN NOT NULL DEFAULT FALSE,
	AltKategoriVarMi 	BOOLEAN NOT NULL DEFAULT FALSE,	
	CONSTRAINT PK__GelirNevleri__OKytNo PRIMARY KEY(OKytNo),
	CONSTRAINT GelirNevlerim_UN UNIQUE KEY (NevIsmi)
);

CREATE TABLE IF NOT EXISTS Gelirler(
	OKytNo				Int				Not Null AUTO_INCREMENT,
    KaydTarihi     		DATETIME 		DEFAULT CURRENT_TIMESTAMP,
    modification_time 	DATETIME 		ON UPDATE CURRENT_TIMESTAMP,	
	Tarih 				Date 			NOT NULL,
	RbtGelirNevleri	Int				Not Null,
	Mikdar				Decimal(10,2)	Not Null,
	Izah				VarChar(100)	Null,	
	CONSTRAINT PK__Gelirler__OKytNo PRIMARY KEY(OKytNo),
	CONSTRAINT FK__Gelirler__RbtGelirNevleri FOREIGN KEY (RbtGelirNevleri) REFERENCES GelirNevleri(OKytNo)	
);

CREATE TABLE IF NOT EXISTS VaridatNevleri(
	OKytNo			Int		Not Null AUTO_INCREMENT,
    KaydTarihi     		DATETIME DEFAULT CURRENT_TIMESTAMP,
    modification_time 	DATETIME ON UPDATE CURRENT_TIMESTAMP,	
	NevIsmi 			VarChar(180) NOT NULL,
	AnaOKytNo			Int     Not Null Default 0,
	OrgKodu 			varchar(100) NULL,
	Seviye 				int NULL,
	SiraNo 				int NULL,
	Kullaniliyor 		BOOLEAN NOT NULL DEFAULT FALSE,
	AltKategoriVarMi 	BOOLEAN NOT NULL DEFAULT FALSE,	
	CONSTRAINT PK__VaridatNevleri__OKytNo PRIMARY KEY(OKytNo),
	CONSTRAINT VaridatNevlerim_UN UNIQUE KEY (NevIsmi)
);

CREATE TABLE IF NOT EXISTS Varidatlar(
	OKytNo				Int				Not Null AUTO_INCREMENT,
    KaydTarihi     		DATETIME 		DEFAULT CURRENT_TIMESTAMP,
    modification_time 	DATETIME 		ON UPDATE CURRENT_TIMESTAMP,	
	Tarih 				Date 			NOT NULL,
	RbtVaridatNevleri	Int				Not Null,
	Mikdar				Decimal(10,2)	Not Null,
	Izah				VarChar(100)	Null,	
	CONSTRAINT PK__Varidatlar__OKytNo PRIMARY KEY(OKytNo),
	CONSTRAINT FK__Varidatlar__RbtVaridatNevleri FOREIGN KEY (RbtVaridatNevleri) REFERENCES VaridatNevleri(OKytNo)	
);