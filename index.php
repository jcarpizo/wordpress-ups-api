<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 11 Template</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


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
        <form action="http://localhost/wordpress/index.php/wp-json/ups/v1/shipment" method="post">
            <div class="col-md-6">
                <div class="form-group">
                    <label>To Address Line 1</label>
                    <input type="text" class="form-control" name="toaddress_one" value="405 Slide Road">
                </div>
                <div class="form-group">
                    <label>To Address Postal Code</label>
                    <input type="text" class="form-control" name="toaddress_postal_code" value="79416">
                </div>
                <div class="form-group">
                    <label>To Address City</label>
                    <input type="text" class="form-control" name="toaddress_city" value="LUBBOCK" >
                </div>
                <div class="form-group">
                    <label>To Address Province State Code</label>
                    <input type="text" class="form-control" name="toaddress_province_code" value="TX">
                </div>
                <div class="form-group">
                    <label>To Address Country Code</label>
                    <input type="text" class="form-control" name="toaddress_country_code" value="US">
                </div>
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" class="form-control" name="tocompany_name" value="Test Company">
                </div>
                <div class="form-group">
                    <label>Company Email Address</label>
                    <input type="text" class="form-control" name="toaddress_email" value="jasper.carpizo.dev@gmail.com">
                </div>
                <div class="form-group">
                    <label>Company Phone</label>
                    <input type="text" class="form-control" name="toaddress_phone_number" value="(806) 722-4032">
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>