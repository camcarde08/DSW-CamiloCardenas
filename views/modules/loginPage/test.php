<!DOCTYPE html>
<html lang="en">
<head>
    <title id='Description'>The sample demonstrates how to center the menu items.</title>
    <link rel="stylesheet" href="../../jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="../../jqwidgets/jqwidgets/styles/sgm1personal.css" type="text/css" />
    <script type="text/javascript" src="../../jqwidgets/scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="../../jqwidgets/scripts/demos.js"></script>
    
     <script type="text/javascript">
        $(document).ready(function () {
            // create jqxCheckBox.
            $("#jqxcheckbox").jqxCheckBox({ width: 120, height: 25 });
            // bind to change event.
           
        });
    </script>
</head>
<body class='default'>
    <div id='jqxcheckbox'>
        Click me</div>
    <div id='log'>
    </div>
</body>
</html>