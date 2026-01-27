# Programiranje za internet

Repozitorij materijala s vježbi kolegija "Programiranje za internet" FPMOZ

## Upute za izradu laravel aplikacije (lokalno)

#### 1. Pokrenuti laragon
#### 2. Kreirati laravel aplikaciju
Desnim klikom na laragon sučelje odabrati kreiranje nove Laravel aplikacije

ili 

Koristeći composer putem terminala  
`composer create-project --prefer-dist laravel/laravel pzi_projekt`

#### 3. Kreirati bazu podataka
Koristeći laragon heidi alat, kreirati novu bazu podataka.  
Ukoliko ste projekt izradili preko laragon sučelja, baza se automatski kreira.

#### 4. Postaviti okruženje (.env)
Unutar .env datoteke postaviti okruženje i podatke za pristup bazi podataka

DB_DATABASE=pzi_projekt // Ime vase baze  
DB_USERNAME=root  
DB_PASSWORD=

#### NPM
npm install  
npm run dev // Dev za debug nacin rada  
ili  
npm run watch // automatski osvjezava promjene css/js

*Aplikacija je lokalno dostupna na pzi_projekt.test**

#### Kreiranje baze podataka
    php artisan migrate

DROP cijele baze i ponovno pokretanje migracija! Oprez!

    php artisan migrate:fresh

#### Kreiranje modela
    php artisan make:model Car -mcr --api

#### Uređivanje migracije
File database/migrations/timestamp_create_model_table.php

Ponovno pokrenuti migraciju kako bi se odrazile promjene
    php artisan migrate

#### Dodavanje polja u bazi u fillable
Kako bi se polja mogla upisivati kroz Eloquent ORM metode, potrebno je omoguciti da polja u bazi budu tzv. mass assignable.

To postižemo override-om $fillable svojstva unutar našeg modela npr.

app/models/Car.php

        protected $fillable = ['manufacturer', 'year', 'model_name', 'color'];



#### PHP Laravel tinker
Ulaskom u tinker otvara se php shell sa laravel okruzenjem.
Služi za testiranje pojedinih naredbenih linija koda.

    php artisan tinker

#### CRUD modela u tinker-u

CREATE

     Car::create(['manufacturer'=>'Audi', 'model_name'=>'A6', 'year'=>2020])

READ

Svi modeli (array)

    Car::all()

Jedan model po ID (objekt)

    Car::find(1)

UPDATE

    $car = Car::find(1);
    $car->model_name = 'A4';
    $car->save();

DELETE

    $car = Car::find(1);
    $car->delete();
    
## Upute za postavljanje frontenda projekta na studentski server


#### 1. Prijava na studentski poslužitelj

    Host: studenti.sum.ba

    Korisničko ime: pziXXYYYY

    Lozinka: csdigitalYYYY

**XX** broj grupe (01, 02, 03...)

**YYYY** akademska godina

<br>

#### 2. Unutar Vašeg foldera klonirati repozitorij s githuba
    git clone https://github.com/RobertRozic/PZI.git
<br>

#### 3. Napraviti simbolički link sa root/public/dist foldera projekta public folder na posluzitelju
     ln -s /home/pziXXYYYY/ime-projekta/frontend/dist /home/pziXXYYYY/public

* Ukoliko naredba javi da file vec postoji, odradite:
`rm -rf ~/public`
  
Napomena: Folder koji linkate je folder u kojem se nalazi vaš index.html/index.php

##### Čisti PHP
Najčešće index.php stavljate u sami root (početni direktorij projekta)
Moguće je napraviti poseban direktorij npr. public u kojem se nalazi ono što će biti javno dostupno.


##### Vue.js i Angular
Ukoliko frontend radite u nekom od javascript frameworka poput Vue.js ili Angular.js potrebno je
buildati aplikaciju određenom naredbom (npm run build ili ng build).

