<?php
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}
?>
<footer>
    <p>&copy; Dominic Hart <?php echo date("Y"); ?></p>
</footer>
<script src="js/bootstrap.min.js"></script>
<script src="js/affix.js"></script>
<script src="js/modal.js"></script>
<script src="js/ajax.js"></script>
<script src="js/accordion.js"></script>
<script src="js/wordcount.js"></script>
</body>
</html>