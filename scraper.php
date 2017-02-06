<?

$db = new PDO('sqlite:data.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
  $db->query('CREATE TABLE data(
    guid VARCHAR(100),
    description TEXT,
    title VARCHAR(100),
    article_timestamp VARCHAR(10),
    PRIMARY KEY (guid))');
} catch (Exception $e) {
}
$articles = array(array('guid' => "1", 'description' => 'this is a test', 'title' => 'this is a title', 'article_timestamp' => 'date'));
foreach ($articles as $article) {
  $exists = $db->query("SELECT * FROM data WHERE guid = " . $db->quote($article->guid))->fetchObject();
  if (!$exists) {
    $sql = "INSERT INTO data(guid, description, title, article_timestamp) VALUES(:guid, :description, :title, :article_timestamp)";
  } else {
    $sql = "UPDATE data SET description = :description, article_timestamp = :article_timestamp WHERE guid = :guid";
  }
  $statement = $db->prepare($sql);
    $statement->execute(array(
    ':guid' => $article['guid'], 
    ':description' => $article['description'],
    ':title' => $article['title'],
    ':article_timestamp' => $article['article_timestamp']
  ));
}
?>
