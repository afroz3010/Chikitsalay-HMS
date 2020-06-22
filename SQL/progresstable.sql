CREATE TABLE ProgressTable (
    PatientID varchar(255) NOT NULL,
    DOA date NOT NULL,
    ProgressNotes varchar(255) DEFAULT "" NOT NULL,
    PatientCondition varchar(25) DEFAULT "STABLE" NOT NULL,
    CovidStatus varchar(50) DEFAULT "" NOT NULL,
    Plan varchar(255) DEFAULT "" NOT NULL,
    PRIMARY KEY(PatientID,DOA),
    CONSTRAINT FOREIGN KEY (PatientID) REFERENCES Patients (PatientID)
);