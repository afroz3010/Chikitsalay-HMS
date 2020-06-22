CREATE TABLE TreatmentTable (
    TimeStamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PatientID varchar(255) NOT NULL,
    TreatmentDate date NOT NULL,
    Medication varchar(255) NOT NULL,
    Dose varchar(50) NOT NULL,
    Route varchar(50) NOT NULL,
    Frequency varchar(15) NOT NULL,
    CONSTRAINT FOREIGN KEY (PatientID) REFERENCES Patients (PatientID)
);