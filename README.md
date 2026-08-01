# ÉPKŐ Mini CMS

> A custom-built PHP 8.2 Content Management System and multilingual one-page portfolio website developed for the Hungarian natural stone and architectural stonework company ÉPÜLET-KŐFARAGÓ Kft.

---
Highlights
---


• Custom authentication
• CSRF protection
• PDO
• MVC-inspired architecture
• Bootstrap 5 frontend
• Multilingual-ready database
• Gallery management
• Category management
• Production deployment
---

## Project Overview

The purpose of the project is to replace the company's outdated static website with a modern, maintainable and scalable content management system that allows non-technical users to manage portfolio references, categories and multilingual content through an administrative interface.

The system has been designed specifically for companies operating in architectural stonework, monument renovation and bespoke natural stone construction projects.

The frontend follows a one-page portfolio approach, while the backend provides a modular administration panel for content management.

---

## About the Company

ÉPÜLET-KŐFARAGÓ Kft. is one of Hungary's long-standing companies in the decorative and architectural stone industry.

The company's professional predecessor dates back to 1948 and the current organisation was established in 1996 following the privatisation of the former state-owned enterprise.

Main activities include:

* Natural stone processing
* Architectural stonework
* Traditional stone carving
* Stone sculpture
* Interior and exterior stone cladding
* Monument building renovation works
* Technical design and planning
* Natural stone import and supply
* Custom stone manufacturing
* Industrial stone processing

Notable references include:

