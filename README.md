# Zadanie

Proszę napisać aplikację konsolową w  frameworku  Symfony 
która będzie pobierać dane o bohaterach
z api https://swapi.dev/api/people/:id
aplikacja powinna pobrać dane wszysktich użytkwoników 1-83
pobrane dane proszę zapisać w bazie danych tak, by dało się je później wykorzystać
do budowy api (jego budowa nie jest celem tego zadania).
Proszę je zapisać w taki sposób by optymalnie wykorzystać możliwości 
jakie daje relacyjna baza danych (MySQL) i tak by dało się je wykorzystać później do budowy api 
**(co nie jest celem zadania)**
Proszę również pobrać i zapisać dane powiązane np:
```json
{
  "films": [
  "https://swapi.dev/api/films/1/",
  "https://swapi.dev/api/films/2/",
  "https://swapi.dev/api/films/3/",
  "https://swapi.dev/api/films/6/"
], 
}
```
ale już w danych dodatkowych proszę pominąć relacje

### Wymagania:
Dane prosze pobrać przy pomocy biblioteki Guzzle - https://github.com/guzzle/guzzle  
