# laravel-start-project

Hieronder een stappenplan voor het opzetten van een [laravel](https://laravel.com/docs/5.5) project.
Voor dit stappenplan wordt er vanuit gegaan dat er gebruik wordt gemaakt van 
**Vagrant / Homestead**. Voor de installatie van Vagrant en Homestead zie de website van Laravel 
onder het kopje met [First Steps](https://laravel.com/docs/5.5/homestead#first-steps).

# Inhoud
  * [Stap 1 - Git Repo](#chapter-1)
  * [Stap 2 - configureer Homestead.yaml](#chapter-2)
  * [Stap 3 - ssh Homestead](#chapter-3)
  * [Stap 4 - new laravel project](#chapter-4)
  * [Stap 5 - generate application key](#chapter-5)
  * [Stap 6 - aanpassen hosts file](#chapter-6)
  * [Stap 7 - environment file aanpassen](#chapter-7)
  * [Stap 8 - koppel DB aan PhpStorm](#chapter-8)
  * [Stap 9 - Voeg project toe aan GIT](#chapter-9)
  * [Tips](#chapter-10)

<a id="chapter-1"></a>
## Stap 1 - Git Repo 
Maak een repository aan op GitHub.com
en clone deze naar een lokale folder. 

`GIT CLONE https://github.com/link/to/[reponame].git`

<a id="chapter-2"></a>
## Stap 2 - configureer Homestead.yaml

Bewerk de Homestead.yaml file in de hidden folder .homestead of in de Homestead directory.

#### folders
Onder het keyword **folders** leg je de verwijzing tussen een lokale map en de folder 
van het project op de virtual machine (VM). De code uit deze mappen wordt automatisch gesynchroniseerd.

#### sites
Wanneer je van meerdere sites / projecten gebruik wilt maken dan kun je dit aangeven onder het 
keyword **sites**. 
* **map:** noteer hier het domein dat je intipt in je browser om de site te bezoeken
* **to:** noteer het pad naar de public folder van het laravel project op Homestead

#### databases
Noteer hier de namen van de databases die aangemaakt moeten worden.
 
```

---
ip: "192.168.10.10"
memory: 2048
cpus: 1
provider: virtualbox

authorize: ~/.ssh/id_rsa.pub

keys:
    - ~/.ssh/id_rsa

folders:
    - map: ~/Sites
      to: /home/vagrant/Code

sites:
    - map: laravel.test.app
      to: /home/vagrant/Code/laraveltest/public
    - map: laravel.start.app
      to: /home/vagrant/Code/laravel-start-project/public

databases:
    - laraveltest
    - laravelstartproject

# blackfire:
#     - id: foo
#       token: bar
#       client-id: foo
#       client-token: bar

# ports:
#     - send: 50000
#       to: 5000
#     - send: 7777
#       to: 777
#       protocol: udp
```

Om de verandering van kracht te laten worden moet vagrant herstart worden. Tik het volgende commando in de terminal van de Homestead folder:

`vagrant up --provision` 

Om de VM normaal te starten volstaat:

`vagrant up`

<a id="chapter-3"></a>
## Stap 3 - ssh Homestead

Je kunt via ssh toegang krijgen tot de VM. Navigeer naar je Homestead folder in de terminal en voer het volgende commando uit:

`vagrant ssh`

Als dit niet lukt kun je ook het volgende proberen: 

`ssh vagrant@192.168.10.10` (wachtwoord: _vagrant_)

Je staat nu in de root folder van de VM. Met het commando `ls` kun je de inhoud bekijken. Met `ls -al` kan je ook hidden folders zien. 
Je ziet nu een folder met de naam **Code**. Hierin staan de laravel-projecten. 

Met het commando `cd Code` kom je in de Code directory. Wanneer je nu weer `ls` uitvoert zul je de directories met de projecten zien. 

<a id="chapter-4"></a>
## Stap 4 - new laravel project

Als je via ssh toegang hebt tot de VM
navigeer dan naar de folder waar de laravel intallatie gedaan moet worden. In mijn geval: 

`cd laravel-start-project`

Om een nieuw project aan te maken gebruik je het commando: 

`larvel new`

<a id="chapter-5"></a>
## Stap 5 - generate application key

Via de terminal voer je in de root van het project het volgende commando uit: 

`php artisan key:generate`

<a id="chapter-6"></a>
## Stap 6 - aanpassen hosts file

Het domein waarop de site geserveerd moet worden, moet worden toegevoegd aan je hosts file. 

Mac (in terminal)
`sudo nano /etc/hosts`

Windows: hosts file is in `C:\Windows\System32\drivers\etc\hosts`

Voeg het gewenste domein toe. Dit is een vrije keuze: 

`192.168.10.10  laravel.start.app`

Mac: `CTRL + x` om uit nano te komen. `Y` voor opslaan, `enter` voor overschrijven.

Als je meerder projecten hebt, voeg je meerdere domeinen toe die allemaal naar 192.168.10.10 verwijzen.

De site zou nu via de browser toegankelijk moeten zijn. 

<a id="chapter-7"></a>
## Stap 7 - environment file aanpassen

Ga naar PhpStorm en open de root van de lokale laravel folder. In de project root vind je een `.env` bestand.
Verander de naam van de database naar de naam die je opgegeven hebt in het Homestead.yaml bestand van stap 2.

<a id="chapter-8"></a>
## Stap 8 - koppel DB aan PhpStorm

* Ga in PhpStorm naar: **View > Tool Windows > Database** of klik helemaal rechts in beeld op de database tab.
* Klik linksboven op de **(+) > Data source > MySql**
* Vul bij host in : _192.168.10.10_
* naam van de database (zoals in Homestead.yaml)
* username: _homestead_
* password: _secret_
* _Test connection_

Je hebt nu vanuit PhpStorm direct toegang tot de database. Je kunt zo makkelijk data invoeren, de inhoud van tabellen zien (dubbelklik op tabel) en Sql Queries uitvoeren. 

<a id="chapter-9"></a>
## Stap 9 - Voeg project toe aan GIT

* Ga in PhpStorm naar: **View > Tool Windows > Version control** of klik helemaal linksonder in beeld op de version control tab.
* rechtermuisklik op Unversioned Files > Add To VCS
* Met CMD + K kan je een commit uitvoeren of het tweede icoontje met het groene bolletje

<a id="chapter-10"></a>
## Tips
* Voor beter autocompletion maak gebruik van de [IDE helper van BarryvdH](https://github.com/barryvdh/laravel-ide-helper#phpstorm-meta-for-container-instances)
* Voor hulp bij het werken met formulieren met [LaravelCollective](https://laravelcollective.com/docs/5.4/html)

