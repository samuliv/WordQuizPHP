<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Word Quiz</title>
  <?php echo($HEAD); ?>
  <link href="./assets/wordquiz.css" rel="stylesheet" type="text/css">
</head>
<body>
  <?php 
    echo ( $BODY ) ; 
    if ( $JS ) {
    echo '<script>'.$JS.'</script>';
    }
    ?>
</body>
</html>