```
Zadanie polega na stworzeniu mechanizmu logowania użytkowników

1. Do realizacji zadania wykorzystaj jeden z framework PHP i Doctrine jako orm do bazy danych MySQL
2. Wymagania funkcjonalne:
    a) umożliwić użytkownikowi zalogowanie/wylogowanie się
        - unikatowy login użytkownika to jego email
        - hasło powinno składać się z minimum 8 znaków przy założeniu, że zawiera minimum 2 małe litery, 2 duże litery, 2 cyfry, 2 znaki specjalne,
    b) wymusić na użytkowniku zmianę hasła:
        - w przypadku pierwszego logowania,
        - po upływie N dni,
    c) użytkownik zmienia hasło z wytycznymi:
       - nowe hasło nie może być identyczne z poprzednimi użytymi przez użytkownika,
       - po udanej zmianie hasła wysyłany jest do użytkownika mail potwierdzający,
    d) umożliwić zalogowanemu użytkownikowi dodanie nowych użytkowników poprzez zaimportowanie ich listy z pliku csv
3. Baza danych powinna być zasilona za pomocą funkcji migracyjnej
Byłoby super gdybyś:
- napisał testy jednostkowe do wykonanego zadania

Pamiętaj:
1. Przygotuj tablice bazy danych za pomocą migracji.
2. Przygotuj dane wsadowe do tablic.
3. Przygotuj przykładowy plik csv z dwoma nowymi użytkownikami.
4. Maile nie muszą wychodzić fizycznie przez konkretny serwer pocztowy, możesz wykorzystać ustawienia dla środowiska dev lub zaproponować jakiś inny znany sobie "trap".
5. Pilnuj formatowania zgodnego z PSR-1, PSR-4 i PSR-12.
6. Użyj composera ze skryptem do uruchomienia migracji
7. Zadanie należy dostarczyć w formie linki do repozytorium.
```