# laravel-start-project

Dit startproject bevat een eerste introductie tot [laravel](https://laravel.com/docs/5.5). Er is gewerkt in Laravel 5.5.  

Er is een aparte readme met een [stappenplan](Installation.md) voor het opzetten van een [laravel](https://laravel.com/docs/5.5) project.
Voor dit stappenplan wordt er vanuit gegaan dat er gebruik wordt gemaakt van 
**Vagrant / Homestead**. 

## Inhoud
1. [Aanmaken van een nieuwe pagina](#chapter-1)
2. [Werken met formulieren](#chapter-2)
3. [Hyperlinks](#chapter-3)

<a id="chapter-1"></a>
## Aanmaken van een nieuwe pagina
Voor het aanmaken van een nieuwe pagina heb je in ieder geval drie onderdelen nodig
* Een [route](#routing) verwijzing in routes/**web.php**
* Een [controller](#controller) met daarin een functie
* Een [view](#view) in de map resources

<a id="routing"></a>
#### Routing
Navigeer naar routes/web.php of druk twee maal op SHIFT in PhpStorm en zoek op 'web'. In dit
bestand kun je alle routes (URL's) definiëren die afgehandeld moeten worden door het framework. Dit werkt als volgt: er wordt een bepaald request gedaan naar de server en het framework zoekt in dit bestand of er een match is met een van de gedefinieerde routes in web.php.

Voorbeeld<br>
Stel je voert in je browser het volgende url in: [http://localhost/contact](http://localhost/contact). Het framwork ontleedt dit url en splitst het op de slashes. 
<br>
In web.php zijn de volgende routes gedefinieerd:

```
Route::get('/',        'HomeController@index');    //match met http://localhost
Route::get('/contact', 'HomeController@contact');  //match met http://localhost/contact
```

Als eerst wordt er naar de method van de request gekeken. In beide gevallen staat achter Route de functie 'get' genoemd. Deze verwijzingen hebben alleen een match bij GET-requests. Anders opties zijn op de site van Laravel te vinden onder [Routing](https://laravel.com/docs/5.5/routing#redirect-routes). 
<br>
De eerste parameter bevat het url van de request en de tweede parameter bevat een verwijzing naar de **Controller** en de **method** in de controller die uitgevoerd moet worden. In dit geval heeft het url een match met de tweede routing verwijzing en zal dus de functie contact in de HomeController worden uitgevoerd. 

Onderdelen die vaak terugkomen in de url zijn: `[root]/[naam_controller]/[method_in_controller]/[id]`

http://localhost/movie/edit/12
<br>
heeft een match met
```
Route::get('/movie/edit/{id}', 'MovieController@edit');
```

_Wanneer je je verder gaat verdiepen in routes is het verstandig om te gaan werken met [named routes](https://laravel.com/docs/5.5/routing#named-routes). Op die manier hoef je niet op allerlei plekken code aan te passen als urls veranderen._ 

<a id="controller"></a>
#### Controller
Voor het aanmaken van een nieuwe controller maken we gebruik van een commando in de terminal.  

`php artisan make:controller [NaamVanDeController]`

Dit genereert een template voor een controller welke naar eigen wens aan te passen is. De controller wordt geplaatst in de map app > Http > Controllers. 
In dit geval willen we de HomeController aanmaken en gebruiken het volgende commando

```
php artisan make:controller HomeController
```

Let op! Als deze wordt aangemaakt, moet je in PhpStorm het bestand nog handmatig toevoegen aan GIT. 

De controller die aangemaakt wordt, is een PHP class. In deze class kunnen functies geplaatst worden die uitgevoerd worden door het framework als er een match is geweest met een van de routes. De controller (of eigenlijk de functie) returnt de view die gerenderd moet worden. 
<br>
Let op dat de naam van het bestand en de naam van de class met elkaar overeenkomen. Als je het artisan commando gebruikt dan gebeurt dit automatisch. 

Voorbeeld
<br>
```
class HomeController extends Controller
{
    public function contact() {
        return view('home.contact');
    }
}
```

Na het invoeren van het url http://localhost/contact in de browser zal via het routingsystem bovenstaande method uitgevoerd worden. Uiteindelijk zal de view in de map `resources/views/home/contact.blade.php` worden uitgevoerd.

 <a id="view"></a>
#### View
Alle views staan in de map **resources**. In de map views maak je een nieuwe map waarvan de naam overeenkomt met de controller. Is de naam van de controller **HomeController**, dan maak je een map met de naam **home**.
<br>
In deze map maak je een nieuw bestand met de naam van de functie. Is de functienaam **contact**, dan maak je een view met de naam **contact.blade.php**.

[Blade](https://laravel.com/docs/5.5/blade) is de template engine van Laravel. Blade biedt allerlei hulpmiddelen om op een gestructureerde manier code in views te gebruiken zonder het openen en sluiten van php tags (`<?php ... ?>`).

Een blade-view bestaat uit reguliere HTML code. Het is ook mogelijk om data aan de view mee te sturen. In de controller kun je data als associatieve array meesturen als tweede paramter van de view method. Binnen de view is deze data te benaderen binnen dubbele accolades. 

Controller
```
class HomeController extends Controller
{
    public function contact() {

        $email = 'name@mail.com';

        return view('home.contact', ['email' => $email]);
    }
}
```

View
```
<!doctype html>
<html lang="en">
<head>
    <title>Contact</title>
</head>
<body>
    <section>
        <h1>Contact information</h1>
        <h2>Visitors address</h2>
        <p>
            Hogeschool Rotterdam<br>
            Wijnhaven 99<br>
            3011 WN Rotterdam
        </p>
        <h2>E-mail</h2>
        <p>
            {{ $email }}
        </p>
    </section>
</body>
</html>
```

<a id="chapter-2"></a>
## Werken met formulieren

Bij het werken met formulieren is het goed jezelf te realiseren dat er een aantal aandachtspunten zijn. Een formulier wordt ingevuld en verzonden, er is gebruikersinteractie en de database wordt aangesproken. Denk daarbij aan:
* wat is het [soort request](https://laravel.com/docs/5.5/controllers#resource-controllers) dat afgehandeld moet worden? (GET, POST, PUT, ...)
* Is het formulier beveiligd tegen [Cross-site request forgeries](https://laravel.com/docs/5.5/csrf)?
* Is er beveiliging tegen [SQL-injections](https://laravel.com/docs/5.5/queries#introduction)?
* Is er [validatie](https://laravel.com/docs/5.5/validation) nodig op de form data?

Om het werken met formulieren te versnellen is het advies om te werken met Form Helpers. Een veel gebruikte package is die van [LaravelCollective](https://laravelcollective.com/docs/master/html).

#### Controller
In dit voorbeeld gaan we uit van een registratieformulier. Daarvoor maken we aan nieuwe [controller](#controller) UserController aan. Met daarin een method **create** voor de GET request en een method **store** voor de POST request. **Create** wordt de eerste keer aangeroepen en **store** wordt aangeroepen als er op **submit** is gedrukt. 

```
class UserController extends Controller
{
    public function index() {
        return ('A list of all users');
    }
    public function create() {
        return view('user.create');
    }

    public function store(Request $request) {
        return redirect('/users');
    }
}
```
Wanneer de **store** functie aangeroepen wordt zie je dat er een extra paramter is opgenomen genaamd **$request**. Het laravel framework zorgt er automatisch voor dat alle form data wordt omgezet naar een array. Deze is te benaderen via de **$request** variabele.

In de **store** method zal de data gevalideerd moeten worden. Als de data niet goed is zal de view opnieuw getoond moeten worden en een error getoond moeten worden. Wanneer de data in orde is zal de data uit het formulier opgeslagen moeten worden in de database. 

Na het opslaan van de nieuwe gebruiker zal de bezoeker doorgestuurd worden naar de index-pagina middels een redirect. 
```
return redirect('/users');
```

#### view
Ook zal er een [view](#view) aangemaakt moeten worden waar het registratieformulier in opgenomen is. Deze view wordt opgeslagen onder **resources/views/user/create.blade.php**.

```
<body>
    <h1>Create new user</h1>
    {!! Form::open(['url' => 'users']) !!}
    {!! Form::text('firstname', 'voornaam') !!}
    {!! Form::submit() !!}
    {!! Form::close() !!}
</body>
```
Hier wordt gebruik gemaakt van Form Helpers. Op basis van de parameters wordt HTML gecreëerd. Ook zal er een CSRF-token toegevoegd worden aan het formulier om Cross-Site Request Forgery tegen te gaan. 

#### route
In de [routes](#routing) worden de verwijzingen naar de controller verwerkt waarbij er onderscheid gemaakt moet worden of het om een GET of POST request gaat. 

```
Route::prefix('users')->group(function () {
    Route::get ('/',        'UserController@index');
    Route::get ('/create',  'UserController@create');
    Route::post('/',        'UserController@store');
});
```

Er wordt hier gebruik gemaakt van een [prefix](https://laravel.com/docs/5.5/routing#route-group-prefixes). Alle routes in de prefix group zullen vooraf moeten gaan aan het woord 'users'. Zo is het binnen de group niet meer nodig deze steeds opnieuw te noteren. 
<br>
Het url Http://localhost/users/create zal door de routing afgehandeld worden en wordt doorgestuurd naar de **create** method in de **UserController**.
<br>
Wanneer het formulier verzonden wordt is er sprake van een POST-request. Deze zal binnenkomen op het url Http://localhost/users en wordt doorgestuurd naar de **store** method in de **UserController**.

#### Validatie
De data uit het formulier wordt nu nog niet gevalideerd. Deze validatie zal plaats moeten vinden in de **store** functie. Dit is immers de functie waar de data terecht komt na een POST. 

```
public function store(Request $request) {

    $request->validate([
        'firstname' => 'required|min:2'
    ]);

    return redirect('/users');
}
```

De data die opgeslagen is in de **$request** variabele kan gevalideerd worden middels de **validate** method. Aan deze method kan een associatieve array meegegeven worden waarbij de **key** correspondeert met de **name** van het inputelement. 
<br>
De **value** bevat informatie waarop de data gevalideerd dient te worden. In dit geval is het veld vereist, dit wordt aangegeven met **required**. Het veld moet verder minimaal 2 karakters bevatten. 

Wanneer de data niet valide is, stuurt de method de bezoeker automatisch terug naar de create view en wordt er een **errors array** meegestuurd met de overeenkomende error messages. 
Wanneer het inputelement een error oplevert dan is deze in de view op te vangen middels onderstaande code.

```
<div>
    {!! Form::text('firstname', 'voornaam') !!}
    <span>{{ $errors->first('firstname') }}</span>
</div>
```

*Voor alle standaard validatie regels (zoals required), zijn standaard error messages. Deze zijn terug te vinden in **resources/lang/en/validation.php**. Wanneer je standaard error messages wilt aanmaken in een andere taal, maak dan een kopie van validation.php en plaats deze in de folder van de taal in de **lang** folder. Voor Nederlands voeg je een **nl** folder toe. Vervolgens vertaal je de onderdelen naar de gewenste taal in het validation.php bestand. Je kunt onderdelen weglaten als je deze niet wilt vertalen. In dat geval wordt Engels gebruikt.* 

<a id="chapter-3"></a>
## Hyperlinks

Het aanmaken van links kan op meerdere manieren. Enkele voorbeelden zijn:
* [traditionele HTML](#trad-html)
* door gebruik te maken van [helper functies](#helper-functions)
* door gebruik te maken van [helper functies van externe partijen](#ext-helper-functions)
* [named routes](#named-routes)

<a id="trad-html"></a>
#### Traditionele HTML
Aangezien het routingsysteem van Laravel de URL's vertaalt naar functies kan er met reguliere anchor tags gewerkt worden. 
```
<a href="/users/edit/12">Edit</a>
```
Het nadeel is echter dat je zelf rekening moet houden dat links relatief aan het domein opgesteld worden. Ook als er wijziginen aangebracht worden zal je code moeten aanpassen. 

<a id="helper-functions"></a>
#### Helper functies
Voor veel onderdelen in Laravel zijn er [Helper functions](https://laravel.com/docs/5.5/helpers). Zo ook voor URL's. 
```
url('users/create')
```
[url()](https://laravel.com/docs/5.5/helpers#method-url) houdt rekening met het domein zoals opgegeven in **config/app.php**

```
action('UserController@create')
```
In dit geval is het niet nodig om de routing te weten enkel de controller en de methodnaam. 

```
asset('images/photo.jpg')
```
Voor het laden van assets zoals plaatjes kan [asset()](https://laravel.com/docs/5.5/helpers#method-asset) gebruikt worden. Plaatjes worden over het algemeen opgeslagen in de **public** folder en dan vaak in een map **images**. 

<a id="ext-helper-functions"></a>
#### Externe helper functies
Ook in de library van [LaravelCollective](https://laravelcollective.com/docs/master/html#generating-urls) zitten helpers voor URL's. 

<a id="named-routes"></a>
#### Named routes
De beste optie voor het linken vanuit de applicatie is op basis van een naam. Elke route in web.app kan voorzien worden van een naam. Het voordeel hiervan is dat onderdelen kunnen wijzigen maar de naam blijft hetzelfde. Of nu het URL verandert, de naam van de method of zelfs de controller, er wordt gelinkt naar de naam. 

```
Route::get('users/create', 'UserController@create')->name('users.create');
```
of
```
Route::get('users/create', ['as' => 'users.create', 'uses' => 'UserController@create']);
```

In de view is deze link op de volgende manier te bereiken. 
```
<a href="{{ route('users.create')}}">Create</a>
```
Het is ook mogelijk om een id mee te geven. 
```
<a href="{{ route('users.edit', ['id' => 1])}}">Edit</a>
```