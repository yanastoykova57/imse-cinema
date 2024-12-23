package execution;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.HashSet;
import java.util.List;
import java.util.Map;
import java.util.Random;
import java.util.Set;

public class DatabaseCommands {
	
	private static final String DB_CONNECTION_URL = "jdbc:oracle:thin:@oracle19.cs.univie.ac.at:1521:orclcdb";
    private static final String USER = "a11916925"; 
    private static final String PASS = "dbs24"; 
    private static final String CLASSNAME = "oracle.jdbc.driver.OracleDriver";

    private static Statement stmt;
    private static Connection con;
    DataGenerator generator = new DataGenerator();
    
    private Map<Integer, String> prNRtoBez = new HashMap<>();
    
    Random rand = new Random();
    
  //CREATE CONNECTION
    DatabaseCommands() {
        try {
            Class.forName(CLASSNAME);

            con = DriverManager.getConnection(DB_CONNECTION_URL, USER, PASS);
            stmt = con.createStatement();

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
    
    public Statement getStmt() {
    	return stmt;
    }
    
    public void close()  {
        try {
            getStmt().close(); //clean up
            con.close();
        } catch (Exception ignored) {
        }
    }
    
    //DELETE ALL ENTRIES
    void deleteEntries() {
    	String[] tables = {
    			"Ermaessigung", "Bezahlung", "verkauft","Snacks",
    			"Tickets", "Produkt","Kauf", "Kunde", "Mitarbeiter", "Kino"
		};
    	
    	for (String elem : tables) {
			try {
				stmt.executeUpdate("DELETE FROM " + elem);
					System.out.println("Deleted from " + elem + ".");	
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
    }
    
   //KINO INSERT
    void insertIntoKino() {
    	try {
    		String sql = "INSERT INTO Kino (Name, Adresse, TelefonNr) VALUES (?,?,?)";
			PreparedStatement ps = con.prepareStatement(sql);
			
			int count = 0;
			for(String cinemaName: DataGenerator.cinemaNames) {
				ps.setString(1, cinemaName);
				ps.setString(2, generator.getCinemaAddress(cinemaName));
				ps.setInt(3, generator.getCinemaPhoneNr(cinemaName));
				ps.addBatch();
				count++;
				if(count%100 == 0 || count == DataGenerator.cinemaNames.length) ps.executeBatch();
			}
		} catch (SQLException e) {
			System.err.println("Error at: insertIntoKino\nmessage: " + e.getMessage());
		}
    }
    
    //MITARBEITER INSERT
    void insertIntoMitarbeiter() {
    	try {
    		String sql = "INSERT INTO Mitarbeiter (SV_Nummer, MitarbeiterName, Kinoid, E_Mail, Gehalt, Leiter_SV_Nummer) VALUES (?,?,?,?,?,?)";
			PreparedStatement ps = con.prepareStatement(sql);
			
			List<Integer> kinoIDs = selectKinoIDsFromKino();
			List<Integer> leiter = new ArrayList<>();
			
			int count = 0;
			for(int i = 0; i < 1000; i++) {
				int svnr = generator.randomSVNrGenerator();
				String employeeName = generator.employeeNameGenerator();
				int kid = rand.nextInt((10-1)+1) + 1;
				while(!kinoIDs.contains(kid)) kid = rand.nextInt((10 - 1)+1)+ 1;
				String email = generator.employeeEmail(employeeName);
				
				
				ps.setInt(1, svnr);
				ps.setString(2, employeeName);
				ps.setInt(3, kid); //random.nextInt(max - min + 1) + min
				ps.setString(4, email);
				if(count<20) {
					ps.setInt(5,2000);
					ps.setNull(6, java.sql.Types.INTEGER);
					leiter.add(svnr);
				} else {
					ps.setInt(5, generator.randomSalary());
					int leiterSVNr = leiter.get(rand.nextInt(leiter.size()));
					ps.setInt(6, leiterSVNr);
				}
				
				ps.addBatch();
				
				count++;
				if(count % 1000 == 0 || i == 999) {
					ps.executeBatch();
					count = 0;
				}
				//ps.executeUpdate();
			}
		} catch (SQLException e) {
			System.err.println("Error at: insertIntoMA\nmessage: " + e.getMessage());
		}
    }
    
    //KUNDE INSERT
    void insertIntoKunde() { 
    	try {
    		String sql = "INSERT INTO Kunde (KundenNr, Name, TelefonNr) VALUES (?,?,?)";
			PreparedStatement ps = con.prepareStatement(sql);
			int kundenNr = getClientNR();
			int count = 0;
			List<String> fullNames = generator.fullNameGenerator();
			for(String fullName: fullNames) {
				ps.setInt(1, ++kundenNr);
				ps.setString(2, fullName);
				ps.setInt(3, generator.randomClientPhoneNr());
				ps.addBatch();
				count++;
				if(count == fullNames.size()) ps.executeBatch();
			}
		} catch (SQLException e) {
			System.err.println("Error at: insertIntoKundeSecond\nmessage: " + e.getMessage());
		}
    }
    
    //KAUF INSERT
    void insertIntoKauf() { 
    	try {
    		String sql = "INSERT INTO Kauf (KaufNr, Datum, Preis, KundenNr) VALUES (?,?,?,?)";
			PreparedStatement ps = con.prepareStatement(sql);
			
			int kaufNr = getLastKaufNr();
			int count = 0;
			int clients = getClientNR();
			for(int i=0; i < 500; ++i) {
				int knr = ++kaufNr;
				ps.setInt(1, knr);
				ps.setDate(2, java.sql.Date.valueOf(generator.generateDate()));
				int price = rand.nextInt(40-11)+1;
				//kaufNRprice.put(knr, price);
				ps.setInt(3, price);
				int clientNr = rand.nextInt(clients)+1;
				ps.setInt(4, clientNr);
				ps.addBatch();
				count++;
				if(count % 500 == 0 || i == 499) {
					ps.executeBatch();
					count = 0;
				}
			}
		} catch (SQLException e) {
			System.err.println("Error at: insertIntoKauf\nmessage: " + e.getMessage());
		}
    }
    
    //PRODUKT INSERT
    void insertIntoProdukt() { 
    	try {
    		String sql = "INSERT INTO Produkt (ProduktNr, Bezeichnung, Preis, KaufNr) VALUES (?,?,?,?)";
			PreparedStatement ps = con.prepareStatement(sql);
			int produktNr = getProduktNR();
			int count = 0;
			int maxKaufNr = getLastKaufNr();
			for(int i = 0; i < 2000; i++) {
				ps.setInt(1, ++produktNr);
				String bezeichnung = generator.getRandomProduct();
				ps.setString(2, bezeichnung);
				ps.setInt(3, generator.getPrice(bezeichnung));
				ps.setInt(4, rand.nextInt(maxKaufNr) + 1); //random.nextInt(max - min + 1) + min
				ps.addBatch();
				prNRtoBez.put(produktNr, bezeichnung);
				
				count++;
				if(count % 2000 == 0 || i == 1999) {
					ps.executeBatch();
					count = 0;
				}
			}
		} catch (SQLException e) {
			System.err.println("Error at: insertIntoProdukt\nmessage: " + e.getMessage());
		}
    }
    
    //TICKETS INSERT
    void insertIntoTickets() {
    	try {
    		String sql = "INSERT INTO Tickets (ProduktNr,Sitzplatz,Filmname) VALUES (?,?,?)";
			PreparedStatement ps = con.prepareStatement(sql);
			
			int count = 0;
			List<Integer> prNr = ticketsPRNR();
			for(Integer prNR: prNr) {
				ps.setInt(1, prNR);
				ps.setInt(2, rand.nextInt(100)+1);
				ps.setString(3, DataGenerator.movies[rand.nextInt(6)]);
				ps.addBatch();
				count++;
				if(count == prNr.size()) {
					count = 0;
					ps.executeBatch();}
			}
		} catch (SQLException e) {
			System.err.println("Error at: insertIntoTickets\nmessage: " + e.getMessage());
		}
    }
    
    //SNACKS INSERT
    void insertIntoSnacks() {
    	try {
    		String sql = "INSERT INTO Snacks (ProduktNr, Marke, Groesse) VALUES (?,?,?)";
			PreparedStatement ps = con.prepareStatement(sql);
			
			int count = 0;
			List<Integer> prNr = snacksPRNR();
			for(Integer prNR: prNr) {
				ps.setInt(1, prNR);
				String bezeichnung = prNRtoBez.get(prNR);
				ps.setString(2, generator.getBrand(bezeichnung));
				ps.setString(3, DataGenerator.sizes[rand.nextInt(2)]);
				ps.addBatch();
				count++;
				if(count == prNr.size()) { 
					ps.executeBatch();
					count = 0;
				}
			}
		} catch (SQLException e) {
			System.err.println("Error at: insertIntoTickets\nmessage: " + e.getMessage());
		}
    }
    
    //VERKAUFT INSERT
    void insertIntoVerkauft() {
    	
    	try {
    		String sql = "INSERT INTO verkauft (KundenNr, ProduktNr, SV_Nummer) VALUES (?, ?, ?)";
			PreparedStatement ps = con.prepareStatement(sql);
			int count = 0;
			int clients = getClientNR();
			int products = getProduktNR();
			List<Integer> svns = selectSVNRFromMitarbeiter();
			
			Set<Integer> clientNrs = new HashSet<>();
			Set<Integer> productNrs = new HashSet<>();
			for(int i = 0; i < 1200; i++) {
				int clientNr = rand.nextInt(clients-1)+1;
				while(clientNrs.contains(clientNr)) {clientNr = rand.nextInt(clients-1)+1;}
				ps.setInt(1, clientNr);
				clientNrs.add(clientNr);
				int productNr = rand.nextInt(products-1)+1;
				while(productNrs.contains(productNr)) {productNr = rand.nextInt(products-1)+1;}
				ps.setInt(2, productNr);
				productNrs.add(productNr);
				int worker = svns.get(rand.nextInt(svns.size()-1-1) +1);
				ps.setInt(3, worker);
				ps.addBatch();
				count++;
				if(count % 1200 == 0 || i == 1199) {
					ps.executeBatch();
					count = 0;
				}
			}
		} catch (SQLException e) {
			System.err.println("Error at: insertIntoVerkauft\nmessage: " + e.getMessage());
		}
    }
    
    //BEZAHLUNG INSERT
    void insertIntoBezahlung() { 
    	try {
    		String sql = "INSERT INTO Bezahlung (RechnungsNr, KaufNr, Zahlungsart, Summe) VALUES (?,?,?,?)";
			PreparedStatement ps = con.prepareStatement(sql);
			int rechnungsNr = 0;
			int kaufNr = 0;
			int count = 0;
			int purchases = getLastKaufNr();
			for(int i=0; i < purchases; ++i) {
				ps.setInt(1, ++rechnungsNr);
				ps.setInt(2, ++kaufNr);
				ps.setString(3, DataGenerator.payment[rand.nextInt(2)]);
				ps.setInt(4, rand.nextInt(40-11)+1); // could be fixed
				//erfolgt.put(rechnungsNr, kaufNr); //??
				ps.addBatch();
				count++;
				if(count % purchases == 0 || i == purchases -1) {
					ps.executeBatch();
					count = 0;
				}
			}
		} catch (SQLException e) {
			System.err.println("Error at: insertIntoErmaessigung\nmessage: " + e.getMessage());
		}
    }
    
    //INSERT ERMAESSIGUNG
	void insertIntoErmaessigung() { 
    	try {
    		String sql = "INSERT INTO Ermaessigung (KaufNr, EID, Prozent, Bezeichnung) VALUES (?,?,?,?)";
			PreparedStatement ps = con.prepareStatement(sql);
			int maxEID = getMaxEID();
			int count = 0;
			int purchases = getLastKaufNr();
			for(int i=0; i < 100; ++i) {
				int knr = rand.nextInt(purchases -1) +1;
				ps.setInt(1, knr);
				ps.setInt(2, ++maxEID);
				String discount =  DataGenerator.discounts[rand.nextInt(3)];
				//kaufNRdiscount.put(knr, discount); //??
				ps.setString(4, discount);
				ps.setString(3, generator.getDicount(discount));
				ps.addBatch();
				count++;
				if(count % 100 == 0 || i == 99) {
					ps.executeBatch();
					count = 0;
				}
			}
		} catch (SQLException e) {
			System.err.println("Error at: insertIntoErmaessigung\nmessage: " + e.getMessage());
		}
    }


	//SELECTS
    
    ArrayList<Integer> selectKinoIDsFromKino() {
        ArrayList<Integer> IDs = new ArrayList<>();

        try {
            ResultSet rs = stmt.executeQuery("SELECT KinoID FROM Kino");
            while (rs.next()) {
                IDs.add(rs.getInt("KinoID"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectPersonIsFromPerson\n message: " + e.getMessage()).trim());
        }
        return IDs;
    }
    
    public Integer getClientNR() {
		try {
			ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Kunde");
			if(rs.next()) {
				int count = rs.getInt(1);
				return count;
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}
	return 0;
}
    
    private int getLastKaufNr() {
    	try {
			ResultSet rs = stmt.executeQuery("SELECT MAX(KaufNr) as lastKaufNr FROM Kauf");
			if(rs.next()) {
				int count = rs.getInt("lastKaufNr");
				return count;
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return 0;
	}
    
    public Integer getProduktNR() {
		try {
			ResultSet rs = stmt.executeQuery("SELECT MAX(ProduktNr) as lastNR FROM Produkt");
			if(rs.next()) {
				int count = rs.getInt("lastNR");
				return count;
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}
	return 0;
}
    
    public List<Integer> ticketsPRNR() {
    	List<Integer> ticketsPRNR = new ArrayList<>();
    	
    	ResultSet rs;
		try {
			rs = stmt.executeQuery("SELECT ProduktNr FROM Produkt WHERE Bezeichnung = 'Movie Ticket'");
			while(rs.next()) {
				int prNR = rs.getInt("ProduktNr");
				ticketsPRNR.add(prNR);
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}
    		return ticketsPRNR;
    	}
    
    public List<Integer> snacksPRNR() {
    	List<Integer> snacksPRNR = new ArrayList<>();
    	
    	ResultSet rs;
		try {
			rs = stmt.executeQuery("SELECT ProduktNr FROM Produkt WHERE Bezeichnung <> 'Movie Ticket'");
			while(rs.next()) {
				int prNR = rs.getInt("ProduktNr");
				snacksPRNR.add(prNR);
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}
    		return snacksPRNR;
    	}
    
    ArrayList<Integer> selectSVNRFromMitarbeiter() {
        ArrayList<Integer> SVNs = new ArrayList<>();

        try {
            ResultSet rs = stmt.executeQuery("SELECT SV_Nummer FROM Mitarbeiter");
            while (rs.next()) {
                SVNs.add(rs.getInt("SV_Nummer"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectPersonIsFromPerson\n message: " + e.getMessage()).trim());
        }
        return SVNs;
    }
    
    public Integer getMaxEID() {
    	int maxEID = 0;
    	
    	try {
			ResultSet rs = stmt.executeQuery("SELECT MAX(EID) as MaxEID FROM Ermaessigung");
			if(rs.next()) maxEID = rs.getInt("MaxEID");
		} catch (Exception e) {
			System.err.println(("Error at:getMaxEID\n message: " + e.getMessage()).trim());
		}
    	
    	return maxEID;
    }

}
