-- ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS';
CREATE SCHEMA if not exists hospital;
CREATE DATABASE if not exists hospital;
use hospital;
DROP TABLE if exists InsurancePayment;
DROP TABLE if exists DebitCreditPayment;
DROP TABLE if exists CheckPayment;
DROP TABLE if exists CashPayment;
DROP TABLE if exists PaymentForService;
DROP TABLE if exists ServiceStaffModifiesRecord;
DROP TABLE if exists MedicalRecord;
DROP TABLE if exists StaffProvideService;
DROP TABLE if exists HospitalStaff;
DROP TABLE if exists ServiceBooking;
DROP TABLE if exists Patient;


CREATE TABLE Patient(
    PatientIDNumber CHAR(9) PRIMARY KEY,
    PatientName VARCHAR(40) NOT NULL,
    DateOfBirth DATE,
    BloodType VARCHAR(3),
    Sex CHAR(1),
    Address VARCHAR(40),
    PhoneNumber CHAR(12),
    CHECK (LENGTH(PhoneNumber) = 12)
);

CREATE TABLE ServiceBooking(
    RoomNumber CHAR(5),
    DateOfIntake DATETIME,
    PatientIDNumber CHAR(9) NOT NULL,
    DateofDeparture DATETIME,
    ReasonForVisit VARCHAR(40),
    Cost INT,
    PRIMARY KEY (RoomNumber, DateOfIntake),
    CONSTRAINT PatientService UNIQUE (PatientIDNumber, DateOfIntake),
    FOREIGN KEY (PatientIDNumber) REFERENCES Patient (PatientIDNumber)
);

CREATE TABLE HospitalStaff(
    StaffIDNumber CHAR(9) PRIMARY KEY,
    StaffName VARCHAR(40) NOT NULL,
    EmploymentPosition VARCHAR(20) NOT NULL,

    CHECK (LENGTH(StaffPassword) > 4)
);

CREATE TABLE StaffProvideService(
    StaffIDNumber CHAR(9),
    RoomNumber CHAR(5) NOT NULL,
    DateofIntake DATETIME,
    PRIMARY KEY (StaffIDNumber, DateofIntake),
    FOREIGN KEY (RoomNumber, DateofIntake) REFERENCES ServiceBooking(RoomNumber, DateofIntake)
        ON DELETE CASCADE
);

CREATE TABLE MedicalRecord(
    PatientIDNumber CHAR(9),
    RecordNumber INT,
    Category VARCHAR(20) NOT NULL,
    Description VARCHAR(80),
    DateOfRecord DATE NOT NULL,
    PRIMARY KEY (PatientIDNumber, RecordNumber),
    FOREIGN KEY (PatientIDNumber) REFERENCES Patient(PatientIDNumber)
);

CREATE TABLE ServiceStaffModifiesRecord(
    PatientIDNumber CHAR(9),
    RecordNumber INT,
    StaffIDNumber CHAR(9) NOT NULL,
    RoomNumber CHAR(5),
    DateOfIntake DATETIME,
    PRIMARY KEY (PatientIDNumber, RecordNumber),
    FOREIGN KEY (PatientIDNumber) REFERENCES Patient(PatientIDNumber),
    FOREIGN KEY (PatientIDNumber, RecordNumber) REFERENCES MedicalRecord(PatientIDNumber, RecordNumber)
        ON DELETE CASCADE,
    FOREIGN KEY (StaffIDNumber) REFERENCES HospitalStaff(StaffIDNumber),
    FOREIGN KEY (RoomNumber, DateOfIntake) REFERENCES ServiceBooking(RoomNumber, DateofIntake)
        ON DELETE SET NULL
);

CREATE TABLE PaymentForService(
    ReceiptNumber INT PRIMARY KEY,
    PaymentAmount INT NOT NULL,
    PaymentDate DATE NOT NULL,
    PatientIDNumber CHAR(9) NOT NULL,
    RoomNumber CHAR(5) NOT NULL,
    DateOfIntake DATETIME NOT NULL,
    FOREIGN KEY (PatientIDNumber) REFERENCES Patient(PatientIDNumber),
    FOREIGN KEY (RoomNumber, DateOfIntake) REFERENCES ServiceBooking(RoomNumber, DateOfIntake)
        ON DELETE CASCADE
);

CREATE TABLE CashPayment(
    ReceiptNumber INT PRIMARY KEY,
    CashPayerName VARCHAR(40) NOT NULL,
    FOREIGN KEY (ReceiptNumber) REFERENCES PaymentForService(ReceiptNumber)
        ON DELETE CASCADE
);

CREATE TABLE CheckPayment(
    ReceiptNumber INT PRIMARY KEY,
    CheckPayerName VARCHAR(40) NOT NULL,
    RoutingNumber VARCHAR(19) NOT NULL,
    FOREIGN KEY (ReceiptNumber) REFERENCES PaymentForService(ReceiptNumber)
        ON DELETE CASCADE
);

CREATE TABLE DebitCreditPayment(
    ReceiptNumber INT PRIMARY KEY,
    CardholderName VARCHAR(40) NOT NULL,
    CardNumber CHAR(16) NOT NULL,
    ExpiryDate DATE NOT NULL,
    SecurityCode INT NOT NULL,
    FOREIGN KEY (ReceiptNumber) REFERENCES PaymentForService(ReceiptNumber)
        ON DELETE CASCADE
);

CREATE TABLE InsurancePayment(
    ReceiptNumber INT PRIMARY KEY,
    InsuranceProvider VARCHAR(40) NOT NULL,
    InsuranceIDNumber VARCHAR(20),
    FOREIGN KEY (ReceiptNumber) REFERENCES PaymentForService(ReceiptNumber)
        ON DELETE CASCADE
);



