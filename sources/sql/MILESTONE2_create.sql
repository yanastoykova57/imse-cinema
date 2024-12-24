-- 1. Creating Cinema Table
CREATE TABLE Cinema (
    CinemaID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL,
    PhoneNr VARCHAR(15)
);

-- 2. Create Movie Table
CREATE TABLE Movie (
    MovieID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(100) NOT NULL,
    Genre VARCHAR(50)
);

-- 3. Create Plays Relationship (Cinema plays Movies)
CREATE TABLE Plays (
    CinemaID INT NOT NULL,
    MovieID INT NOT NULL,
    PRIMARY KEY (CinemaID, MovieID),
    FOREIGN KEY (CinemaID) REFERENCES Cinema(CinemaID) ON DELETE CASCADE,
    FOREIGN KEY (MovieID) REFERENCES Movie(MovieID) ON DELETE CASCADE
);

-- 4. Create Customer Table
CREATE TABLE Customer (
    CustomerID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerName VARCHAR(100) NOT NULL,
    CustomerPhoneNr VARCHAR(15),
    RecommenderID INT,
    CinemaID INT,
    FOREIGN KEY (RecommenderID) REFERENCES Customer(CustomerID) ON DELETE SET NULL,
    FOREIGN KEY (CinemaID) REFERENCES Cinema(CinemaID) ON DELETE SET NULL
);

-- 5. Create Product Table
CREATE TABLE Product (
    ProductID INT PRIMARY KEY AUTO_INCREMENT,
    Price DECIMAL(10, 2) NOT NULL,
    ProductDescription VARCHAR(255),
    CustomerID INT,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID) ON DELETE SET NULL
);

-- 6. Create Sale Table
CREATE TABLE Sale (
    ProductID INT NOT NULL,
    SaleID INT NOT NULL,
    Percent DECIMAL(5, 2) NOT NULL,
    SaleName VARCHAR(50),
    PRIMARY KEY (ProductID, SaleID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID) ON DELETE CASCADE
);

-- 8. Create Ticket Table as a Subtype of Product
CREATE TABLE Ticket (
    ProductID INT PRIMARY KEY,
    ShowTime DATETIME,
    SeatNr INT NOT NULL CHECK (SeatNr BETWEEN 1 AND 100),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID) ON DELETE CASCADE
);

-- 9. Create Snack Table as a Subtype of Product
CREATE TABLE Snack (
    ProductID INT PRIMARY KEY,
    Size ENUM('Small', 'Medium', 'Large') NOT NULL,
    Brand VARCHAR(50) NOT NULL,
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID) ON DELETE CASCADE
);
