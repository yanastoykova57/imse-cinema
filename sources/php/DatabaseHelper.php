<?php

class DatabaseHelper
{
    const DB_HOST = 'db';
    const DB_NAME = 'cinema_db';
    const DB_USER = 'cinema_user';
    const DB_PASS = 'userpassword';
    const DB_CHARSET = 'utf8mb4';

    protected $conn;

    public function __construct()
    {
        $dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME . ";charset=" . self::DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
            PDO::ATTR_EMULATE_PREPARES   => false,                 
        ];

        try {
            $this->conn = new PDO($dsn, self::DB_USER, self::DB_PASS, $options);
        } catch (PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->conn = null;
    }

    public function selectFromEmployeeWhere($Kinoid)
    {
        $sql = "SELECT * FROM Mitarbeiter
                WHERE Kinoid LIKE :kinoid
                ORDER BY Kinoid ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kinoid' => "%{$Kinoid}%"]);
        return $stmt->fetchAll();
    }

    public function selectFromPurchaseWhere($KundenNr)
    {
        $sql = "SELECT * FROM Kauf
                WHERE KundenNr = :kundenNr
                ORDER BY Preis ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kundenNr' => $KundenNr]);
        return $stmt->fetchAll();
    }

    public function selectFromClientWhere($KundenNr)
    {
        $sql = "CALL GetKundeInfo(:kundenNr, @pname, @pphone, @rkundenNr)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':kundenNr', $KundenNr, PDO::PARAM_INT);
        $stmt->execute();
        $result = $this->conn->query("SELECT @pname AS pname, @pphone AS pphone, @rkundenNr AS rkundenNr")->fetch();

        return [
            'KUNDENNR' => $result['rkundenNr'],
            'NAME' => $result['pname'],
            'TELEFONNR' => $result['pphone']
        ];
    }

    public function selectKinoIDs()
    {
        $sql = "SELECT KinoID FROM Kino";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function selectKundenNR()
    {
        $sql = "SELECT KundenNr FROM Kunde";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function insertIntoMitarbeiter($SV_Nummer, $MitarbeiterName, $Kinoid, $E_Mail, $Gehalt, $Leiter_SV_Nummer)
    {
        $sql = "INSERT INTO Mitarbeiter (SV_Nummer, MitarbeiterName, Kinoid, E_Mail, Gehalt, Leiter_SV_Nummer) 
                VALUES (:sv, :name, :kinoid, :email, :salary, :manager)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'sv' => $SV_Nummer,
            'name' => $MitarbeiterName,
            'kinoid' => $Kinoid,
            'email' => $E_Mail,
            'salary' => $Gehalt,
            'manager' => $Leiter_SV_Nummer
        ]);
    }

    public function insertIntoKino($Name, $Adresse, $TelefonNr)
    {
        $sql = "INSERT INTO Kino (Name, Adresse, TelefonNr) VALUES (:name, :adresse, :telefonNr)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'name' => $Name,
            'adresse' => $Adresse,
            'telefonNr' => $TelefonNr
        ]);
    }

    public function insertIntoEmploys($SV_Nummer, $KinoID)
    {
        $sql = "INSERT INTO beschaeftigt (SV_Nummer, KinoID) VALUES (:sv, :kinoid)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'sv' => $SV_Nummer,
            'kinoid' => $KinoID
        ]);
    }

    public function insertIntoClient($KundenNr, $Name, $TelefonNr)
    {
        $sql = "INSERT INTO Kunde (KundenNr, Name, TelefonNr) VALUES (:kundenNr, :name, :telefonNr)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'kundenNr' => $KundenNr,
            'name' => $Name,
            'telefonNr' => $TelefonNr
        ]);
    }

    public function insertIntoSells($KundenNr, $ProduktNr, $SV_Nummer)
    {
        $sql = "INSERT INTO verkauft (KundenNr, ProduktNr, SV_Nummer) VALUES (:kundenNr, :produktNr, :sv)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'kundenNr' => $KundenNr,
            'produktNr' => $ProduktNr,
            'sv' => $SV_Nummer
        ]);
    }

    public function insertIntoProduct($ProduktNr, $Bezeichnung, $Preis, $KaufNR)
    {
        $sql = "INSERT INTO Produkt (ProduktNr, Bezeichnung, Preis, KaufNR)
                VALUES (:produktNr, :bezeichnung, :preis, :kaufNr)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'produktNr' => $ProduktNr,
            'bezeichnung' => $Bezeichnung,
            'preis' => $Preis,
            'kaufNr' => $KaufNR
        ]);
    }

    public function insertIntoPayment($RechnungsNr, $KaufNr, $Zahlungsart, $Summe)
    {
        $sql = "INSERT INTO Bezahlung (RechnungsNr, KaufNr, Zahlungsart, Summe) 
                VALUES (:rechnungsNr, :kaufNr, :zahlungsart, :summe)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'rechnungsNr' => $RechnungsNr,
            'kaufNr' => $KaufNr,
            'zahlungsart' => $Zahlungsart,
            'summe' => $Summe
        ]);
    }

    public function insertIntoPurchase($KaufNr, $Datum, $Preis, $KundenNr)
    {
        $sql = "INSERT INTO Kauf (KaufNr, Datum, Preis, KundenNr) 
                VALUES (:kaufNr, STR_TO_DATE(:datum, '%Y-%m-%d'), :preis, :kundenNr)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'kaufNr' => $KaufNr,
            'datum' => $Datum,
            'preis' => $Preis,
            'kundenNr' => $KundenNr
        ]);
    }

    public function deleteMitarbeiter($SV_Nummer)
    {
        $sql = 'DELETE FROM Mitarbeiter WHERE SV_Nummer = :sv';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['sv' => $SV_Nummer]);
    }

    public function deletePayment($RechnungsNr)
    {
        $sql = 'DELETE FROM Bezahlung WHERE RechnungsNr = :rechnungsNr';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['rechnungsNr' => $RechnungsNr]);
    }

    public function updateSalary($SV_Nummer, $new_salary)
    {
        $sql = "UPDATE Mitarbeiter SET Gehalt = :gehalt WHERE SV_Nummer = :sv";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'gehalt' => $new_salary,
            'sv' => $SV_Nummer
        ]);
    }

    public function updatePhone($KundenNr, $new_phonenr)
    {
        $sql = "UPDATE Kunde SET TelefonNr = :telefonNr WHERE KundenNr = :kundenNr";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'telefonNr' => $new_phonenr,
            'kundenNr' => $KundenNr
        ]);
    }
}
