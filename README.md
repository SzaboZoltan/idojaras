## ChatAKI Embed (Web Component) – WordPress bővítmény

[![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-21759b?logo=wordpress&logoColor=white)](https://wordpress.org/)
[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-777bb4?logo=php&logoColor=white)](https://www.php.net/)
[![Status](https://img.shields.io/badge/Status-Production%20ready-success)](#)
[![License](https://img.shields.io/badge/License-Custom-lightgrey)](#licenc-és-szerzői-jog)

### Tartalomjegyzék

- [ChatAKI Embed (Web Component) – WordPress bővítmény](#chataki-embed-web-component--wordpress-bővítmény)
  - [Fő funkciók](#fő-funkciók)
  - [Telepítés](#telepítés)
    - [1. Követelmények](#1-követelmények)
    - [2. Fájlok másolása](#2-fájlok-másolása)
    - [3. Aktiválás](#3-aktiválás)
  - [Beállítások – Admin felület](#beállítások--admin-felület)
    - [Elérhető mezők](#elérhető-mezők)
  - [Shortcode használat](#shortcode-használat)
    - [Alap inline használat](#alap-inline-használat)
    - [Popup mód](#popup-mód)
  - [Shortcode attribútumok – Web Component paraméterezés](#shortcode-attribútumok--web-component-paraméterezés)
  - [Működés technikai részletek](#működés-technikai-részletek)
    - [Főtípusok és osztályok](#főtípusok-és-osztályok)
    - [Asset betöltés](#asset-betöltés)
  - [Tipikus hibák és elhárításuk](#tipikus-hibák-és-elhárításuk)
  - [Licenc és szerzői jog](#licenc-és-szerzői-jog)
  - [Függvények részletesen](#függvények-részletesen)
    - [`chataki-embed.php`](#chataki-embedphp)
    - [`ChatAKI\Embed\Plugin` osztály](#chatakiembedplugin-osztály)
    - [`ChatAKI\Embed\Settings` osztály](#chatakiembedsettings-osztály)
    - [`ChatAKI\Embed\Shortcode` osztály](#chatakiembedshortcode-osztály)

A **ChatAKI Embed** WordPress bővítmény, amely a ChatAKI `&lt;embed-chat&gt;` Web Componentet ágyazza be az oldaladra, és modern, gyors chat-élményt ad a látogatóidnak.  
**Típus**: WordPress bővítmény • **Komponens**: `&lt;embed-chat&gt;` Web Component • **Verzió**: `2.0.0`

Két fő megjelenítési módot támogat:

- **Inline mód**: a chat közvetlenül a tartalomban jelenik meg.
- **Popup mód**: a képernyő egyik sarkában felugró, ikonról nyitható chat ablak.

**Gyors áttekintés**

| Tulajdonság                 | Érték                                      |
| --------------------------- | ------------------------------------------ |
| Minimális WordPress verzió | 6.0                                        |
| Minimális PHP verzió       | 8.3                                        |
| Shortcode                  | `[chataki]`                               |
| Admin menü                 | `Beállítások → ChatAKI Embed`             |
| Ajánlott API protokoll     | HTTPS                                      |

---

### Fő funkciók

- **Shortcode alapú beágyazás**: `[chataki]` – inline vagy popup módban.
- **Asset betöltés**:
  - csak akkor tölti be a Web Component CSS/JS fájljait, ha az adott oldalon valóban használod a `[chataki]` shortcode-ot;
  - saját popup keret CSS/JS a megjelenítéshez (`popup.css`, `popup.js`).
- **Admin beállítási felület**:
  - Web Component erőforrás URL-ek (`embed-chat.min.css`, `embed-chat.min.js`);
  - Chat API végpont (`api_url`);
  - Chat azonosító (`chat_key`);
  - Widget cím (`widget_title`);
  - reCAPTCHA site key (`recaptcha_site_key`);
  - keret szélesség és magasság (`width`, `height`).
- **Biztonság és teljesítmény**:
  - csak `is_singular()` oldalon és shortcode jelenlét esetén tölt be asseteket;
  - szigorú típushasználat (PHP 8.3), `declare(strict_types=1)`;
  - WordPress `sanitize` és `esc_*` függvények következetes használata.

---

## Telepítés

### 1. Követelmények

- **WordPress**: legalább 6.0
- **PHP**: legalább 8.3
- **ChatAKI Web Component bundle**:
  - elérhető URL az `embed-chat.min.css` fájlhoz;
  - elérhető URL az `embed-chat.min.js` fájlhoz;
  - működő Chat API végpont (HTTPS ajánlott).

### 2. Fájlok másolása

1. Másold a bővítmény mappáját a WordPress `wp-content/plugins` könyvtárába:
   - `wp-content/plugins/chataki-embed`
2. Ügyelj rá, hogy a mappán belül a következő fontos fájlok legyenek:
   - `chataki-embed.php`
   - `includes/class-chataki-plugin.php`
   - `includes/class-chataki-settings.php`
   - `includes/class-chataki-shortcode.php`
   - `assets/css/popup.css`
   - `assets/js/popup.js`

### 3. Aktiválás

1. Lépj be a WordPress admin felületre.
2. Menj a **Bővítmények → Telepített bővítmények** menübe.
3. Keresd meg a **ChatAKI Embed (Web Component)** bővítményt.
4. Kattints az **Aktiválás** gombra.

---

## Beállítások – Admin felület

A bővítmény saját beállítási oldallal rendelkezik a WordPress admin felületen:

- Menü: **Beállítások → ChatAKI Embed**

Itt egyetlen űrlapon tudod megadni a legfontosabb értékeket. A beállítások a `chataki_embed_settings` nevű WordPress option-ben tárolódnak.

### Elérhető mezők

**Összefoglaló táblázat**

| Kulcs                 | Admin felirat                              | Rövid leírás                                       | Kötelező    |
| --------------------- | ------------------------------------------ | -------------------------------------------------- | ----------- |
| `style_src`           | Web Component CSS URL                      | A widget külső CSS bundle-je.                      | Igen*       |
| `script_src`          | Web Component JS URL                       | A Web Component JS bundle-je.                      | Igen*       |
| `api_url`             | Chat API URL                               | Backend végpont a beszélgetéshez.                  | Igen        |
| `chat_key`            | Chat kulcs                                 | Chat / tenant / bot azonosító.                     | Ajánlott    |
| `widget_title`        | Widget cím                                 | Cím a chat fejlécében.                             | Nem         |
| `recaptcha_site_key`  | reCAPTCHA v3 site key                      | Botvédelemhez szükséges kulcs.                     | Opcionális  |
| `width`               | Alap szélesség (keret)                     | A keret szélessége (inline/popup).                 | Nem         |
| `height`              | Alap magasság (keret)                      | A keret magassága (inline/popup).                  | Nem         |

`*` A CSS/JS URL-ek akkor szükségesek, ha a chatet ténylegesen használod az oldalon.

- **Web Component CSS URL (embed-chat.min.css)** – `style_src`  
  A chat widget stíluslapjának publikus URL-je. Ez határozza meg a chat vizuális megjelenését (színek, tipográfia, layout).  
  - Példa: `https://cdn.example.com/embed-chat.min.css`

- **Web Component JS URL (embed-chat.min.js)** – `script_src`  
  A Web Component JavaScript bundle publikus URL-je, amely:
  - regisztrálja az `&lt;embed-chat&gt;` elemet;
  - kezeli a UI-t (üzenetküldés, lista, input);
  - kommunikál a Chat API-val.  
  - Példa: `https://cdn.example.com/embed-chat.min.js`

- **Chat API URL (api-url attribútum)** – `api_url`  
  A backend végpont, amelyre a Web Component a kéréseket küldi.  
  - Példa: `https://your-api.example.com`

- **Chat kulcs (chat-key attribútum)** – `chat_key`  
  Azonosító, amivel elkülönítheted az egyes chateket (pl. tenant, környezet, bot profil).  
  - Példa: `aip`

- **Widget cím (widget-title attribútum)** – `widget_title`  
  A chat ablak fejlécében megjelenő cím.  
  - Példa: `Segítség`

- **reCAPTCHA v3 site key (recaptcha-site-key attribútum)** – `recaptcha_site_key`  
  Opcionális. Ha a chatben reCAPTCHA v3 védelem van, itt adhatod meg a site key-t.

- **Alap szélesség (keret)** – `width`  
  A chat keretének szélessége (inline és popup módban is).  
  - Példa: `360px` vagy `100%`

- **Alap magasság (keret)** – `height`  
  A chat keretének magassága.  
  - Példa: `520px`

Mentés után a beállítások az egész oldalon alapértelmezettként érvényesülnek, de shortcode attribútumokkal felülírhatók.

---

## Shortcode használat

A bővítmény egyetlen shortcode-ot regisztrál:

- **Tag**: `[chataki]`

### Alap inline használat

```text
[chataki]
```

- A chat **inline** módban jelenik meg, pontosan a shortcode helyén a tartalomban.
- A beállításoknál megadott értékeket használja (`api_url`, `chat_key`, stb.).

### Popup mód

Popup módban a chat egy ikonról nyitható felugró ablakban jelenik meg.

```text
[chataki mode="popup"]
```

Elérhető attribútumok popup módban:

- `mode`:
  - `inline` (alapértelmezett)
  - `popup`
- `position`:
  - `right-top`
  - `right-middle`
  - `right-bottom` (alapértelmezett)
  - `left-top`
  - `left-middle`
  - `left-bottom`
- `default_open`:
  - `0` – zárt állapotból indul (alapértelmezett)
  - `1` – alapból nyitva van az ablak
- `launcher_label`:
  - A popup indítógomb felirata (pl. `Chat`, `Segítség`).

**Shortcode paraméter-összefoglaló**

| Paraméter            | Alapértelmezés                 | Lehetséges értékek                                     | Rövid leírás                                  |
| -------------------- | ------------------------------ | ------------------------------------------------------ | --------------------------------------------- |
| `mode`               | `inline`                       | `inline`, `popup`                                      | Megjelenítés módja.                           |
| `position`           | `right-bottom`                 | `right-top`, `right-middle`, `right-bottom`, `left-top`, `left-middle`, `left-bottom` | Popup pozíciója.                              |
| `default_open`       | `0`                            | `0`, `1`                                               | Popup induláskor nyitva legyen-e.             |
| `launcher_label`     | `Chat`                         | tetszőleges szöveg                                     | Indítógomb felirata.                          |
| `api_url`            | admin beállítás / üres        | érvényes URL                                           | Kötelező backend végpont.                     |
| `chat_key`           | admin beállítás / `aip`       | tetszőleges azonosító                                  | Chat / tenant / bot azonosító.                |
| `widget_title`       | admin beállítás / `Segítség`  | tetszőleges szöveg                                     | Chat ablak címe.                              |
| `recaptcha_site_key` | admin beállítás / üres        | reCAPTCHA v3 site key                                  | Botvédelemhez szükséges kulcs.                |
| `width`              | admin beállítás / `360px`     | pl. `360px`, `100%`                                    | Keret szélessége.                             |
| `height`             | admin beállítás / `520px`     | pl. `520px`                                            | Keret magassága.                              |

**Példák:**

```text
[chataki mode="popup" position="right-bottom"]

[chataki mode="popup" position="left-middle" default_open="1"]
```

---

## Shortcode attribútumok – Web Component paraméterezés

A shortcode attribútumai részben közvetlenül a Web Component felé kerülnek továbbításra:

- `api_url` → `api-url`
- `chat_key` → `chat-key`
- `widget_title` → `widget-title`
- `recaptcha_site_key` → `recaptcha-site-key` (ha meg van adva)

Ezek az attribútumok **shortcode szinten felülírják** az admin beállításokat.

**Példák:**

```text
; api-url felülírása egy konkrét oldalon
[chataki api_url="https://another-api.example.com"]

; másik chat_key és widget_title
[chataki chat_key="support-hu" widget_title="Ügyfélszolgálat"]

; reCAPTCHA site key csak ezen az oldalon
[chataki recaptcha_site_key="6Lc..."]
```

---

## Működés technikai részletek

### Főtípusok és osztályok

- `chataki-embed.php`
  - plugin metaadatok (név, leírás, szerző, verzió);
  - konstansok: `CHATAKI_EMBED_VERSION`, `CHATAKI_EMBED_PATH`, `CHATAKI_EMBED_URL`;
  - betölti a `Plugin`, `Settings`, `Shortcode` osztályokat;
  - meghívja a `ChatAKI\Embed\Plugin::init()` metódust.

- `ChatAKI\Embed\Plugin`
  - `init()`:
    - shortcode regisztráció (`Shortcode::register`);
    - frontend asset betöltés, ha szükséges (`enqueue_frontend_assets_if_needed`);
    - admin menü és beállítások regisztrációja (`Settings::register_settings_page`, `Settings::register_settings`).
  - `enqueue_frontend_assets_if_needed()`:
    - csak `is_singular()` esetén és akkor, ha a tartalomban ténylegesen szerepel a `[chataki]` shortcode;
    - Web Component CSS/JS betöltése az adminban megadott URL-ekről;
    - popup keret CSS/JS betöltése a plugin `assets` mappájából.

- `ChatAKI\Embed\Settings`
  - `register_settings_page()` – admin menü pont regisztrálása.
  - `register_settings()` – WordPress Settings API mezők és szekciók regisztrálása.
  - `sanitize_settings()` – bejövő értékek tisztítása (URL-ek, szövegek).
  - `get_settings()` – mentett beállítások lekérése.

- `ChatAKI\Embed\Shortcode`
  - `register()` – `[chataki]` shortcode regisztrálása.
  - `render()` – a shortcode HTML kimenetének előállítása (inline / popup).
  - `build_embed_chat_attributes()` – az `&lt;embed-chat&gt;` attribútumainak felépítése.
  - `build_frame_style()` – keret szélesség/magasság inline CSS formában.
  - `normalize_position()` – pozíció validálása popup módban.
  - `generate_instance_id()` – egyedi ID több widget esetére.

### Asset betöltés

Ha egy oldalon **nincs** `[chataki]` shortcode:

- a bővítmény **nem** tölti be:
  - az `embed-chat.min.css` fájlt;
  - az `embed-chat.min.js` fájlt;
  - a saját popup CSS/JS-t.

Ez segít minimalizálni a felesleges HTTP kéréseket és javítja az oldalbetöltési időt.

---

## Tipikus hibák és elhárításuk

**Hibakeresési gyorstábla**

| Probléma                                        | Tipikus ok                                         | Javasolt lépések röviden                                                |
| ----------------------------------------------- | -------------------------------------------------- | ------------------------------------------------------------------------ |
| Nem jelenik meg semmi a shortcode helyén        | Hiányzó vagy üres `api_url` beállítás             | Ellenőrizd az admin beállításokat vagy add meg `api_url`-t a shortcode-ban. |
| A Web Component nem tölt be                     | Hibás CSS/JS URL vagy CORS / 404 hiba             | Nézd meg a böngésző konzolt, javítsd az URL-eket, ellenőrizd a CORS-t.  |
| reCAPTCHA hibák                                 | Helytelen domain vagy rossz site key konfiguráció | Ellenőrizd a reCAPTCHA adminban a domaint és a kulcsokat, majd az API validációt. |

- **Nem jelenik meg semmi a shortcode helyén**
  - Ellenőrizd, hogy az admin beállításoknál megadtad-e az **API URL-t (`api_url`)**.
  - A `render()` minimálisan ezt az értéket elvárja, különben csak egy HTML kommentet ad vissza.

- **A Web Component nem tölt be**
  - Nézd meg a böngésző konzolt:
    - van-e 404 vagy CORS hiba az `embed-chat.min.js` vagy `embed-chat.min.css` URL-re;
  - ellenőrizd, hogy a megadott URL-ek publikusan elérhetők-e.

- **reCAPTCHA hibák**
  - Győződj meg róla, hogy a site key a megfelelő domainre van konfigurálva a Google admin felületén;
  - ellenőrizd az API oldali validációt.

---

## Függvények részletesen

Ebben a szekcióban osztályonként végigvesszük a fontosabb metódusokat, hogy fejlesztőként gyorsan átlásd, hol érdemes bővíteni vagy belenyúlni.

### `chataki-embed.php`

- **Plugin metaadatok (fejléc)**  
  A fájl tetején található WordPress plugin fejléctömb (Plugin Name, Description, Version, Author, Requires at least, Requires PHP).  
  - Ezt a WordPress olvassa be a bővítmény listázásához.

- **`define('CHATAKI_EMBED_VERSION', '2.0.0');`**  
  - A bővítmény aktuális verziója.  
  - Assetek verziózásához is használjuk (`wp_enqueue_style` / `wp_enqueue_script`), hogy cache-invalidate történjen frissítéskor.

- **`define('CHATAKI_EMBED_PATH', plugin_dir_path(__FILE__));`**  
  - A plugin abszolút könyvtárának elérési útját adja meg (filesystem path).  
  - `require_once` hívásoknál és egyéb fájleléréseknél használatos.

- **`define('CHATAKI_EMBED_URL', plugin_dir_url(__FILE__));`**  
  - A plugin URL-jét határozza meg (HTTP/HTTPS URL).  
  - Assetek (CSS/JS) URL-jének felépítéséhez használjuk.

- **`ChatAKI\Embed\Plugin::init();`**  
  - Belépési pont a namespaced `Plugin` osztályhoz.  
  - Ezen a híváson keresztül kapcsolódik a plugin a WordPress életciklusához (hookok, admin felület, shortcode).

---

### `ChatAKI\Embed\Plugin` osztály

- **`public static function init(): void`**  
  - A plugin fő inicializáló metódusa.  
  - Hookokat regisztrál:
    - `add_action('init', [Shortcode::class, 'register']);`  
      - A WordPress `init` fázisában regisztrálja a `[chataki]` shortcode-ot.
    - `add_action('wp_enqueue_scripts', [self::class, 'enqueue_frontend_assets_if_needed']);`  
      - A frontend script betöltési fázisban gondoskodik a CSS/JS fájlok feltételes betöltéséről.
    - `add_action('admin_menu', [Settings::class, 'register_settings_page']);`  
      - Admin oldalon hozzáad egy menüpontot a **Beállítások** menü alá.
    - `add_action('admin_init', [Settings::class, 'register_settings']);`  
      - A WordPress Settings API segítségével regisztrálja a beállításmezőket.

- **`public static function enqueue_frontend_assets_if_needed(): void`**  
  - Felelős a frontend assetek (CSS/JS) betöltéséért, de **csak akkor**, ha ténylegesen szükség van rájuk.
  - Fő lépések:
    - Ellenőrzi, hogy az aktuális oldal `is_singular()`-e (pl. bejegyzés, oldal).  
      Ha nem, azonnal visszatér, így archívum oldalakon, keresési találatoknál nem terhel fölöslegesen.
    - Lekéri az aktuális `WP_Post` objektumot (`get_post()`), és ellenőrzi, hogy valóban példánya-e a `WP_Post`-nak.
    - Megnézi, hogy a bejegyzés tartalma tartalmazza-e a `[chataki]` shortcode-ot (`has_shortcode($post->post_content, Shortcode::TAG)`).  
      Ha nem, nem tölt be semmilyen assetet.
    - Lekéri a beállításokat (`Settings::get_settings()`), majd:
      - ha `style_src` meg van adva: betölti a Web Component CSS-t (`wp_enqueue_style('chataki-embed-component-style', $styleSrc, ...)`);
      - ha `script_src` meg van adva: betölti a Web Component JS-t (`wp_enqueue_script('chataki-embed-component-script', $scriptSrc, ..., true)` – footerben);
      - mindig betölti a plugin saját popup CSS/JS-ét (`popup.css`, `popup.js`) a `CHATAKI_EMBED_URL` alapján.
  - Ezzel a megoldással a plugin **feltételesen és takarékosan** dolgozik: csak akkor terheli az oldalt, ha valóban használod a chatet.

---

### `ChatAKI\Embed\Settings` osztály

- **`public const OPTION_KEY = 'chataki_embed_settings';`**  
  - Az a kulcs, amely alatt a WordPress `wp_options` táblájában a plugin beállításai tárolódnak.  
  - Ha manuálisan keresed az adatbázisban, ezt a kulcsot keresd.

- **`public static function register_settings_page(): void`**  
  - A **Beállítások → ChatAKI Embed** admin menüpontot regisztrálja.  
  - `add_options_page()` segítségével:
    - beállítja az oldal címét;
    - menüben megjelenő nevet;
    - szükséges jogosultságot (`manage_options`);
    - slugot (`chataki-embed`);
    - a renderelő callbacket (`self::render_settings_page`).

- **`public static function register_settings(): void`**  
  - A WordPress Settings API konfigurációját végzi el.  
  - Fő lépések:
    - `register_setting('chataki_embed_group', self::OPTION_KEY, [...])`  
      - Regisztrál egy beállításcsoportot és a hozzá tartozó opciót;
      - `sanitize_callback`-ként a `self::sanitize_settings` metódust használja, ami mentés előtt megtisztítja az adatokat.
    - `add_settings_section(...)`  
      - Létrehoz egy "ChatAKI Web Component beállítások" szekciót, ahol röviden elmagyarázza a plugin szerepét (a chat logikát maga a Web Component + API végzi).
    - Többször meghívja a `self::add_text_field(...)` segédfüggvényt, amely:
      - egy-egy mezőt regisztrál (CSS URL, JS URL, API URL, stb.);
      - kirajzol hozzá egy `input type="text"` mezőt;
      - mellé hosszabb magyarázó szöveget is ad.

- **`private static function add_text_field(string $key, string $label, string $helpText): void`**  
  - Általános segédfüggvény szöveges beviteli mezők felvételéhez.  
  - `add_settings_field`-et használ:
    - a callback lekéri az aktuális beállításokat (`self::get_settings()`);
    - kiírja az adott kulcshoz tartozó input mezőt;
    - alatta egy max ~820px széles magyarázó szöveget jelenít meg (`$helpText`).
  - Ha új mezőt szeretnél hozzáadni, tipikusan itt (vagy a `register_settings()`-ben a hívás oldalon) kell bővíteni.

- **`public static function sanitize_settings(mixed $input): array`**  
  - Mentéskor **minden beérkező beállítást megtisztít**.  
  - Logika:
    - ha az input nem tömb, üres tömböt ad vissza (véd a hibás form submission ellen);
    - URL mezők (`style_src`, `script_src`, `api_url`): `esc_url_raw` függvényt használ;
    - szöveges mezők (`chat_key`, `widget_title`, `recaptcha_site_key`, `width`, `height`): `sanitize_text_field`-et hív;
    - visszaad egy biztonságos, csak stringeket tartalmazó asszociatív tömböt.
  - Ha új mezőt vezetsz be, itt is gondoskodni kell a megfelelő tisztításról.

- **`public static function get_settings(): array`**  
  - A `get_option(self::OPTION_KEY, [])` függvénnyel lekéri a mentett beállításokat.  
  - Ha a visszakapott érték nem tömb (pl. valamilyen hiba / manuális módosítás miatt), üres tömböt ad vissza.  
  - Ezt a metódust hívják:
    - az admin űrlap mezői (`add_text_field` callbackje);
    - a frontend renderelő logika (`Shortcode::render`, `Plugin::enqueue_frontend_assets_if_needed`).

---

### `ChatAKI\Embed\Shortcode` osztály

- **`public const TAG = 'chataki';`**  
  - A shortcode neve.  
  - Ha a későbbiekben más tagre szeretnél váltani, ezt a konstansot kell módosítani (és a dokumentációt frissíteni).

- **`private const ALLOWED_POSITIONS = [...]`**  
  - A popup módnál engedélyezett pozíciók listája (`right-top`, `right-middle`, stb.).  
  - A `normalize_position()` metódus csak ezeket fogadja el érvényesnek.

- **`public static function register(): void`**  
  - `add_shortcode(self::TAG, [self::class, 'render']);` hívást tartalmaz.  
  - Ezzel köti össze a `[chataki]` shortcode-ot a `render()` metódussal.  
  - A `Plugin::init()`-ből hívódik meg az `init` hook alatt.

- **`public static function render(array $atts): string`**  
  - A shortcode HTML kimenetét állítja elő.  
  - Fő lépések:
    1. Lekéri az admin beállításokat (`Settings::get_settings()`).
    2. Összeállít egy alapértelmezés-készletet (`$defaults`), amely tartalmazza:
       - Web Component attribútumokat (`api_url`, `chat_key`, `widget_title`, `recaptcha_site_key`);
       - keret méretét (`width`, `height`);
       - megjelenítési módot (`mode`, `position`, `default_open`, `launcher_label`).
    3. A `shortcode_atts()` segítségével egyesíti a felhasználó által megadott attribútumokat az alapértelmezésekkel.
    4. Ellenőrzi, hogy az **`api_url`** nem üres-e.  
       - Ha üres, nem jelenít meg chatet, csak egy HTML kommentet ad vissza (segít hibakeresésnél, és nem tör meg semmilyen layoutot).
    5. Normalizálja a `mode`, `position`, `default_open` értékeket.
    6. Generál egy egyedi instance ID-t (`generate_instance_id()`).
    7. Felépíti az `&lt;embed-chat&gt;` attribútumait (`build_embed_chat_attributes()`), illetve a keret stílusát (`build_frame_style()`).
    8. Ha `mode !== 'popup'`:
       - egy egyszerű inline `div`-et ad vissza, benne az `&lt;embed-chat&gt;` elemmel.
    9. Ha `mode === 'popup'`:
       - egy teljes popup struktúrát ad vissza:
         - launcher gomb (ikon + felirat);
         - `div.chataki-window` dialógus fejléccel (cím, bezáró gomb) és törzssel (`embed-chat`).

- **`private static function build_embed_chat_attributes(array $a): string`**  
  - Az `&lt;embed-chat&gt;` tag HTML attribútumait állítja össze.  
  - Kimenet: pl. ` api-url="..." chat-key="..." widget-title="..." [recaptcha-site-key="..."]`  
  - Minden értéket esc-el (`esc_url`, `esc_attr`), így biztonságos a HTML-be írás.

- **`private static function build_frame_style(string $width, string $height): string`**  
  - Egyszerű inline CSS deklarációt ad vissza: `width:...; height:...;`.  
  - A külső keret méretét határozza meg, hogy a Web Componentnek mekkora hely jusson.

- **`private static function normalize_position(string $position): string`**  
  - Lowercase + trim után ellenőrzi, hogy a megadott pozíció szerepel-e az `ALLOWED_POSITIONS` tömbben.  
  - Ha nem, visszaadja az alapértelmezett `right-bottom` értéket.  
  - Így elkerülhető, hogy hibás pozíciót átadva széteső layoutot kapjunk.

- **`private static function generate_instance_id(): string`**  
  - Egyedi HTML ID-t generál minden shortcode példányhoz.  
  - Formátum: `chataki_` + 10 karakteres hash részlet (`md5(uniqid('', true))`).  
  - Lehetővé teszi, hogy egy oldalon több külön ChatAKI widget is legyen egymás zavarása nélkül.

