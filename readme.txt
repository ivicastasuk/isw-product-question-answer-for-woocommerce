=== ISW Product Question and Answer for WooCommerce ===
Contributors: isw-team
Tags: woocommerce, product questions, q&a, customer questions, product support
Requires at least: 5.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Dodaje Q&A funkcionalnost za WooCommerce proizvode koja omogućava kupcima da postavljaju pitanja o proizvodima.

== Description ==

ISW Product Question and Answer plugin omogućava kupcima da postavljaju pitanja o WooCommerce proizvodima direktno na stranici proizvoda. Administratori mogu da odgovaraju na pitanja kroz intuitivni admin panel.

**Ključne karakteristike:**

* **Q&A tab na stranicama proizvoda** - Automatski se integriše u WooCommerce proizvode
* **Admin panel za upravljanje** - Centralizovano upravljanje svim pitanjima i odgovorima
* **Potpuno prilagodljiv dizajn** - Napredne opcije za stilizovanje
* **Sigurnost i bezbednost** - Implementirane WordPress sigurnosne prakse
* **HPOS kompatibilnost** - Podržava WooCommerce High-Performance Order Storage
* **Responsive dizajn** - Radi na svim uređajima

**Admin funkcionalnosti:**

* Pregled svih pitanja po proizvodima
* Filtriranje pitanja (sva/odgovorena/neodgovorena)
* Odobravanje pitanja pre objavljivanja
* Brzo odgovaranje kroz admin interface
* Detaljne opcije stilizovanja

**Opcije stilizovanja:**

* Tipografija (font, veličina, boja, transformacija teksta)
* Pozadine i kontejneri (boje, borderi, padding, margin)
* Dugmići (boje, hover efekti, padding, border radius, text transform)
* Podesivi tekstovi dugmića
* Live preview u admin panelu

**Sigurnost:**

* WordPress nonce verifikacija
* Kompletna sanitizacija svih ulaznih podataka
* wp_kses validacija za HTML output
* Provera korisničkih dozvola
* Escape output podataka
* Validacija i ograničavanje input vrednosti

== Installation ==

1. Upload plugin fajlove u `/wp-content/plugins/isw-product-question-answer-for-woocommerce/` direktorijum
2. Aktivirajte plugin kroz 'Plugins' meni u WordPress admin-u
3. Idite na Products → ISW Product Q&A → Postavke za konfiguraciju
4. Plugin će automatski dodati Q&A tab na sve WooCommerce proizvode

== Frequently Asked Questions ==

= Da li je potreban WooCommerce? =

Da, ovaj plugin zahteva instaliran i aktivan WooCommerce plugin.

= Kako mogu da promenim izgled Q&A sekcije? =

Idite na Products → ISW Product Q&A → Postavke gde možete prilagoditi tipografiju, boje, dugmiće i ostale vizuelne elemente.

= Da li mogu da moderujem pitanja pre objavljivanja? =

Da, sva nova pitanja se mogu postaviti na "pending" status i ručno odobriti kroz admin panel.

= Da li plugin radi sa bilo kojom temom? =

Da, plugin je dizajniran da radi sa bilo kojom WordPress/WooCommerce temom. Opcije stilizovanja omogućavaju potpuno prilagođavanje izgleda.

== Screenshots ==

1. Q&A tab na stranici proizvoda
2. Admin panel za upravljanje pitanjima
3. Opcije stilizovanja u admin panelu
4. Live preview dugmića

== Changelog ==

= 1.2.0 =
* Dodane napredne opcije stilizovanja
* Live preview funkcionalnost za dugmiće
* Text transform opcije za dugmiće
* Podesivi tekstovi dugmića
* Poboljšana sigurnost i sanitizacija svih input/output podataka
* Implementirana kompletna sanitization za sve settings opcije
* Dodana wp_kses validacija za HTML output
* Uklonjen debug kod
* Dodana internationalization podrška
* Dodana HPOS (High-Performance Order Storage) kompatibilnost

= 1.1.0 =
* Dodat admin panel za upravljanje pitanjima
* Opcije za odobravanje/brisanje pitanja
* Poboljšan UI/UX
* Osnovne opcije stilizovanja

= 1.0.0 =
* Početna verzija
* Osnovna Q&A funkcionalnost
* WooCommerce integracija

== Upgrade Notice ==

= 1.2.0 =
Ova verzija dodaje napredne opcije stilizovanja i poboljšava sigurnost. Preporučuje se ažuriranje.

== Support ==

Za podršku i pitanja kontaktirajte ISW tim.

== License ==

Ovaj plugin je licenciran pod GPLv2 ili novijom verzijom.
