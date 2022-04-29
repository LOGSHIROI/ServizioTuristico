
<?php
use model\Questionario;
$data = $GLOBALS["TEMPLATE_DATA"];
//echo "<pre>";
//var_dump($data);
?>

<html>
<head>
    <title>Questionario per pac</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $( document ).ready(function() {
            $('.star-radio-input').click(function() {
                var theNumber = $(this).attr('id').slice(-1);
                $(this).siblings('label').each(function() {
                    var sibNumber = $(this).attr('for').slice(-1);
                    if (sibNumber <= theNumber) {
                        $(this).addClass('on');
                    } else {
                        $(this).removeClass('on');
                    }
                });
            });
        });
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        input[type=text]:focus {
            width: 50%;
        }
        input[type = text]{
            width: 200px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 10px;
            font-size: 16px;
            background-color: white;
            background-position: 10px 10px;
            background-repeat: no-repeat;
            padding: 6px 10px 6px 20px;
            transition: width 0.4s ease-in-out;
        }
        .star-label:before {
            content: '☆';
            color: black;
            font-size: 2em;
        }
        .on:before {
            content: '★';
            color: yellow;
            /* uncomment for iOS */
            /*   font-size: 2.4em;
              top: -0.1em;
              left: -0.1em; */
        }
        input:checked + .star-label:before {
            content: '★';
            color: yellow;
            /* uncomment for iOS */
            /*   font-size: 2.4em;
              top: -0.1em;
              left: -0.1em; */
        }
        .star-label {
            display: inline-block;
            cursor: pointer;
            position: relative;
            padding-left: 25px;
            margin-right: 15px;
            font-size: 20px;
        }
        .star-label:before {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 10px;
            position: absolute;
            left: 0;
            border-radius: 10px;
        }
        .star-radio-input {
            display: none;
            -webkit-appearance: none;
        }

        /* Non-essential */
        body {
            margin: 2em;
            background-color: white;
            text-align: center;
            /* remove gray highlight on tap in iOS */
            -webkit-tap-highlight-color:transparent;
        }
        .question {
            margin-bottom: 8em;
        }
        #q1 {
            margin-top: 6em;
        }
        p {
            color: black;
            font-family: Bitter, sans-serif;
            font-size: 2em;
        }

        .erorr {color: red}
    </style>
</head>
<body>
<div class="container">
    <h1>Questionario Per Pacchetto</h1>
    <h1>benvenuta agenzia <?php echo $data["agenzia"]["Nome"]?></h1>
    <p>Si prega di compilare tutti i campi del questionario</p>
    <p><span class = "erorr">* Campi obbligatori</span></p>
    <form method="post">
        <div class="form-group">
            <strong>Anno pacchetto:_ </strong><br/>
            <input type="text" name="pacYear" placeholder="Number . . ." value="" required/>
<!--            <span class = "erorr">* --><?php //echo isset($data["errors"]["Nome"]) ? $data["errors"]["Nome"] : ''; ?><!--</span>-->
        </div>
        <div class="form-group">
            <strong>Numero Dipendenti:_ </strong><br/>
            <input type="text" name="numDipe" placeholder="Number . . ." value="" required/>
<!--            <span class = "erorr">* --><?php //echo isset($data["errors"]["Cognome"]) ? $data["errors"]["Cognome"] : ''; ?><!--</span>-->
        </div>
        <div class="form-group">
            <strong>Pacchetti venduti:_ </strong><br/>
            <input type="text" name="pacSale" placeholder="Number . . ." value="" required/>
<!--            <span class = "erorr">* --><?php //echo isset($data["errors"]["Cognome"]) ? $data["errors"]["Cognome"] : ''; ?><!--</span>-->
        </div>
</div>


<?php foreach ($data["questions"]["gen"] as $question) { ?>
<div class = container>
    <div class="question" id="<?php echo $question["ID"]; ?>">
        <p><?php echo $question["Descrizione"]; ?><span class = "erorr">* <?php echo $data["errors"]["gen" . $question["ID"]] ?? ''; ?></span></p>
        <?php foreach ($data["questions"]["gen-answers"] as $answer) { ?>
            <input class="star-radio-input" type="radio" name="gen<?php echo $question["ID"]; ?>" id="gen<?php echo $question["ID"].$answer; ?>" value="<?php echo $answer; ?>">
            <label class="star-label" for="gen<?php echo $question["ID"].$answer; ?>"></label>
        <?php } ?>
    </div>
</div>
<?php } ?>
<?php foreach ($data["questions"]["pac"] as $question) { ?>
    <div class = container>
        <div class="question" id="<?php echo $question["ID"]; ?>">
            <p><?php echo $question["Descrizione"]; ?><span class = "erorr">* <?php echo $data["errors"]["pac".$question["ID"]] ?? ''; ?></span></p>
            <?php foreach ($data["questions"]["pac-answers"] as $pac_answer) { ?>
                <input type="radio" name="pac<?php echo $question["ID"]; ?>" id="pac<?php echo $question["ID"]; ?>" value="<?php echo $pac_answer["value"]; ?>">
                <label for="pac<?php echo $question["ID"]; ?>"><?php echo $pac_answer["label"]; ?></label>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<div class="form-group">
    <input type="submit" value="Submit" name="submit" class="btn btn-primary"/>
</div>
</form>
</div>
</body>
</html>
