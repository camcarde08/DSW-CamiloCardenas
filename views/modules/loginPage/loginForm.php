 <link rel="stylesheet" href="views/jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="views/jqwidgets/scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="views/jqwidgets/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="views/jqwidgets/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="views/jqwidgets/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="views/jqwidgets/jqwidgets/jqxvalidator.js"></script>
    <script type="text/javascript" src="views/jqwidgets/scripts/demos.js"></script>
   


     <style type="text/css">
        .demo-iframe {
            border: none;
            width: 600px;
            height: 200px;
            clear: both;
            display: none;
        }
        .form #password, .form #username {
            height: 24px;
            margin-top: 5px;
            width: 150px;
        }
        
        .prompt {
            margin-top: 10px; font-size: 10px;
        } 
    </style>

    <script type="text/javascript">
        $(document).ready(function () {
            
            $("#username, #password").addClass('jqx-input');
            if (theme != '') {
                $("#username, #password").addClass('jqx-input-' + theme);
            }
            
            $("#loginButton").jqxButton({theme: theme});

            // add validation rules.
            $('#form').jqxValidator({
                rules: [
                       { input: '#username', message: 'El nombre de usuario es requerido!', action: 'keyup, blur', rule: 'required' },
                       { input: '#username', message: 'El usuario debe inciar con una letra!', action: 'keyup, blur', rule: 'startWithLetter' },
                       { input: '#username', message: 'El usurio debe tener una logitud entre 3 y 12 catacteres!', action: 'keyup, blur', rule: 'length=3,12' },
                       { input: '#password', message: 'La contraseña es requerida!', action: 'keyup, blur', rule: 'required' },
                       { input: '#password', message: 'Su contraseña debe tener una logitud entre 3 y 12 caracteres!', action: 'keyup, blur', rule: 'length=4,12' }
                ]
                       
            });
            // validate form.
            $("#loginButton").click(function () {
                $('#form').jqxValidator('validate');
            });

            $("#form").on('validationSuccess', function () {
                $("#form-iframe").fadeIn('fast');
            });
        });
    </script>

    <div style="height: 219px; display: block; font-size: 13px; font-family: Verdana; margin-top: 100px; margin-left: 150px; border-style: solid; border: 0">
        <form class="form" id="form"  method="post" action="index.php" style="width: 650px;border-style: solid; border: 0">
            
            <label>Usuario:</label>
            <div>
                <input type="text" id="username" name="username" value="<?php echo $_POST['username']; ?>"/>
            </div>
            <label>Contraseña:</label>
            <div>
                <input type="password" id="password" name="password" />
            </div>
            <p>
            <div>
                <input id="loginButton" type="submit" value="Ingresar" />
            </div>
        </form>
        #MENSAGE_LOG#
        <iframe id="form-iframe" name="form-iframe" class="demo-iframe" frameborder="0"></iframe>
    </div>
