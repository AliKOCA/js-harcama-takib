Create Procedure asg_hss.Prc__AsG_ND_HrcmNv__OrgKoduOlustur (IN PrAnaOKytNo INT, IN AnaOrgKodu VarChar(150) )
BEGIN	
  DECLARE AsG_ND_HrcmNvOKytNo INT;
  DECLARE OrgKodu VarChar(150);
  DECLARE SiraNo INT;
  DECLARE AltKategoriVarMi BOOLEAN;
  DECLARE done BOOL DEFAULT FALSE;
  DECLARE AltKategoriAdedi INT;
  DECLARE cur1 CURSOR FOR SELECT OKytNo 
    FROM asg_hss.HarcamaNevleri
    Where AnaOKytNo = PrAnaOKytNo
    Order By HrcmNv; 
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  OPEN cur1;
  
  read_loop: LOOP
    FETCH cur1 INTO AsG_ND_HrcmNvOKytNo;
    If done THEN
      LEAVE read_loop;
      END IF;
     
    Set SiraNo = 1;
    Set AltKategoriVarMi = 0;
    Set OrgKodu = AsG.AsGSoluDoldur( CONVERT ( VarChar(150), SiraNo), 3, '0');
    If ( LEN(AnaOrgKodu) > 0) Then
      Set OrgKodu = AnaOrgKodu + '.' + OrgKodu;
      END IF;
    Select AltKategoriAdedi = COUNT(*) From AsG_ND_HrcmNv Where AnaOKytNo = AsG_ND_HrcmNvOKytNo;     
    If (AltKategoriAdedi) > 0 Then 
      Set AltKategoriVarMi = 1;
      END IF;
    Update asg_hss.HarcamaNevleri
      Set    OrgKodu =  OrgKodu, SiraNo = SiraNo, AltKategoriVarMi = AltKategoriVarMi
      Where  OKytNo = AsG_ND_HrcmNvOKytNo;  
    If (AltKategoriVarMi = 1) Then
      Exec Prc__AsG_ND_HrcmNv__OrgKoduOlustur AsG_ND_HrcmNvOKytNo, OrgKodu;
      END IF;
    Set OrgKodu =  '';  
    Set SiraNo = SiraNo + 1;  
    END LOOP;
CLOSE cur1;
END;


