How to run the project?

1. Set the web root in nginx config to point to mpa-assessment/code
2. Update mpa-assessment/code/application/config/database.php for MySQL username and password
3. Run in MySQL `create database mpa`
4. Run the migration `php index.php migrate`
5. Create mpa-assessment/code/sessions folder and give permission 755
6. Give permission 755 to mpa-assessment/code/application/logs folder
