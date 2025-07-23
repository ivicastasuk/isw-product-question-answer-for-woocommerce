# ISW Product Question and Answer for WooCommerce

> Professional Q&A functionality for WooCommerce products with advanced styling options and admin management.

[![WordPress](https://img.shields.io/badge/WordPress-5.0%2B-blue.svg)](https://wordpress.org/)
[![WooCommerce](https://img.shields.io/badge/WooCommerce-3.0%2B-green.svg)](https://woocommerce.com/)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple.svg)](https://php.net/)
[![License](https://img.shields.io/badge/License-GPLv3-red.svg)](https://www.gnu.org/licenses/gpl-3.0.html)

## 📋 Pregled

ISW Product Question and Answer plugin omogućava kupcima da postavljaju pitanja o WooCommerce proizvodima direktno na stranici proizvoda. Administratori mogu da odgovaraju na pitanja kroz intuitivni admin panel. Plugin je potpuno prilagodljiv sa naprednim opcijama stilizovanja i sigurnosnim funkcijama.

## ✨ Ključne karakteristike

### 🛍️ Frontend funkcionalnosti
- **Q&A tab na stranicama proizvoda** - Automatski se integriše u WooCommerce proizvode
- **Responsive dizajn** - Radi na svim uređajima (desktop, tablet, mobile)
- **AJAX učitavanje** - Brzo učitavanje pitanja bez refresh-a stranice
- **Paginacija** - "Učitaj još" dugme za postepeno učitavanje
- **Sistem odobrenja** - Pitanja mogu biti postavljena na pending status

### 🎛️ Admin funkcionalnosti
- **Centralizovano upravljanje** - Pregled svih pitanja po proizvodima
- **Napredna filtriranja** - Filtriranje pitanja (sva/odgovorena/neodgovorena)
- **Brzo odgovaranje** - Direktno odgovaranje kroz admin interface
- **Moderacija** - Odobravanje pitanja pre objavljivanja
- **Email notifikacije** - Automatske notifikacije za nova pitanja

### 🎨 Napredne opcije stilizovanja
- **Tipografija** - Font family, veličina, težina, boja, transformacija teksta, line height
- **Pozadine i kontejneri** - Boje pozadine za pitanja/odgovore, borderi, padding, margin, border radius
- **Dugmići** - Potpuno prilagodljivi dugmići sa hover efektima, width opcije, poravnavanje
- **Live preview** - Real-time pregled promena u admin panelu
- **Custom tekst dugmića** - Potpuna kontrola nad tekstom dugmića

### 🔒 Sigurnost i bezbednost
- **WordPress nonce verifikacija** - Zaštićeni AJAX pozivi
- **Kompletna sanitizacija** - Svi ulazni podaci su proveravani i očišćeni
- **wp_kses validacija** - Sigurna HTML validacija za output
- **Provera korisničkih dozvola** - Samo ovlašćeni korisnici mogu pristupiti funkcijama
- **Escape output podataka** - Svi izlazni podaci su bezbedni
- **Input validacija** - Ograničavanje i validacija svih vrednosti

### 🌐 Internationalization
- **Text domain podrška** - Spreman za prevod na sve jezike
- **Serbian lokalizacija** - Uključen srpski prevod (.po/.pot fajlovi)
- **gettext kompatibilnost** - Standardni WordPress i18n sistem

### ⚡ Kompatibilnost
- **HPOS podrška** - WooCommerce High-Performance Order Storage
- **WordPress 6.8.2+** - Testiran sa najnovijim verzijama
- **WooCommerce 10.0.2+** - Kompatibilan sa najnovijim WooCommerce
- **PHP 7.4+** - Moderne PHP funkcionalnosti
- **Block themes** - Radi sa svim WordPress temama

## 🚀 Instalacija

### Automatska instalacija
1. Idite na **Plugins → Add New** u WordPress admin panelu
2. Pretražite "ISW Product Question Answer"
3. Kliknite **Install Now** i zatim **Activate**

### Manualna instalacija
1. Download-ujte plugin ZIP fajl
2. Idite na **Plugins → Add New → Upload Plugin**
3. Odaberite ZIP fajl i kliknite **Install Now**
4. Aktivirajte plugin

### Konfiguracija
1. Idite na **Products → ISW Product Q&A → Postavke**
2. Konfigurišite opcije prema vašim potrebama
3. Plugin će automatski dodati Q&A tab na sve WooCommerce proizvode

## 📖 Korišćenje

### Frontend
Kada je plugin aktiviran, Q&A tab se automatski pojavljuje na svim stranicama proizvoda. Korisnici mogu:
- Postaviti pitanja (potrebna prijava)
- Videti odgovore administratora
- Učitati dodatna pitanja

### Admin panel
Administratori pristupaju funkcijama kroz **Products → ISW Product Q&A**:

#### Q&A upravljanje
- Pregled svih pitanja po proizvodima
- Filtriranje po statusu (sva/odgovorena/neodgovorena)
- Direktno odgovaranje na pitanja
- Odobravanje/brisanje pitanja

#### Postavke
- **Osnovne postavke**: Omogućavanje tab-a, naslov, prioritet
- **Frontend postavke**: Broj pitanja po stranici, auto-odobravanje, email notifikacije
- **Tipografija**: Font familija, veličina, težina, boja, transformacija
- **Pozadina i kontejneri**: Boje, borderi, padding, margin, border radius
- **Dugmići**: Kompletno stilizovanje sa live preview

## 🎨 Stilizovanje

### Osnovni CSS selektori
```css
/* Glavni kontejner */
#isw-qa-container { }

/* Thread kontejner */
.qa-thread { }

/* Pitanje */
.qa-item .question { }

/* Odgovor */
.qa-item .answer { }

/* Dugmići */
.isw-qa-btn { }

/* Forma za pitanje */
#isw-qa-form { }
```

### Dinamički CSS
Plugin automatski generiše CSS na osnovu postavki iz admin panela. Sve opcije stilizovanja se primenjuju kroz inline CSS.

## 🔧 API i razvoj

### Custom Post Type
Plugin koristi `isw_product_question` CPT za čuvanje podataka:
- **Pitanja**: `post_parent = 0`
- **Odgovori**: `post_parent = question_id`
- **Meta podaci**: `product_id` za povezivanje sa proizvodima

### AJAX Actions
- `isw_pqa_submit` - Slanje novog pitanja
- `isw_pqa_submit_answer` - Slanje odgovora (admin)
- `isw_pqa_load` - Učitavanje pitanja i odgovora

### Hooks i filteri
```php
// Prilagodi tab naslov
add_filter('woocommerce_product_tabs', function($tabs) {
    // Vaš kod
    return $tabs;
});

// Prilagodi Q&A sadržaj
add_action('isw_pqa_before_tab_content', function() {
    // Vaš kod
});
```

### Funkcije za opcije
```php
// Dobij opciju plugina
$value = isw_pqa_get_option('option_name', 'default_value');

// Generiši dinamički CSS
$css = isw_pqa_generate_dynamic_css();
```

## 📂 Struktura fajlova

```
isw-product-question-answer-for-woocommerce/
├── README.md                          # GitHub dokumentacija
├── readme.txt                         # WordPress plugin info
├── LICENSE                            # GPL v2 licenca
├── isw-product-question-answer-for-woocommerce.php  # Glavni plugin fajl
├── admin.php                          # Admin funkcionalnosti
├── admin-settings.php                 # Settings stranica
├── uninstall.php                      # Cleanup skripta
├── css/
│   └── style.css                      # CSS stilovi
├── js/
│   └── qa-ajax.js                     # JavaScript/AJAX
└── languages/
    ├── isw-product-question-answer-for-woocommerce.pot  # Template
    ├── isw-product-question-answer-for-woocommerce-en_US.po  # English
    └── README.md                      # Languages info
```

## ⚙️ Sistemski zahtevi

| Zahtev | Minimalna verzija | Preporučena verzija |
|--------|-------------------|-------------------|
| WordPress | 5.0 | 6.8+ |
| WooCommerce | 3.0 | 10.0+ |
| PHP | 7.4 | 8.1+ |
| MySQL | 5.6 | 8.0+ |

## 🔄 Changelog

### 1.2.0 (Current)
- ✅ Dodane napredne opcije stilizovanja
- ✅ Live preview funkcionalnost za dugmiće
- ✅ Text transform opcije za dugmiće
- ✅ Podesivi tekstovi dugmića
- ✅ Poboljšana sigurnost i sanitizacija
- ✅ Kompletna wp_kses validacija za HTML output
- ✅ Uklonjen debug kod
- ✅ Dodana internationalization podrška
- ✅ HPOS (High-Performance Order Storage) kompatibilnost
- ✅ WordPress 6.8.2 i WooCommerce 10.0.2 kompatibilnost

### 1.1.0
- ✅ Dodat admin panel za upravljanje pitanjima
- ✅ Opcije za odobravanje/brisanje pitanja
- ✅ Poboljšan UI/UX
- ✅ Osnovne opcije stilizovanja

### 1.0.0
- ✅ Početna verzija
- ✅ Osnovna Q&A funkcionalnost
- ✅ WooCommerce integracija

## 🐛 Poznati problemi

- Nema poznatih problema u trenutnoj verziji
- Testiran sa najčešće korišćenim temama
- HPOS kompatibilnost potvrđena

## 🤝 Doprinos

Dobrodošli su doprinosi! Molimo:
1. Fork-ujte repository
2. Napravite feature branch
3. Commit-ujte promene
4. Push-ujte na branch
5. Napravite Pull Request

## 📞 Podrška

- **GitHub Issues**: [Prijavite bug ili zahtev](https://github.com/yourusername/isw-product-question-answer-for-woocommerce/issues)
- **Email**: support@isw-team.com
- **Dokumentacija**: [Wiki stranice](https://github.com/yourusername/isw-product-question-answer-for-woocommerce/wiki)

## 📄 Licenca

Ovaj plugin je licenciran pod [GPL v2 ili novijom](https://www.gnu.org/licenses/gpl-2.0.html) licencom.

```
ISW Product Question and Answer for WooCommerce
Copyright (C) 2024 ISW Team

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

## 🏆 Krediti

Razvio **ISW Team** - Profesionalni WordPress i WooCommerce razvoj.

---

⭐ **Ako vam se plugin dopada, molimo vas da mu date star na GitHub-u!** ⭐