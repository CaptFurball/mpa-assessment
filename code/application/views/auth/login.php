<html>
    <head></head>
    <body>
        <?= $this->session->flashdata('error');?>

        <form method="POST" action="/auth/login">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?= set_value('username'); ?>"><br><br>
            <?php echo form_error('username'); ?>

            <label for="password">Password:</label>
            <input type="text" name="password" value="<?= set_value('password'); ?>"><br><br>
            <?php echo form_error('password'); ?>

            <input type="submit" value="Submit">
        </form>
    </body>
</html>