# Implementation Plan - Felhasználó Hozzáadása & Kezelése Modul

Az új funkció célja egy teljes körű felhasználó-kezelő modul hozzáadása az **EPKO Mini CMS** adminisztrációs felületéhez. A felhasználó hozzáadása menüpont elérhető lesz a dashboardon és a sidebar navigációban is, a rögzített adatok pedig biztonságosan (hashelt jelszóval, CSRF védelemmel, érvényesítésekkel) kerülnek az adatbázisba (`users` tábla).

## Új és módosítandó komponensek

### 1. Modell kibővítése
#### [MODIFY] [User.php](epko-mini-cms/app/Models/User.php)
- `findByName(string $name)` metódus hozzáadása a meglévő `findByEmail`, `findById`, `create`, `all`, `delete` metódusok mellé a név szerinti egyediség ellenőrzéséhez.
- `count(): int` metódus hozzáadása az összes felhasználó számának lekérdezéséhez.

### 2. Adminisztrációs felület és Navigáció
#### [MODIFY] [sidebar.php](epko-mini-cms/public/admin/partials/sidebar.php)
- Új "Felhasználók" és "Új felhasználó" menüpontok felvétele a navigációs sávba a *Rendszer* szekció alá (`users.php`, `user-create.php`).

#### [MODIFY] [dashboard.php](epko-mini-cms/public/admin/dashboard.php)
- Gyorsgomb / kártya hozzáadása az új felhasználó létrehozásához ("Új felhasználó hozzáadása") és az meglévő felhasználók megtekintéséhez.
- Statisztikai kártya frissítése (vagy új kártya hozzáadása) az regisztrált felhasználók számára.

### 3. Új felületek és logika
#### [NEW] [users.php](epko-mini-cms/public/admin/users.php)
- Regisztrált felhasználók listázása (ID, Név, E-mail, Szerepkör, Létrehozás dátuma).
- "+ Új felhasználó" gomb a felület tetején.
- Törlési akció megerősítő párbeszédablakkal (saját fiók törlésének megakadályozásával).
- Sikeres / sikertelen műveleti üzenetek megjelenítése (alert-success / alert-danger).

#### [NEW] [user-create.php](epko-mini-cms/public/admin/user-create.php)
- Űrlap új felhasználó adatainak megadásához:
  - **Felhasználónév** (`name`) - kötelező, max 50 karakter, egyedi.
  - **E-mail cím** (`email`) - kötelező, érvényes email formátum, max 100 karakter, egyedi.
  - **Jelszó** (`password`) - kötelező, min. 6 karakter.
  - **Jelszó megerősítése** (`password_confirm`) - egyeznie kell a jelszóval.
  - **Szerepkör** (`role`) - adminisztrátor.
- **CSRF védelem**: `Csrf::validateToken($_POST['_token'])` és `Csrf::inputField()`.
- **Jelszó hashelés**: `password_hash($password, PASSWORD_DEFAULT)` a `User::create()` metóduson keresztül (az adatbázisban a hashelt érték tárolódik, plain-text jelszó soha nem mentődik).
- Validációs hibák (pl. már létező e-mail/név, nem egyező jelszavak) visszajelzése Bootstrap alert-ben.
- Sikeres mentés után átirányítás a `users.php?success=created` oldalra.

#### [NEW] [user-delete.php](epko-mini-cms/public/admin/user-delete.php)
- Felhasználó törlésének feldolgozása CSRF/ID ellenőrzéssel. Saját bejelentkezett fiók törlése letiltott.

---

## Ellenőrzési terv

### Automatikus / Kódszintű ellenőrzés
- Szintaxis ellenőrzése PHP CLI használatával (`php -l`).

### Manuális tesztelés
1. Navigálás az admin dashboardra és a sidebar menüpontokra (`users.php`, `user-create.php`).
2. Új felhasználó létrehozása érvényes adatokkal -> Ellenőrzés, hogy a jelszó hashelve került-e az adatbázisba (`users` tábla).
3. Hibaágak tesztelése:
   - Hiányzó mezők.
   - Már meglévő felhasználónév vagy e-mail.
   - Nem egyező jelszó megerősítés.
   - Érvénytelen CSRF token.
4. Újonnan létrehozott felhasználóval történő bejelentkezés tesztelése a `login.php` oldalon.
