CREATE TABLE VitalTable (
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
    PRIMARY KEY (PatientID,VitalDate,VitalTime),
    FOREIGN KEY PatientID REFERENCES Patients(PatientID),
);