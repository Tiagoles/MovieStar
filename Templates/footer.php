<footer id="footer">
    <div id="social-container">
        <ul>
            <li class="social">
                <a href="https://github.com/Tiagoles">
                    <i class="fa-brands fa-github color-dark"></i>
                </a>
            </li>
            <li class="social">
                <a href="https://www.linkedin.com/in/tiago-damasceno/">
                    <i class="fa-brands fa-linkedin"></i>
                </a>
            </li>
        </ul>
    </div>
    <div id="footer-links-container">
        <ul>
            <?php
            if ($UserData == true) {
            ?>
                <li class="otherPages">
                    <a href="<?= $BASE_URL ?>newMovie.php">Adicionar filme</a>
                </li>
                <li class="otherPages">
                    <a href="<?= $BASE_URL ?>editProfile.php">Meu perfil</a>
                </li>
            <?php
            } else { ?>
                <li class="otherPages">
                    <a href="<?= $BASE_URL ?>newMovie.php">Adicionar filme</a>
                </li>
                <li class="otherPages">
                    <a href="<?= $BASE_URL ?>auth.php">Entrar / Registrar</a>
                </li>
            <?php
            } ?>

        </ul>
    </div>
    <p>Moviestar &copy; 2023 Tiago Damasceno</p>
</footer>

</html>