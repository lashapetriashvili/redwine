<p align="center">
	<img alt="Redwine" src="https://redwine.webhouse.ge/assets/img/logo%202%20(200X200).png">
</p>

<p align="center">
	<a href="https://packagist.org/packages/redwine/redwine"><img src="https://poser.pugx.org/redwine/redwine/downloads" alt="Total downloads"></a>
	<a href="https://packagist.org/packages/redwine/redwine"><img src="https://poser.pugx.org/redwine/redwine/d/monthly" alt="Monthly downloads"></a>
	<a href="https://packagist.org/packages/redwine/redwine"><img src="https://poser.pugx.org/redwine/redwine/license" alt="License"></a>
</p>

# Redwine - Laravel Admin Panel

Created By [Web house Studio](https://webhouse.ge/#home)

ვებგვერდი & დოკუმენტაცია: [https://redwine.webhouse.ge](https://redwine.webhouse.ge/)

facebook:[ https://www.facebook.com/RedwineLaravelAdminPanel](https://www.facebook.com/RedwineLaravelAdminPanel/)

# რა არის Redwine?

#### Redwine არის Larevel Admin Panel რომლის დახმარებითაც თქვენ შეძლებთ მარტივად:

* შექმნათ მონაცემთა ბაზისთვის ახალი ცხრილი phpMyAdmin-ის გარეშე
* ახალი მონაცემთა ბაზის ცხრილს შეუქმნათ თავისი გვერდი რამოდენიმე წამში
* დაამატოთ ახალი მომხმარებელი
* მისცეთ მას არსებული უფლებები ან ახალი შეუქმნა
* შექმნათ დინამიური მენიუ
* შექმნათ პოსტები
* შექმნათ გვერდები

Redwine-ის მთავარი ფუნქცია არის ახალი მონაცემთა ბაზისთვის ცხრილის შექმნა phpMyAdmin-ის გარეშე და შემდეგ ამ ცხრილისთვის გვერდის გაკეთება. ამ გვერდზე კი თქვენ შეძლებთ მარტივად ნახოთ, დაამატოთ, დაარედაქტიროთ და წაშალოთ ცხრილში არსებული ინფორმაცია კოდის არცერთი ხაზის დაწერით სულ რამოდენიმე წუთში.

#### Redwine **არ არის:**

* CMS \(Content Management System\)

* Blogging Platform

Redwine არის Laravel-ისთვის განკუთვნილი Admin Panel და არა CMS. ის CMS და Fraimwork-ის ნაზავია, ამიტომ თქვენ შეძლებთ უმოკლეს დროში გააკეთოთ ყველაფერი რასაც კი მოინდომებ.

# Redwine-ის ინსტალაცია

### Laravel-ის ჩამოტვირთვა

დარწმუნდი რომ შენი სერვერი აკმაყოფილებს შემდეგ მოთხოვნებს:

* PHP &gt;= 7.1.3
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Ctype PHP Extension
* JSON PHP Extension

##### 1. Composer-ის საშვალებით ჩამოტვირთე Laravel-ის უახლესი ვერსია

```
composer create-project --prefer-dist laravel/laravel blog
```

##### 2. შეიყვანე შენი მონაცემთა ბაზის მისამართი .env ფაილში

```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

##### 3. დააგენერირე KEY

```
php artisan key:generate 
```

### Redwine-ის ჩამოტვირთვა

##### 1. Laravel-ის დაყენების შემდეგ შეგიძლია ჩამოტვირთო Redwine

```
composer require redwine/redwine
```

##### 2. ჩამოტვირთვის დასრულების შემდეგ შეგიძლია დააინსტალირო

```
php artisan redwine:install
```

> თუ ინსტალაციის დროს წააწყდი "Specified key was too long error" შეცდომას არ იდარდო ეს MySQL Error არის და [https://laravel-news.com/laravel-5-4-key-too-long-error](https://laravel-news.com/laravel-5-4-key-too-long-error) ამ ლინკის დახმარებით მარტივად გამოასწორებ :\)

##### 3. თუ იყენებ Laravel-ის 5.4 ან უფრო პატარა ვერსიას, მაშინ მოგიწევს Redwine-ის Service Provider და aliases ხელით ჩაწერა config/app.php ფაილში

```
Redwine\RedwinePackageServiceProvider::class, // Service Provider
```

```
'Redwine' => Redwine\Facades\Redwine::class, // aliases
```

> laravel 5.5 და მაღალ ვერსიებში ხელით ჩაწერა აღარ არის საჭირო

##### 4. გილოცავ შენ წარმატებით დააყენე Redwine 

Redwine ავტომატურად შეგიქმნის დროებით მომხმარებელს რომლის რედაქტირება მუდამ შეგიძლია

> E-mail: admin@admin.com
>
> Password: 123

##### 5. გაუშვი სერვერი

```
php artisan serv
```

Redwine-ზე შესასვლელი ლინკი არის [localhost:8000/redwine](http://localhost:8000/redwine) ან [127.0.0.1:8000/redwine](http://127.0.0.1:8000/redwine) 





