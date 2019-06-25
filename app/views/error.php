<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error</title>
</head>
<body>
    <div style="
        width:100%;
        height:100%;
        display:flex;
        align-items:center;
        text-align:center;
        font-family:'Helvetica','Arial','Calibri';
    ">
        <div style="
            margin:0 auto;
            width:50%;
            height:50%;
        ">
            <h1 style="
                font-size:3rem;
                color:tomato;
            ">
                Error
            </h1>
            <p><?php echo $this->errors; ?></p>
        </div>
    </div>
</body>
</html>