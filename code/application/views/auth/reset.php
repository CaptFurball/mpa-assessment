<html>
    <head></head>
    <body>
        <?= $this->session->flashdata('temporary_password');?>

        <form method="POST" action="/auth/login/reset">
            <label for="username">Email:</label>
            <input type="text" name="email" value="<?= set_value('email'); ?>"><br><br>
            <?php echo form_error('email'); ?>

            <input type="submit" value="Submit">
        </form>
    </body>
</html>