Nakon izvršene naredbe, u direktoriju vašeg projekta će se pojaviti **dist** folder.
On se inače ne postavlja na github, nego se dobije buildanjem projekta direktno na serveru. 
Zbog jednostavnosti ćemo ovaj direktorij postaviti na github i na njega postaviti simbolički link s public foldera na studentskom poslužitelju.
Po početnim postavkama vue.js i angular.js taj direktorij postavljaju u .gitignore file.
Sve što se nalazi zapisano u .gitignore file-u, git ignorira i ne postavlja na github repozitorij.
Kako bi ipak postavili dist na github, potreno je izbrisati red u kojima je zapisan dist direktorij.


### Aplikacija je dostupna na linku
    http://pziXXYYY.studenti.sum.ba/

### Baza podataka
Na studentskom poslužitelju svaka grupa ima MySql bazu.

Pristupni podaci su (.env laravel konfiguracija):  
DB_HOST=localhost (localhost na samom poslužitelju)  
DB_DATABASE=pziXXYYYY    
DB_USERNAME=pziXXYYYY  
DB_PASSWORD=csdigitalYYYY

Bazi podataka možete pristupiti putem phpmyadmin-a instaliranog na poslužitelju.  
Putem PhpMyAdmina možete raditi import podataka koje imate na lokalnoj bazi.

[PHPMyAdmin](https://studenti.sum.ba/phpmyadmin)

### Ažuriranje projekta
Nakon pristupa folderu u kojem se nalazi vaš projekt, koristite naredbu
####
    git pull
Ova naredba povlači sve promjene koje ste postavili na javni github repozitorij


Ukoliko imate problema s postavljanjem, javite se na email `hrvoje.ljubic@fpmoz.sum.ba`


## Postavljanje laravel/backend aplikacije na studentski poslužitelj
Prilikom postavljanja laravel aplikacije na studentski poslužitelj potrebno je:

#### 1. Spojiti se na studentski poslužitelj (upute iznad)

#### 2. Klonirati git repozitorij u svoj radni prostor
    git clone https://github.com/RobertRozic/PZI.git

#### 3. Napraviti simbolički link sa **public** direktorij-a u laravel projektu na **backend** folder na posluzitelj

    ln -s /home/pziXXYYYY/ime-projekta/backend/public/ /home/pziXXYYYY/backend

#### 4. Pozicionirati se u folder backend projekta
    cd ~/ime-projekta/backend

#### 5. Instalirati composer dependency-je
    composer install

#### 6. Podesiti .env na poslužitelju
Primjer kopiramo u .env file

    cp .env.example .env

Podesimo bazu

    DB_DATABASE=pziXXYYYY
    DB_USERNAME=pziXXYYYY
    DB_PASSWORD=csdigitalYYYY

Generiramo key aplikacije

    php artisan key:generate

#### 7. Podesiti permisije
    chgrp -R www-data storage bootstrap/cache
    chmod -R ug+rwx storage bootstrap/cache

### Backend aplikacije je dostupan na linku
    http://pziXXYYY.studenti.sum.ba/backend


## Osnovne naredbe u linuxu
* **pwd** - Ispis putanje trenutnog foldera u kojemu se nalazimo (**p**rint **w**ork **d**irectory)

`pwd`  
`/home/pzi002024`

* **cd** - Promjena direktorija (**c**hange **d**irectory)

`cd public`

Vraćanje u prethodni direktorij

`cd ..`

* **mkdir** - Kreiranje direktorija (**m**ake **d**irectory)

`mkdir test`

* **touch** - Kreiranje datoteke

`touch test.txt`

* **nano** - Ugrađeni tekstualni editor

`nano test.txt`

Za izlazak iz editora koristi se CTRL+X, zatim editor pita za spremanje datoteke.

Pritisnite y (za da) ili n (za ne).

* **ln -s** - Kreiranje simboličkog linka

`ln -s izvor odrediste`

Brisanje datoteke/direktorija

`rm -rf public`


