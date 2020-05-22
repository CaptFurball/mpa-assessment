How to run the project?

1. Set the web root in nginx config to point to mpa-assessment/code
2. Update mpa-assessment/code/application/config/database.php for MySQL username and password
3. Run in MySQL `create database mpa`
4. Run the migration `php index.php migrate`
5. Create mpa-assessment/code/sessions folder and give permission 755
6. Give permission 755 to mpa-assessment/code/application/logs folder

NOTES:
1.  I was unable to get my mailtrap to work in my environment for some reason, hence the email verification portion will need to be done manually.

    For email verification please refer to the `mpa.verify` table in the database.
    There are 2 types of verification:
        - account activation
        - password reset

    To manually verify account activation
        -   find the token under `mpa.verify` table in `code` column for the email that you have registered where `callback` column in 'activate_account'
        -   or use query "select code from mpa.verify where email='<your-email>' and callback='activate_account'"
        -   Hit http://localhost/auth/register/verify/<the-token-code-from-verify-table>

    To manually verify password reset 
        -   find the token under `mpa.verify` table in `code` column for the email that you have requested pw reset where `callback` column is 'reset_pasword'
        -   or use query "select code from mpa.verify where email='<your-email>' and callback='reset_password'"
        -   Hit http://localhost/auth/register/verify/<the-token-code-from-verify-table>

2.  Note that I have created a library called Auth which contains Auth and Email_Verification class. These are intended to be the "service" layer of the MVC framework as I have delegated controllers to only do form validation and invoking services when needed.

3. Note that I have extended the CI_Controller class to MY_Controller. All controllers which requires authenticated access will have to extend from MY_Controller as there is an additional authentication check. This is because CI does not have middlewares and hence I do the checking this way. The same can be done using hooks in CI3 using pre-controller hooks but I have chose this implementation for time being.

4. Note that users have 5 retries before their account will be reverted into inactive. Currently there is no implementation to reactivate an account.

5. Note that all forms have their own validation

6. Note that this system will have migrations, to avoid passing around mysqldumps

7. I have added Email_Verification.php class but it does not serve any purpose. Was testing a theory.