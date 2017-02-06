<?php
/**
 * Classe Foo qui ne sert visiblement pas à grand-chose
 * Syntaxe Doxygen
 * Description longue (et inutile)
 * de ma classe qui peut s'étaler
 * sur plusieurs lignes.
 *
* @package libs
* @subpackage util
* @author Benjamin DELESPIERRE <benjamin.delespierre@gmail.com>
* @version 1.0.0
* @since 1.2
* @copyright 2013 Foo Corp.
*/
      
// Insérer des données
 
$inputs['author']  = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_STRING);
$inputs['message'] = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
 
//  - ou -
 
$inputs = filter_input_array(INPUT_POST, array(
    'author'  => FILTER_SANITIZE_STRING,
    'message' => FILTER_SANITIER_STRING,
));
 
$pdo  = new PDO(...);
$stmt = $pdo->prepare('INSERT INTO comments (author,message) VALUES (:author,:message)');
 
if ($stmt->execute($inputs)) {
    // ok
}
else {
    // nok !
}


 
// Extraire les données puis afficher
 
$article_id = filter_input(INPUT_GET, 'article_id', FILTER_SANITIZE_INT);
 
if (!$article_id) {
    // erreur
}
 
$pdo  = new PDO(...);
$stmt = $pdo->prepare('SELECT author,message FROM comments WHERE article_id=:article_id');
 
if (!$stmt->execute(compact('article_id'))) {
    // erreur
}
 
$stmt->setFetchMode(PDO::FETCH_OBJ); // sera utile lors qu'on va traverser les résultats
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Commentaires</title>
</head>
<body>
    <h1>Commentaires de l'article #<?php echo $article_id ?></h1>
    <?php foreach ($stmt as $comment): ?>
    <blockquote>
        <h3 class="author"><?php echo filter_var($comment->author,  FILTER_SANITIZE_STRING) ?></h3>
        <p class="message"><?php echo filter_var($comment->message, FILTER_SANITIZE_STRING) ?></p>
    </blockquote>
    <?php endforeach ?>
</body>
</html>