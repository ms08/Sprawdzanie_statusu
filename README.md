# Sprawdzanie statusu samochodu
1. Cele biznesowe

Celem aplikacji jest zautomtyzowanie sprawdzania produkcji obecnego statusu samochodu 
bez konieczności kontaktu z salonem samochoowym. 
Dzięki temu Klienci będą mogli sami sprawdzić status zamówionego pojazdu w dowolnej chwili. 


Głowne 2 zadania:
- odciążenie handlowców z konieczności "pamiętania" o Klientach :)
- danie użytkownikom bieżącego monitorowania samochodu w fabryce 


2. Model danych


3.Widoki 

Aplikaja posiada 2 widoki

Admin:
- uzupełnia bazę danych - umieszczając ja w mySQL 

Klient: 
- po zalogowaniu możliwość podglądu statusu produkcji swojego samochodu/ów 


4. Procesy 

Po zamówieniu samochodu klient otrzymje zamówienie. Na podstawie danych dostępnych w zamowieniu, loguje się do aplikacji. Po pierwszym logowaniu nie wyświetlają się żadne dane o statusie produkcji, użytkownik jest zmuszony na wybór nowego hasła. Po logowaniu z użyciem wybranego hasła umożliwia podgląd produkcji -> oczywiście przetłumaczony na język zrozumiały dla użytkownika. 



W aplikacje zostały użytę następujące .......
-Symfony 2.8 
*FOS
*CRUD
*....
-JavaScript
-