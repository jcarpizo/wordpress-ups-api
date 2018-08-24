<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 11 Template</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
<body>

<div class="container">
    <br/>
    <div class="row">

        <form method="post">
            <div class="col-md-6">
                <div class="alert alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <div class="form-group">
                    <label>To Address Line 1</label>
                    <input type="text" class="form-control" name="toaddress_one" value="405 Slide Road" required>
                </div>
                <div class="form-group">
                    <label>To Address Postal Code</label>
                    <input type="text" class="form-control" name="toaddress_postal_code" value="79416" required>
                </div>
                <div class="form-group">
                    <label>To Address City</label>
                    <input type="text" class="form-control" name="toaddress_city" value="LUBBOCK" required>
                </div>
                <div class="form-group">
                    <label>To Address Province State Code</label>
                    <input type="text" class="form-control" name="toaddress_province_code" value="TX" required>
                </div>
                <div class="form-group">
                    <label>To Address Country Code</label>
                    <input type="text" class="form-control" name="toaddress_country_code" value="US" required>
                </div>
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" class="form-control" name="tocompany_name" value="Test Company" required>
                </div>
                <div class="form-group">
                    <label>Company Email Address</label>
                    <input type="text" class="form-control" name="toaddress_email" value="jasper.carpizo.dev@gmail.com" required>
                </div>
                <div class="form-group">
                    <label>Company Phone</label>
                    <input type="text" class="form-control" name="toaddress_phone_number" value="(806) 722-4032" required>
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-primary btn-block" id="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
<script>
   $('#submit').click(function () {
       var $btn = $(this).button('loading');
       $.post("https://godigitalape.com/wp-json/ups/v1/shipment",
           {
               toaddress_one: $("input[name=toaddress_one]").val(),
               toaddress_postal_code: $("input[name=toaddress_postal_code]").val(),
               toaddress_city: $("input[name=toaddress_city]").val(),
               toaddress_province_code: $("input[name=toaddress_province_code]").val(),
               toaddress_country_code: $("input[name=toaddress_country_code]").val(),
               tocompany_name: $("input[name=tocompany_name]").val(),
               toaddress_email: $("input[name=toaddress_email]").val(),
               toaddress_phone_number: $("input[name=toaddress_phone_number]").val(),
           })
           .done(function (data) {
               $('.alert').text(data.message).addClass('alert-success');
               $btn.button('reset')
           })
           .fail(function (error) {
               $('.alert').text('Error').addClass('alert-warning');
               $btn.button('reset')
           });
   });
</script>

</body>
</html>