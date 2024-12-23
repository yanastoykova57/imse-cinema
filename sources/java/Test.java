package execution;

import java.sql.ResultSet;
import java.sql.SQLException;

public class Test {

	public static void main(String[] args) {
		DatabaseCommands command = new DatabaseCommands();
		
		//INSERTS
		/*command.insertIntoKino();
		command.insertIntoMitarbeiter();
		command.insertIntoKunde();
		command.insertIntoKauf();
		command.insertIntoProdukt();
		command.insertIntoTickets();
		command.insertIntoSnacks();
		command.insertIntoVerkauft();
		command.insertIntoBezahlung();
		command.insertIntoErmaessigung();*/
		command.deleteEntries();
		
		String[] tables = {
				"Kino", "Mitarbeiter", "Kunde", "Kauf", "Produkt", "Tickets",
				"Snacks", "verkauft", "Bezahlung", "Ermaessigung"
		};
		
		for (String elem : tables) {
			try {
				ResultSet rs = command.getStmt().executeQuery("SELECT COUNT(*) FROM " + elem);
				if(rs.next()) {
					int count = rs.getInt(1);
					System.out.println("Number " + elem + ": "+count );
				}
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}

	}

}
