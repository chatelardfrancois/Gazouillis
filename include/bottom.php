<footer>
    <div>
        <script>
            function GoToHomePage(){
                window.location = 'index.php';
            }
        </script>
        <i onclick="GoToHomePage()" <?= (($_SERVER['REQUEST_URI'] === "/Gazouillis/index.php") or ($_SERVER['REQUEST_URI'] === "/Gazouillis/")) ? "style='color:rgb(29, 161, 242);'" : "" ?>class="fas fa-home"></i>
        <i class="fas fa-search"></i>
        <i class="far fa-envelope"></i>
    </div>
</footer>
</body>



</html>