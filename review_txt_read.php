<?php
$str="";
$array=[];
$file=fopen("./data/review.text","r");

flock($file,LOCK_EX);
if($file){
  while($line=(fgets($file))){
    $str .="<tr><td>{$line}</tr></td>";
    $array[]=[
        "today"=>str_replace("\n","",explode("|",$line)[4]),
        "title"=>explode("|",$line)[2],
      "name"=>explode("|",$line)[0],
     "number"=>explode("|",$line)[1],
"message"=>explode("|",$line)[3],
    ];
}

}
flock($file,LOCK_UN);
fclose($file);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ゲームレビュー</title>
  <style>

.star-rating {
      display: inline-block;
    }
    .star {
      font-size: 2em;
      color: #ddd;
    }
    .star.filled {
      color: #f5c518;
    }
  </style>
</head>
<body>
  <fieldset>
    <legend>ゲームの評価</legend>
    <a href="./main.php">タイトルに戻る</a><br>
    <div id="sum_Review"></div>
    <select name="sort" id="sort">
        <option value="rev_HIGH" selected>評価が高い順</option>
        <option value="rev_LOW">評価が低い順</option>
        <option value="rev_NEW">投稿が新しい順</option>
        <option value="rev_OLD">投稿が古い順</option>
    </select>
    <select name="filter" id="filter">
        <option value="ALL" selected>全て表示</option>
        <option value="5">評価５のみ表示</option>
        <option value="4">評価４のみ表示</option>
        <option value="3">評価３のみ表示</option>
        <option value="2">評価２のみ表示</option>
        <option value="1">評価１のみ表示</option>
    </select>
    <table id="reviews">
    </table>
  </fieldset>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script>
    const data=<?=json_encode($array)?>;
    console.log(data);
    console.log(new Date(data[1].today)-new Date(data[0].today));
       data.sort((a,b)=>{
      return b.number-a.number;
     });

    function generateStars(rating) {
      let stars = '';
      for (let i = 1; i <= 5; i++) {
        stars += `<span class="star${i <= rating ? ' filled' : ''}">&#9733;</span>`;
      }
      return stars;
    }
function show_Reviews(){
    $("#sum_Review").append(`<h1>評価数：${data.length}件</h1>`)
    const list_arr = [];
    for (let i = 0; i < data.length; i++) {
      const stars = generateStars(Number(data[i].number));
      list_arr.push(`<tr><td>評価:${stars}</td></tr><tr><td>${data[i].today}<td></tr><tr><td>タイトル：${data[i].title}</td></tr>
      <tr><td>${data[i].message}</td></tr><tr><td>Name:${data[i].name}</td></tr>`);
      $("#reviews").append(list_arr[i]);
    }
};
show_Reviews();
$("#sort").change(()=>{
    function show_Reviews(){
    $("#sum_Review").append(`<h1>評価数：${data.length}件</h1>`)
    const list_arr = [];
    for (let i = 0; i < data.length; i++) {
      const stars = generateStars(Number(data[i].number));
      list_arr.push(`<tr><td>評価:${stars}</td></tr><tr><td>${data[i].today}<td></tr><tr><td>タイトル：${data[i].title}</td></tr>
      <tr><td>${data[i].message}</td></tr><tr><td>Name:${data[i].name}</td></tr>`);
      $("#reviews").append(list_arr[i]);
    }
};
    $("#reviews").empty();
    $("#sum_Review").empty();
    let sort_Val=$("option:selected").val();
    console.log(sort_Val);
//////////TODO:評価高い順
    if(sort_Val==="rev_HIGH"){
        data.sort((a,b)=>{
      return b.number-a.number;
     });
show_Reviews();
     }
//////////TODO:評価低い順
     else if(sort_Val==="rev_LOW"){
     data.sort((a,b)=>{
      return a.number-b.number;
     });
show_Reviews();}
//////////TODO:投稿が新しい順
     else if(sort_Val==="rev_NEW"){
            data.sort((a,b)=>{
      return new Date(b.today)-new Date(a.today);
     });
show_Reviews();}
//////////TODO:投稿が古い順
else if(sort_Val==="rev_OLD"){
    data.sort((a,b)=>{
      return new Date(a.today)-new Date(b.today);
     });
show_Reviews();
}
});
$("#filter").change(()=>{
        $("#reviews").empty();
    $("#sum_Review").empty();
    let filter_Val=$("option:selected").val();
    console.log(sort_Val);

})
  </script>
</body>

</html>