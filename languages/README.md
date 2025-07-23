# Language Files / Jezički fajlovi

Ovaj folder sadrži language template i prevodne fajlove za ISW Product Q&A plugin.

## Kako da prevedete plugin:

### Opcija 1: Koristeći Loco Translate Plugin
1. Instalirajte [Loco Translate](https://wordpress.org/plugins/loco-translate/) plugin
2. Idite u WP Admin → Loco Translate → Plugins
3. Pronađite "ISW Product Question and Answer for WooCommerce"
4. Kliknite "New language" i izaberite željeni jezik
5. Prevedite stringove kroz Loco Translate interfejs

### Opcija 2: Ručno kreiranje .po fajla
1. Kopirajte `isw-pqa.pot` fajl
2. Promenite ekstenziju u `.po` (npr. `isw-pqa-sr_RS.po` za srpski)
3. Koristite neki editor poput PoEdit da prevedete stringove
4. Generirajte `.mo` fajl iz `.po` fajla

### Opcija 3: Automatski prevod preko WordPress.org
Plugin koristi `'isw-pqa'` text domain i automatski će koristiti prevode dostupne preko WordPress.org translation sistema.

## Struktura fajlova:
- `isw-product-question-answer-for-woocommerce.pot` - Template fajl sa svim stringovima za prevođenje
- `isw-product-question-answer-for-woocommerce-{locale}.po` - Prevodni fajl za specifičan jezik
- `isw-product-question-answer-for-woocommerce-{locale}.mo` - Kompajlirani prevodni fajl

## Podržani jezici:
Trenutno plugin sadrži texte na srpskom jeziku. Možete dodati prevode za bilo koji jezik.

## Napomene:
- Plugin je "translation ready" 
- Koristi WordPress internationalization best practices
- Kompatibilan sa Loco Translate, WPML, Polylang i ostalim translation plugin-ima
- Text domain: `isw-product-question-answer-for-woocommerce`