* Halászbástya (Fisherman's Bastion)
* National Theatre of Hungary
* Hungarian Parliament Building
* Sándor Palace
* Hungarian National Museum
* Numerous metro stations and public buildings
* Monument renovation projects throughout Hungary

---

## Project Goals

The project has been designed with the following objectives:

* Modernise the company's online presence.
* Replace the outdated HTML-based website.
* Provide a secure administration panel.
* Enable easy management of reference works.
* Prepare the system for multilingual content.
* Deliver a lightweight and maintainable PHP architecture.
* Create a responsive one-page frontend.
* Prepare the project for future scalability.

---

## Technology Stack

### Backend

* PHP 8.2
* PDO
* MySQL 8
* Composer
* PSR-4 Autoloading
* vlucas/phpdotenv

### Frontend

* Bootstrap 5
* Vanilla JavaScript
* Custom CSS

### Architecture

* Modular MVC-like structure
* Singleton database connection
* CSRF protection
* Authentication system
* Session-based administration panel

---

## Current Project Structure

```text
app/
public/
resources/
sql/
storage/
vendor/
```

### Core Components

```text
app/Core/

Auth.php
Bootstrap.php
Csrf.php
Database.php
```

Responsible for:

* Authentication
* Application bootstrap
* Database management
* Security mechanisms
* Session handling

---

### Models

```text
app/Models/

User.php
Category.php
GalleryImage.php
```

Responsible for:

* User management
* Gallery categories
* Reference image management
* Future multilingual support

---

### Administration Panel

```text
public/admin/
```

Implemented pages:

```text
dashboard.php

gallery.php
gallery-edit.php
gallery-delete.php
upload.php

categories.php
category-create.php
category-edit.php
category-delete.php

login.php
logout.php
```

The administration panel allows:

* Secure login
* Category management
* Reference image uploads
* Reference editing
* Image deletion
* Gallery statistics
* Future translations management
* Future settings management

---

## Security Features

Implemented security measures include:

### Authentication

* Session based authentication
* Route protection
* Login requirements

### CSRF Protection

The project includes a custom-built CSRF implementation.

Features:

* Token generation
* Token validation
* Token regeneration
* Token destruction
* Hidden form helpers

### Database Security

* Prepared statements
* PDO exception handling
* Strict typing
* Singleton database connection

### PHP Standards

* strict_types declarations
* Typed properties
* Return type declarations

---

## Gallery System

The gallery has been designed as a professional reference management system rather than a traditional image gallery.

Each reference may contain:

* Category
* Title
* Description
* Alt text
* Image
* Display order

The frontend displays the references as architectural portfolio projects.

Future improvements may include:

* Multiple images per project
* SEO metadata
* Reference locations
* Project completion dates
* PDF attachments

---

## Category System

Current category structure supports:

```sql
categories
```

with:

* name
* slug
* sort_order
* is_active
* created_at
* updated_at

Translations are stored separately:

```sql
category_translations
```

Planned languages:

* Hungarian
* English
* Italian
* Spanish
* Chinese

The multilingual architecture has been implemented from the beginning to avoid future database redesign.

---

## One-Page Frontend

Implemented sections:

```text
Hero

About

References

Contact

Footer
```

Navigation:

```text
Home
Company
References
Contact
```

Design goals:

* Elegant
* Lightweight
* Professional
* Responsive
* SEO-friendly
* Easy to maintain

---

## Frontend Philosophy

The website intentionally avoids excessive animations and marketing-oriented design trends.

The primary focus is:

* Architectural photography
* Professional references
* Company history
* Technical expertise
* Natural stone craftsmanship

The references themselves are intended to communicate the company's capabilities.

---

## Assets

```text
public/assets/

css/
js/
images/
```

Implemented:

```text
frontend.css
frontend.js

admin.css
admin.js
```

Features include:

* Smooth scrolling
* Responsive layout
* Sticky navigation
* Card hover effects
* Lazy image loading
* Bootstrap modal support
* Mobile navigation improvements
* Back-to-top button support

---

## Upload System

Current implementation:

```text
public/uploads/

gallery/
```

Future support:

```text
gallery/
thumbnails/
documents/
pdf/
```

Uploads are prepared for:

* Portfolio references
* Project images
* Documentation
* Future downloadable materials

---

## Database

Current SQL files:

```text
sql/

schema.sql
seed.sql
```

The project follows a database-first approach.

Planned additions include:

```text
settings
gallery_translations
messages
seo_metadata
```

---

## Development Timeline

### Phase 1

Project foundation:

* Composer setup
* Environment configuration
* Database architecture
* Bootstrap process

Completed.

---

### Phase 2

Security implementation:

* Authentication
* Session handling
* CSRF protection
* Protected routes

Completed.

---

### Phase 3

Administration panel:

* Dashboard
* Categories
* Gallery management
* Upload system

Completed.

---

### Phase 4

Frontend implementation:

* One-page layout
* Responsive design
* Gallery presentation
* Contact section

Completed.

---

### Phase 5

Multilingual preparation:

* Translation tables
* Database architecture
* Frontend planning

Completed.

---

### Phase 6

Future development:

Planned:

* Gallery translations
* Settings module
* Category filtering
* SEO management
* Production deployment
* Image optimisation
* Performance improvements

---

## Milestones

### v0.1.0

Initial MVP completed.

Implemented:

* CMS architecture
* Authentication system
* CSRF protection
* Gallery management
* Category management
* One-page frontend
* Responsive layout
* Multilingual-ready database design
* Modular project structure

---

## Roadmap

### v0.2.0

Planned:

* Settings module
* Translation management
* Category filtering
* SEO improvements

---

### v0.5.0

Planned:

* Production deployment
* Content migration
* Performance optimisation

---

### v1.0.0

Planned:

* Stable release
* Fully multilingual content support
* Production-ready administration panel
* Complete reference portfolio implementation

---

## Installation

Clone the repository:

```bash
git clone <repository-url>
```

Install dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

Import the database:

```text
sql/schema.sql
```

Configure:

```text
DB_HOST
DB_PORT
DB_DATABASE
DB_USERNAME
DB_PASSWORD
```

Start Apache and MySQL and visit:

```text
http://localhost/epko-mini-cms/public
```

---

## Requirements

* PHP 8.2+
* MySQL 8+
* Apache
* Composer
* XAMPP or Laragon

---

## Development Notes

This project has intentionally been developed without using a full-stack PHP framework.

The goal is to demonstrate:

* Software architecture design
* Secure PHP development practices
* Database modelling
* Content management system development
* Responsive frontend implementation
* Modular application design
* Clean and maintainable code organisation

The project serves both as a real-world client solution and as a portfolio piece demonstrating full-stack PHP development skills.

---

## License

This project is released under the terms specified in the accompanying LICENSE file.

---

## Author

Developed by:

**Lukács Károly**

Custom PHP CMS & One-Page Portfolio Website for ÉPÜLET-KŐFARAGÓ Kft.

Built with PHP 8.2, MySQL and Bootstrap 5.
