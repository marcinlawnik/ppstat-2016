#ppstat-2016
#####Analiza przyjętych na Politechnikę Poznańską na studia I stopnia w roku akademickim 2016/2017
##### Marcin Ławniczak i Marcin Służałek

Streszczenie
---
To repozytorium zawiera listę osób przyjętych na Politechnikę Poznańską w I
turze rekrutacji na studia I stopnia w roku akademickim 2016/2017. Dane zostały
pobrane ze strony Politechniki, gdzie są publicznie dostępne, przekonwertowane
z formatu PDF do CSV, a następnie zaimportowane do bazy danych MySQL. Byłem 
ciekawy, jakie były progi punktowe, ale także jakie imiona występują 
najczęściej w populacji studenckiej. To repozytorium odpowiada na te i inne
pytania.

Summary
---
This repository contains a list of people accepted into Poznań University of
Technology during the first round of recruitment for undergraduate studies in
the academic year 2016/2017.  The records were downloaded from University's
website, where they are publicly available, converted from PDF to CSV and then
imported into MySQL database. I was curious what the point thresholds were, but
also what names are the most popular among students. This repository answers
those and other questions.

---
###Wprowadzenie

---
Wakacje. Okres wypraw, spotkań ze znajomymi i pomysłów. Ten ma na celu tylko
zaspokojenie mojej ciekawości, ale może ktoś inny z niego skorzysta. Przydatny
na pewno będzie sposób konwersji i obróbki danych z formatu PDF, którego bez
specjalistycznych narzędzi nie można edytować do formatu DOC. Dalej konwesja do
formatu CSV obsługiwanego przez Excela i łatwego do importu do bazy danych.
No, to do roboty.

Jeżeli nie interesują Cię techniczne szczegóły, możesz od razu przejść do
sekcji `Analiza`

###Pobranie PDF

---
Wszystkie PDF znajdują się na stronie Politechniki pod tym adresem:

[TU](http://www.put.poznan.pl/pl/studia-i-i-ii-stopnia/listy-przyjetych)

Jestem człowiekiem wygodnym i po prostu klikałem prawym przyciskiem
"Zapisz link jako...". Powtórzenie tego wyczynu 33 razy nie sprawiło mi
większego problemu. Zwłaszcza że pliki są wylistowane na dole strony.
Znajdują się one w katalogu `raw/pdf`.

###Konwersja do DOC

---
Pliki skonwertowałem przy użyciu [Convertio](https://convertio.co/pl/).
Konwerter zachowuje strukturę tabeli i wszystkie dane. Założyłem dwa konta,
ponieważ dla bezpłatnych kont obowiązuje limit "minut konwersji". Nawet jeżeli
plik konwertuje się poniżej minuty (jak te listy przyjętych), to i tak pobiera
całą minutę z konta (efektywnie tworząc limit 25 plików dziennie). 
Skonwertowane pliki znajdują się w katalogu `converted/doc`.

###Kopiowanie danych

---
Aby ułatwić sobie pracę, zaimportowałem wszystkie pliki doc do formatu
obsługiwanego przez [Google Docs](https://docs.google.com). To pozwoliło mi na
proste użycie `Ctrl+C` i `Ctrl+V` do skopiowania danych do arkusza Google.


###Konwersja do csv

---
Plik `xlsx` wyeksportowany z Google Docs przy użyciu narzędzia
[xlsx2csv](https://github.com/dilshod/xlsx2csv) przekonwertowałem do plików
`csv` zawierających dane poszczególnych kierunków.

###Załadowanie do bazy danych

---
Poszczególne pliki załadowałem do bazy danych przy użyciu skryptu php, dostępnego
w katalogu `convert/`. Pliki muszą być w folderze `storage/app/`, a potem należy
uruchomić komendy `php artisan migrate` i `php artisan import:students`.


##Analiza

---
#####Jakie są najpopularniejsze imiona wśród studentów pierwszego roku PP?

Zapytanie: `SELECT imie, COUNT(imie) FROM students
            GROUP BY imie
            ORDER BY COUNT(imie) DESC;`

Wykres pierwszych dziesięciu odpowiedzi:

![Wykres1](https://github.com/marcinlawnik/ppstat-2016/blob/master/images/najpopularniejsze_imiona.png)

---
#####Na jakich kierunkach była najwyższa średnia punktów podczas rekrutacji?

Zapytanie: `SELECT kierunek_id, AVG(liczba_punktow)
            FROM students WHERE jedna_gwiazdka=0 
            AND dwie_gwiazdki=0 GROUP BY kierunek_id`

Wykres pierwszych dziesięciu odpowiedzi:

![Wykres1](https://github.com/marcinlawnik/ppstat-2016/blob/master/images/srednia_vs_kierunek.png)
