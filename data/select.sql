use asg_hss;

SELECT OKytNo, KaydTarihi, modification_time, Tarih, (Select NevIsmi From VaridatNevleri Where OKytNo = RbtVaridatNevleri) As Nev, RbtVaridatNevleri, Mikdar, Izah,
       (Select SiraNo From VaridatNevleri Where OKytNo = RbtVaridatNevleri) As SiraNo
            FROM Varidatlar            
            Order By SiraNo;	

Select (SELECT IFNULL(Sum(Mikdar), 0) As Yekun FROM Gelirler)As gelirlerYekunu,
       (SELECT IFNULL(Sum(Mikdar), 0) As Yekun FROM Harcamalar)As harcamalarYekunu,
       (SELECT IFNULL(Sum(Mikdar), 0) As Yekun FROM Varidatlar)As varidatlarYekunu
;       
