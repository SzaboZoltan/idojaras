## ChatAKI Embed (Web Component) – WordPress bővítmény

A **ChatAKI Embed** egy könnyen használható WordPress bővítmény, amely a ChatAKI `&lt;embed-chat&gt;` Web Componentet ágyazza be az oldaladra. 
Két fő megjelenítési módot támogat:

- **Inline mód**: a chat közvetlenül a tartalomban jelenik meg.
- **Popup mód**: a képernyő egyik sarkában felugró, ikonról nyitható chat ablak.

Az aktuális verzió: **2.0.0**

---

### Fő funkciók

- **Shortcode alapú beágyazás**: `[chataki]` – inline vagy popup módban.
- **Okos asset betöltés**:
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

## Licenc és szerzői jog

- **Szerző**: ChatAKI
- A bővítmény forráskódja a ChatAKI belső projektjeként készült.  
  Ha nyílt forrásúvá vagy publikussá teszed, egészítsd ki ezt a szekciót a választott licenccel (pl. MIT, GPLv2+).

