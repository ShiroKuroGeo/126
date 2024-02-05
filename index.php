<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>126 Motor Parts Web Application </title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
<style>
    .view>a{
        background-color: #f44336;
        color: white;
        padding: 10px 30px;
        border-radius: 10px;
        border-style: solid;
        border-color: #636b6f;     
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
        position: relative;
        right: 15px;
        text-transform: uppercase;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: .1rem;
        
        
    }

    .view>a:hover, .view>a:active {
        background-color: white;
        color: #f44336;
    }
</style>    
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <img src="pos/admin/assets/img/brand/logo.png"></img>
                <div class="title m-b-md">
                        126 MOTOR PARTS
                </div>

                <div class="links">
                    <a href="pos/admin/">Admin Log In</a>
                    <a href="pos/cashier/">Cashier Log In</a>
                    <a href="pos/customer">Customer Log In</a>
                </div>
                <div class="view">
                    <a href="view.php">View Products</a>
                </div>          
        </div>
        
    </div>
     
</body>

</html>