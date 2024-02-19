# confettiSocial
an experiment with activity pub and php

### tech:
- PHP 8.1+
- MariaSQL database
  
# This is a WIP! Started on FEB 16 2024

### MINIMAL REQUIREMENTS:

- [x] php form and database connection
- [x] HTML support
- [ ] activity pub implementation to read the message
- [ ] activity pub implementation to like the message
- [ ] activity pub implementation to follow other users
- [ ] "" to see users posts from other federated instances

### FUTURE IDEAS:

- notifications via email?
- images support
  
### TO TEST:

- Make sure you update `db_connection.php` with your own database information.
- Also use `tables.sql` file for the tables.

- Feel free to customize the theme by just changing the root colors under `/assets/css/estilo.css`:
```css
:root {
    --dark: #222222;
    --light: #ffffff;
    --primary: #ff018d;
    --secondary: #ed65ff;
    --body-fonts: "Lora", serif;
    --header-fonts: "Lora", serif;
...
```

- To use the registration form, just rename it to .php, but I sugest you also put it back to temp if not using. At least until I figure out a configuration file to turn it on and off.
