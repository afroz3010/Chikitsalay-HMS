CREATE TABLE admins (
 Name varchar(20) NOT NULL,
 Contact varchar(15) NOT NULL,
 UserID varchar(15) NOT NULL,
 Password varchar(100) NOT NULL,
 PRIMARY KEY (UserID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE doctors (
 UserID varchar(255) NOT NULL,
 Password varchar(255) NOT NULL,
 Name varchar(255) DEFAULT NULL,
 Contact varchar(255) DEFAULT NULL,
 PRIMARY KEY (UserID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE patients (
 PatientID varchar(255) NOT NULL,
 PatientName varchar(255) NOT NULL,
 Age varchar(255) NOT NULL,
 Sex varchar(255) NOT NULL,
 RailwayEmployee varchar(10) NOT NULL,
 RailwayEmployeeID varchar(255) DEFAULT NULL,
 AadharNumber varchar(50) DEFAULT NULL,
 GovtID varchar(50) DEFAULT NULL,
 MobileNumber varchar(15) NOT NULL,
 Address varchar(255) NOT NULL,
 DOA date NOT NULL,
 TOA time NOT NULL,
 Status varchar(15) DEFAULT NULL,
 PRIMARY KEY (PatientID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE investigationtable (
 PatientID varchar(255) NOT NULL,
 ICDate date NOT NULL,
 ICTime varchar(10) NOT NULL,
 HB varchar(50) DEFAULT NULL,
 TLC varchar(50) DEFAULT NULL,
 PLT varchar(50) DEFAULT NULL,
 HCT varchar(50) DEFAULT NULL,
 FBS varchar(50) DEFAULT NULL,
 PPBS varchar(50) DEFAULT NULL,
 RBS varchar(50) DEFAULT NULL,
 HBA1C varchar(50) DEFAULT NULL,
 BUREA varchar(50) DEFAULT NULL,
 CREAT varchar(50) DEFAULT NULL,
 NA varchar(50) DEFAULT NULL,
 K varchar(50) DEFAULT NULL,
 CL varchar(50) DEFAULT NULL,
 TBIL varchar(50) DEFAULT NULL,
 DIRECT varchar(50) DEFAULT NULL,
 INDIRECT varchar(50) DEFAULT NULL,
 SGOT varchar(50) DEFAULT NULL,
 SGPT varchar(50) DEFAULT NULL,
 ALP varchar(50) DEFAULT NULL,
 ALBUMIN varchar(50) DEFAULT NULL,
 GLOBULIN varchar(50) DEFAULT NULL,
 BT varchar(50) DEFAULT NULL,
 CCT varchar(50) DEFAULT NULL,
 PTINR varchar(50) DEFAULT NULL,
 DENGUE varchar(50) DEFAULT NULL,
 MP varchar(50) DEFAULT NULL,
 WIDAL varchar(50) DEFAULT NULL,
 PUSCELLS varchar(50) DEFAULT NULL,
 RBC varchar(50) DEFAULT NULL,
 SUGARS varchar(50) DEFAULT NULL,
 KETONE varchar(50) DEFAULT NULL,
 HIV varchar(50) DEFAULT NULL,
 HBSAG varchar(50) DEFAULT NULL,
 HCV varchar(50) DEFAULT NULL,
 CHESTXRAY varchar(50) DEFAULT NULL,
 USG varchar(50) DEFAULT NULL,
 ICT varchar(50) DEFAULT NULL,
 MRI varchar(50) DEFAULT NULL,
 ECG varchar(50) DEFAULT NULL,
 TROPI varchar(50) DEFAULT NULL,
 ECHO varchar(50) DEFAULT NULL,
 SPECIFICINVEST varchar(50) DEFAULT NULL,
 SWAB varchar(50) DEFAULT NULL,
 RAPIDANTIGENTEST varchar(50) DEFAULT NULL,
 ABG varchar(50) DEFAULT NULL,
 PROCALCITONIN varchar(50) DEFAULT NULL,
 InvestigationOthers varchar(255) NOT NULL,
 PRIMARY KEY (PatientID,ICDate,ICTime),
 CONSTRAINT investigationtable_ibfk_1 FOREIGN KEY (PatientID) REFERENCES patients (PatientID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE nurses (
 UserID varchar(255) NOT NULL,
 Password varchar(255) NOT NULL,
 Name varchar(255) DEFAULT NULL,
 Contact varchar(255) DEFAULT NULL,
 PRIMARY KEY (UserID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE patientcheckup (
 PatientID varchar(255) NOT NULL,
 DOC date NOT NULL,
 TOC time NOT NULL,
 Cold varchar(5) NOT NULL DEFAULT 'No',
 ColdDuration int(11) NOT NULL DEFAULT '0',
 Cough varchar(5) NOT NULL DEFAULT 'No',
 CoughType varchar(20) NOT NULL DEFAULT 'No',
 CoughDuration int(11) NOT NULL DEFAULT '0',
 SOB varchar(5) NOT NULL DEFAULT 'No',
 SOBDuration int(11) NOT NULL DEFAULT '0',
 Fever varchar(5) NOT NULL DEFAULT 'No',
 FeverDuration int(11) NOT NULL DEFAULT '0',
 SoreThroat varchar(5) NOT NULL DEFAULT 'No',
 TravelHistory varchar(5) NOT NULL DEFAULT 'No',
 ContactHistory varchar(5) NOT NULL DEFAULT 'No',
 OtherComplaints varchar(255) DEFAULT '',
 HTN varchar(5) NOT NULL DEFAULT 'No',
 DM varchar(5) NOT NULL DEFAULT 'No',
 IHD varchar(5) NOT NULL DEFAULT 'No',
 Asthma varchar(5) NOT NULL DEFAULT 'No',
 CLD varchar(5) NOT NULL DEFAULT 'No',
 Seizure varchar(5) NOT NULL DEFAULT 'No',
 OtherComorbidities varchar(255) DEFAULT '',
 Smoking varchar(5) NOT NULL DEFAULT 'No',
 Alcohol varchar(5) NOT NULL DEFAULT 'No',
 Gutka varchar(5) NOT NULL DEFAULT 'No',
 OtherAddictions varchar(255) DEFAULT '',
 Pallor varchar(5) NOT NULL DEFAULT 'No',
 Icterus varchar(5) NOT NULL DEFAULT 'No',
 Clubbing varchar(5) NOT NULL DEFAULT 'No',
 Cyanosis varchar(5) NOT NULL DEFAULT 'No',
 Lympadenopathy varchar(5) NOT NULL DEFAULT 'No',
 Edema varchar(20) NOT NULL DEFAULT 'No',
 Temp varchar(20) NOT NULL DEFAULT '',
 HR varchar(20) NOT NULL DEFAULT '',
 BP varchar(20) NOT NULL DEFAULT '',
 RR varchar(20) NOT NULL DEFAULT '',
 SPO2 varchar(20) NOT NULL DEFAULT '',
 CNS varchar(20) NOT NULL DEFAULT '',
 CVS varchar(20) NOT NULL DEFAULT '',
 RS varchar(20) NOT NULL DEFAULT '',
 GIT varchar(20) NOT NULL DEFAULT '',
 OtherSystemic varchar(255) DEFAULT '',
 Investigation varchar(255) DEFAULT '',
 Treatment varchar(255) DEFAULT '',
 InPatient varchar(5) DEFAULT 'No',
 PatientStatus varchar(50) NOT NULL DEFAULT '',
 CovidStatus varchar(255) NOT NULL DEFAULT '',
 FollowUp varchar(255) DEFAULT '',
 PRIMARY KEY (PatientID,DOC,TOC),
 CONSTRAINT patientcheckup_ibfk_1 FOREIGN KEY (PatientID) REFERENCES patients (PatientID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE progresstable (
 PatientID varchar(255) NOT NULL,
 DOA date NOT NULL,
 ProgressNotes varchar(255) NOT NULL DEFAULT '',
 PatientCondition varchar(25) NOT NULL DEFAULT 'STABLE',
 CovidStatus varchar(50) NOT NULL DEFAULT '',
 Plan varchar(255) NOT NULL DEFAULT '',
 PRIMARY KEY (PatientID,DOA),
 CONSTRAINT progresstable_ibfk_1 FOREIGN KEY (PatientID) REFERENCES patients (PatientID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE receptionists (
 UserID varchar(255) NOT NULL,
 Password varchar(255) NOT NULL,
 Name varchar(255) DEFAULT NULL,
 Contact varchar(255) DEFAULT NULL,
 PRIMARY KEY (UserID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;





CREATE TABLE treatmenttable (
 TimeStamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PatientID varchar(255) NOT NULL,
 TreatmentDate date NOT NULL,
 Medication varchar(255) NOT NULL,
 Dose varchar(50) NOT NULL,
 Route varchar(50) NOT NULL,
 Frequency varchar(15) NOT NULL,
 PRIMARY KEY (TimeStamp,PatientID),
 KEY PatientID (PatientID),
 CONSTRAINT treatmenttable_ibfk_1 FOREIGN KEY (PatientID) REFERENCES patients (PatientID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE vitaltable (
 PatientID varchar(255) NOT NULL,
 VitalDate date NOT NULL,
 VitalTime varchar(50) NOT NULL,
 Temp varchar(50) NOT NULL,
 HR varchar(10) NOT NULL,
 BP varchar(50) NOT NULL,
 SPO2 varchar(50) NOT NULL,
 RR varchar(50) NOT NULL,
 GRBS varchar(50) NOT NULL,
 GCS varchar(50) NOT NULL,
 VitalOthers varchar(255) NOT NULL,
 PRIMARY KEY (PatientID,VitalDate,VitalTime),
 CONSTRAINT vitaltable_ibfk_1 FOREIGN KEY (PatientID) REFERENCES patients (PatientID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE inpatienttable (
 PatientID varchar(255) NOT NULL,
 DOA date NOT NULL,
 TOA time NOT NULL,
 DOD date NOT NULL DEFAULT '9999-12-31',
 TOD time NOT NULL DEFAULT '99:99:99',
 ChiefComplaints varchar(255) NOT NULL DEFAULT '',
 HospitalTreatment varchar(255) NOT NULL DEFAULT '',
 MedicationAdvised varchar(255) NOT NULL DEFAULT '',
 ConditionAtDischarge varchar(255) NOT NULL DEFAULT '',
 FollowUp varchar(255) NOT NULL DEFAULT '',
 DoctorName varchar(255) NOT NULL DEFAULT '',
 PRIMARY KEY (PatientID,DOA,TOA),
 CONSTRAINT inpatienttable_ibfk_1 FOREIGN KEY (PatientID) REFERENCES patients (PatientID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;