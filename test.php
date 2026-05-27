<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo "Hello World!"; ?></h1>

    <?php echo "<script> console.log('Hello world!'); </script>"; ?>

    <?php
        $numere = [12, 7, 5, 18, 22, 9, 14, 3, 8, 11];
        $pare = 0;
        $impare = 0;

        for ($i = 0; $i < count($numere); $i++) {

            if ($numere[$i] % 2 == 0) {
                echo $numere[$i] . " este par<br>";
                $pare++;
            } else {
                echo $numere[$i] . " este impar<br>";
                $impare++;
            }
        }

        echo "<br>Total numere pare: " . $pare . "<br>";
        echo "Total numere impare: " . $impare;
    ?>
</body>
</html>