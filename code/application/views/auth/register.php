<html>
    <head></head>
    <body>
        <?= $this->session->flashdata('error');?>
        <?= $this->session->flashdata('success');?>

        <form method="POST" action="/auth/register">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?= set_value('username'); ?>"><br><br>
            <?php echo form_error('username'); ?>

            <label for="username">Email:</label>
            <input type="text" name="email" value="<?= set_value('email'); ?>"><br><br>
            <?php echo form_error('email'); ?>

            <label for="password">Password:</label>
            <input type="text" name="password" value="<?= set_value('password'); ?>"><br><br>
            <?php echo form_error('password'); ?>

            <label for="password">Confirm Password:</label>
            <input type="text" name="confirm_password" value="<?= set_value('confirm_password'); ?>"><br><br>
            <?php echo form_error('confirm_password'); ?>

            <input type="submit" value="Submit">
        </form>
    </body>
</html>