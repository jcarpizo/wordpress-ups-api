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
                    <label>Shipper Name</label>
                    <input type="text" class="form-control" name="shipment_name" value="Digital Ape Dental Lab" readonly>
                </div>
                <div class="form-group">
                    <label>Shipper Attention Name</label>
                    <input type="text" class="form-control" name="shipment_attention_name" value="Digital Ape Full Arch Solutions" readonly>
                </div>
                <div class="form-group">
                    <label>Shipper Address</label>
                    <input type="text" class="form-control" name="shipment_address" value="1918 University Business Drive" readonly>
                </div>
                <div class="form-group">
                    <label>Shipper Postal Code</label>
                    <input type="text" class="form-control" name="shipment_postal_code" value="75071" readonly>
                </div>
                <div class="form-group">
                    <label>Shipper City</label>
                    <input type="text" class="form-control" name="shipment_city" value="MCKINNEY" readonly>
                </div>
                <div class="form-group">
                    <label>Shipper Province State Code</label>
                    <input type="text" class="form-control" name="shipment_province_code" value="TX" readonly>
                </div>
                <div class="form-group">
                    <label>Shipper Country Code</label>
                    <input type="text" class="form-control" name="shipment_country_code" value="US" readonly>
                </div>
                <div class="form-group">
                    <label>Shipper Email Address</label>
                    <input type="text" class="form-control" name="shipment_email_address" value="robert@digitalapedentallabs.com" readonly>
                </div>
                <div class="form-group">
                    <label>Shipper Phone</label>
                    <input type="text" class="form-control" name="shipment_phone_number" value="214-973-5225" readonly>
                </div>
            </div>
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
                    <input type="text" class="form-control" name="tocompany_name" value="Abbeville Dentistry">
                </div>
                <div class="form-group">
                    <label>Company Attention Name</label>
                    <input type="text" class="form-control" name="toaddress_attention_name" value="Abbeville Dentistry">
                </div>
                <div class="form-group">
                    <label>Company Email Address</label>
                    <input type="text" class="form-control" name="toaddress_email" value="apebsworth@abbevilledentistry.com">
                </div>
                <div class="form-group">
                    <label>Company Phone</label>
                    <input type="text" class="form-control" name="toaddress_phone_number" value="(806) 712-4082">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
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