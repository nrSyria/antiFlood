<!DOCTYPE html>
<html dir="rtl">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <title>Page</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <div style="text-align:center; line-height:1.5em">
            <input id="btnCode" type="button" onclick="getCode()" value="click to get new code" />
            <div id="genCode"></div>
            <div id="codeAsking"></div>


        </div>
        <script>
            function getCode() {
                $.ajax({url: 'code.php?op=start',
                    type: 'get',
                    success: function (output) {
                        $('#btnCode').hide();
                        $('#codeAsking').html(output);                       
                    },
                    error: function (output) {
                        $('#btnCode').hide();
                        $('#codeAsking').html('error relode page..');                        
                    },
                });
            }

        </script>
    </body>
</html>
