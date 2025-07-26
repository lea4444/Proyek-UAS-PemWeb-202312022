<?php
session_start();
unset($_SESSION['cart']);
echo "Keranjang berhasil dikosongkan.";
