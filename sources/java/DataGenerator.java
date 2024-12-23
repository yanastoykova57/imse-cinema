package execution;

import java.io.BufferedReader;
import java.io.FileReader;
import java.time.LocalDate;
import java.util.ArrayList;
import java.util.HashSet;
import java.util.Random;
import java.util.Set;

public class DataGenerator {
	
	private ArrayList<String> firstNames;
    private ArrayList<String> lastNames;
    private Set<Integer> phoneNumbers = new HashSet<>();
    
    Random rand = new Random();
	
	DataGenerator() {
		this.firstNames = readClientNames("/Users/yanastoykova/Desktop/UNI/DBS/firstnames.csv");
    	this.lastNames = readClientNames("/Users/yanastoykova/Desktop/UNI/DBS/lastnames.csv");
	}
	
	private ArrayList<String> readClientNames(String filename) { 
		  String line;
	        ArrayList<String> set = new ArrayList<>();
	        try (BufferedReader br = new BufferedReader(new FileReader(filename))) {
	            while ((line = br.readLine()) != null) {
	                try {
	                    set.add(line);
	                } catch (Exception ignored) {
	                }
	            }

	        } catch (Exception e) {
	            e.printStackTrace();
	        }
	        return set;
  }
	
	public static String[] cinemaNames = {
			"English Cinema Haydn", "Burg Kino", "Votiv Kino",
			"APOLLO", "ARTIS INTERNATIONAL", "URANIA KINO",
			"CINEPLEXX MILENNIUM CITY"
		};
	
	public static String[] products = {
			"Movie Ticket", "Salty Popcorn", "Sweet Popcorn", "Water", 
			"Soda", "Chocolate", "Chips", "Candy"
	};
	
	public static String[] movies = {
			"AQUAMAN: LOST KINGDOM", "BABY TO GO", "NAPOLEON",
			"NEXT GOAL WINS", "PRISCILLA", "THE BEEKEEPER",
			"WONKA"
	};
	
	public static String[] sizes = {
			"S", "M", "L"
	};
	
	public static String[] payment = {
			"Cash", "Debit card"
	};
	
	public static String[] brands = {
			"Coca-Cola", "Sprite", "Voeslauer", "Herschey's",
			"Wether's Originals", "-", "M&M", "Lays"
	};
	
	public static String[] discounts = {
			"Christmas", "Children", "Students", "Elders"
	};
	
	public String getDicount(String dname) {
		if(dname == discounts[0] || dname == discounts[2]) return "10%";
		return "20%";
	};
	
	public String getCinemaAddress(String cinemaName) {
		if (cinemaName == cinemaNames[0]) return "Mariahilfer Str. 57";
		else if (cinemaName == cinemaNames[1]) return "Opernring 19";
		else if (cinemaName == cinemaNames[2]) return "Währinger Str. 12";
		else if (cinemaName == cinemaNames[3]) return "Gumpendorfer Str. 63";
		else if (cinemaName == cinemaNames[4]) return "Schultergasse 5";
		else if (cinemaName == cinemaNames[5]) return "Uraniastraße 1";
		else if (cinemaName == cinemaNames[6]) return "Wehlistraße 66";
		return "adress not matched";
	}
	
	public int getCinemaPhoneNr(String cinemaName) {
		if (cinemaName.equals(cinemaNames[0])) return  15872262;
		else if (cinemaName.equals(cinemaNames[1])) return 15878406;
		else if (cinemaName.equals(cinemaNames[2])) return 13173571;
		else if (cinemaName.equals(cinemaNames[3])) return 15879651;
		else if (cinemaName.equals(cinemaNames[4])) return 15356570;
		else if (cinemaName.equals(cinemaNames[5])) return 17158206;
		else if (cinemaName.equals(cinemaNames[6])) return 133760;
		return 000000;
	}
		
	public int randomSVNrGenerator() {
		int counter = 10;
		int svNR = 56700000;
		while(counter > 0) {
			svNR += rand.nextInt(10000000);
			counter--;
		}
		return svNR;
	}
	
	public String employeeNameGenerator() {
		String letters = "ABCDEFGHIGKLMNOPQRSTUVWXYZ";
		String employeeName = "" + letters.charAt(rand.nextInt(letters.length())) + "." + 
				letters.charAt(rand.nextInt(letters.length())) + ".";
		
		return employeeName;
	}
	
	public String employeeEmail(String name) {
		String[] parsedName = name.toLowerCase().split("\\.");
		return parsedName[0] + parsedName[1] + "@gmail.com";
	}
	
	public int randomSalary() {
		return 1000 + rand.nextInt(1000);
	}
	
	
	public ArrayList<String> fullNameGenerator() {
		ArrayList<String> fullNames = new ArrayList<>();
		int counter = 3000;
		for(int i= 0; i<counter; ++i) {
			String fullName = getRandomFirstName() + " " + getRandomLastName();
			fullNames.add(fullName);
			//counter++;
		}
		return fullNames;
	}
	
	//returns random element from list
    public String getRandomFirstName() {
        return firstNames.get(getRandomInteger(0, firstNames.size() - 1));
    }

    //returns random element from list
    public String getRandomLastName() {
        return lastNames.get(getRandomInteger(0, lastNames.size() - 1));
    }
    
    public Integer getRandomInteger(int min, int max) {
        return rand.nextInt((max - min) + 1) + min;
    }
    
    public int randomClientPhoneNr() {
		int nr;
		
		do {
		 nr = 677641000 + rand.nextInt(10000000);
		} while(phoneNumbers.contains(nr));
		
		phoneNumbers.add(nr);
		
		return nr;
	}
    
    public LocalDate generateDate() {
		
		LocalDate startDate = LocalDate.of(2021, 1, 1);
		LocalDate endDate = LocalDate.now();
		
		long startEpochDay = startDate.toEpochDay();
		long endEpochDay = endDate.toEpochDay();
		
		long randomEpochDay = startEpochDay + rand.nextInt((int) (endEpochDay-startEpochDay+1));
		return LocalDate.ofEpochDay(randomEpochDay);
	}
    
    public String getRandomProduct() {
		return products[rand.nextInt(7)];
	}
    
    public int getPrice(String bezeichnung) {
		if(bezeichnung == products[1]) return 7;
		if(bezeichnung == products[2]) return 6;
		if(bezeichnung == products[3]) return 2;
		if(bezeichnung == products[4] || bezeichnung == products[5] || 
				bezeichnung == products[6] || bezeichnung == products[7] ) return 3;
		else return 12;
	}
    
    
    public String getBrand(String bezeichnung) {
		if(bezeichnung == products[1]) return brands[5];
		if(bezeichnung == products[2]) return brands[4];
		if(bezeichnung == products[3]) return brands[2];
		if(bezeichnung == products[4]) return brands[rand.nextInt(1)];
		if(bezeichnung == products[5]) return brands[3];
		if(bezeichnung == products[6]) return brands[7];
		if(bezeichnung == products[7]) return brands[6];
		else return brands[5];
	}

}
