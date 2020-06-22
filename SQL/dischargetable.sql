CREATE TABLE InPatientTable (
    PatientID varchar(255) NOT NULL,
    DOA date NOT NULL,
    DOD date DEFAULT "0000-00-00" NOT NULL,
    ChiefComplaints varchar(255) DEFAULT "" NOT NULL,
    HospitalTreatment varchar(255) DEFAULT "" NOT NULL,
    MedicationAdvised varchar(255) DEFAULT "" NOT NULL,
    ConditionAtDischarge varchar(255) DEFAULT "" NOT NULL,
    FollowUp varchar(255) DEFAULT "" NOT NULL,
    DoctorName varchar(255) DEFAULT "" NOT NULL,
    PRIMARY KEY(PatientID),
    CONSTRAINT FOREIGN KEY (PatientID) REFERENCES Patients (PatientID)
);