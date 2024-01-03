<?php
// ユーザーの入力を受け取る
$search_title = isset($_GET['title']) ? $_GET['title'] : '';
$search_author = isset($_GET['author']) ? $_GET['author'] : '';

// APIの基本URL
$base_url = 'https://www.googleapis.com/books/v1/volumes?q=';

// 検索条件の設定
$params = array();
if ($search_title) {
    $params['intitle'] = $search_title;
}
if ($search_author) {
    $params['inauthor'] = $search_author;
}

// URLの生成
foreach ($params as $key => $value) {
    $base_url .= $key.':'.$value.'+';
}

// 末尾の「+」を削除
$url = substr($base_url, 0, -1);

// デフォルトの最大取得件数と開始インデックス
$maxResults = 10;
$startIndex = 0;

// 件数情報をURLに追加
$url .= '&maxResults='.$maxResults.'&startIndex='.$startIndex;

// 書籍情報の取得
$json = file_get_contents($url);
$data = json_decode($json);

// 書籍情報の処理
$total_count = isset($data->totalItems) ? $data->totalItems : 0;
$books = isset($data->items) ? $data->items : array();
$get_count = count($books);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>Google Books Search</title>
</head>
<body>
  <h1>Google Books 検索</h1>

  <!-- 検索フォーム -->
  <form method="get">
    <label for="title">タイトル:</label>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($search_title); ?>"><br>
    <label for="author">著者:</label>
    <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($search_author); ?>"><br>
    <input type="submit" value="検索">
  </form>

  <p>全<?php echo $total_count; ?>件中、<?php echo $get_count; ?>件を表示中</p>

  <?php if ($get_count > 0): ?>
    <div class="loop_books">
      <?php foreach ($books as $book):
        // タイトル
        $title = $book->volumeInfo->title;
        // サムネイル画像
        $thumbnail = isset($book->volumeInfo->imageLinks->thumbnail) ? $book->volumeInfo->imageLinks->thumbnail : 'no_image.png';
        // 著者
        $authors = isset($book->volumeInfo->authors) ? implode(',', $book->volumeInfo->authors) : '不明';
        // 説明
        $description = isset($book->volumeInfo->description) ? $book->volumeInfo->description : '説明なし';
        // カテゴリ
        $categories = isset($book->volumeInfo->categories) ? implode(', ', $book->volumeInfo->categories) : 'カテゴリなし';
      ?>
        <div class="loop_books_item">
          <img src="<?php echo htmlspecialchars($thumbnail); ?>" alt="<?php echo htmlspecialchars($title); ?>"><br>
          <p>
            <b>『<?php echo htmlspecialchars($title); ?>』</b><br>
            著者：<?php echo htmlspecialchars($authors); ?><br>
            カテゴリ：<?php echo htmlspecialchars($categories); ?><br>
            <small>説明：<?php echo htmlspecialchars($description); ?></small>
          </p>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p>情報が有りません</p>
  <?php endif; ?>

</body>
</html>
