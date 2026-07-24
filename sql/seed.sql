-- ----------------------------------------------------
-- Categories
-- ----------------------------------------------------

INSERT INTO categories (name) VALUES
('Homlokzatok'),
('Műemlék restaurálás'),
('Kőburkolatok'),
('Belsőépítészet');


-- ----------------------------------------------------
-- Pages
-- ----------------------------------------------------

INSERT INTO pages (title, content) VALUES

(
'Rólunk',
'Az ÉPKŐ Kft. több mint 30 éves tapasztalattal rendelkezik a természetes kövek feldolgozásában, homlokzatburkolatok készítésében és műemléki restaurálási munkákban.'
),

(
'Szolgáltatásaink',
'Kőburkolatok, homlokzatképzés, műemléki restaurálás, egyedi kőfaragó munkák és kivitelezés.'
),

(
'Kapcsolat',
'Vegye fel velünk a kapcsolatot telefonon vagy az oldalon található kapcsolatfelvételi űrlapon keresztül.'
);


-- ----------------------------------------------------
-- Settings
-- ----------------------------------------------------

INSERT INTO settings (setting_key, setting_value) VALUES

('company_name', 'ÉPKŐ Kft.'),
('company_email', 'info@epko.hu'),
('company_phone', '+36 00 000 0000'),
('company_address', 'Budapest, Magyarország'),

('hero_title', 'Kőburkolatok és műemléki restaurálás'),
('hero_subtitle', 'Több mint 30 év szakmai tapasztalat'),

('hero_button_text', 'Kapcsolat'),
('gallery_title', 'Referenciáink'),
('services_title', 'Szolgáltatásaink'),
('about_title', 'Rólunk'),

('facebook_url', ''),
('instagram_url', ''),
('linkedin_url', ''),

('site_installed', 'false');;