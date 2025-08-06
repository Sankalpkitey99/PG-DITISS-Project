    <?php if (isLoggedIn()): ?>
        <p>Logged in as <?= htmlspecialchars($_SESSION['username']) ?> | 
           <a href="../users/logout.php">Logout</a></p>
    <?php endif; ?>
</div>
</body>
</html>
