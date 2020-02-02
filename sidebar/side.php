<!Doctype html>
    <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" type="image/jpg" href="../img/tetra.jpg">
            <style>


                #sidebar
                {
                    position:fixed;
                    width:100px;
                    height:50%;

                    background: #e7490faf;
                    left:-200px;
                    transition: all 500ms linear;
                    z-index: 1;
                    border-radius: 0px 15px 15px 0px;

                }

                #sidebar.active
                {
                    left:0px;

                }

                #sidebar ul li
                {
                    color: #fff;
                    list-style-type: none;
                    padding:15px 10px;
                    border-bottom: 1px solid rgba(100, 100, 100, 0.3);

                }

                #sidebar .toggle-btn
                {
                    position:absolute;
                    left:230px;
                    top:20px;
                }

                #sidebar .toggle-btn span
                {
                    display: block;
                    width:30px;
                    height:5px;
                    background: #e7480f;
                    margin:3px 0px;
                }
            </style>
        </head>
        <body>

        <div id="sidebar">
            <div class="toggle-btn" onclick="toggleSidebar()">
                <span></span>
                <span></span>
                <span></span>

            </div>
            <ul>
                <li></li>
                <li></li>
                <li></li>


            </ul>
        </div>





           <!-- <script src="..vendor/jquery/jquery-3.2.1.js"></script>
            <script src="..vendor/bootstrap/js/bootstrap.js"></script>
            <script src="..vendor/bootstrap/js/tooltip.js"></script>
            <script src="..vendor/bootstrap/js/popper.js"></script> -->
            <script>

                function toggleSidebar(){

                    document.getElementById("sidebar").classList.toggle('active');
                    disapear();

                }
            </script>
        </body>




    </html>