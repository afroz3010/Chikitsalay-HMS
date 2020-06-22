CREATE TABLE Patients (
    PatientID varchar(255) NOT NULL,
    PatientName varchar(255) NOT NULL,
    Age varchar(255) NOT NULL,
    Sex varchar(255) NOT NULL,
    RailwayEmployee varchar(10) NOT NULL,
    RailwayEmployeeID varchar(255),
    AadharNumber varchar(50),
    GovtID varchar(50),
    MobileNumber varchar(15) NOT NULL,
    Address varchar(255) NOT NULL,
    DOA date NOT NULL,
    Status varchar(15);
    PRIMARY KEY (PatientID)
);