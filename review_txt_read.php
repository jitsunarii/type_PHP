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
    $("#filter").val("ALL");
    let sort_Val=$("option:selected","#sort").val();
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
//フィルター機能
$("#filter").change(()=>{
        $("#reviews").empty();
    $("#sum_Review").empty();
    let filter_Val=$("option:selected","#filter").val();
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
//////TODO:全て表示
if(filter_Val==="ALL"){
show_Reviews();
}
//////TODO:評価5のみ表示
else if(filter_Val==="5"){
const Val5_Arr=data.filter((a)=>a.number==="5");
    $("#sum_Review").append(`<h1>評価数：${Val5_Arr.length}件</h1>`)
    const list_arr = [];
    for (let i = 0; i < Val5_Arr.length; i++) {
      const stars = generateStars(Number(Val5_Arr[i].number));
      list_arr.push(`<tr><td>評価:${stars}</td></tr><tr><td>${Val5_Arr[i].today}<td></tr><tr><td>タイトル：${Val5_Arr[i].title}</td></tr>
      <tr><td>${Val5_Arr[i].message}</td></tr><tr><td>Name:${Val5_Arr[i].name}</td></tr>`);
      $("#reviews").append(list_arr[i]);
}}
//////TODO:評価4のみ表示
else if(filter_Val==="4"){
const Val4_Arr=data.filter((a)=>a.number==="4");
    $("#sum_Review").append(`<h1>評価数：${Val4_Arr.length}件</h1>`)
    const list_arr = [];
    for (let i = 0; i < Val4_Arr.length; i++) {
      const stars = generateStars(Number(Val4_Arr[i].number));
      list_arr.push(`<tr><td>評価:${stars}</td></tr><tr><td>${Val4_Arr[i].today}<td></tr><tr><td>タイトル：${Val4_Arr[i].title}</td></tr>
      <tr><td>${Val4_Arr[i].message}</td></tr><tr><td>Name:${Val4_Arr[i].name}</td></tr>`);
      $("#reviews").append(list_arr[i]);
}}
//////TODO:評価3のみ表示
else if(filter_Val==="3"){
const Val3_Arr=data.filter((a)=>a.number==="3");
    $("#sum_Review").append(`<h1>評価数：${Val3_Arr.length}件</h1>`)
    const list_arr = [];
    for (let i = 0; i < Val3_Arr.length; i++) {
      const stars = generateStars(Number(Val3_Arr[i].number));
      list_arr.push(`<tr><td>評価:${stars}</td></tr><tr><td>${Val3_Arr[i].today}<td></tr><tr><td>タイトル：${Val3_Arr[i].title}</td></tr>
      <tr><td>${Val3_Arr[i].message}</td></tr><tr><td>Name:${Val3_Arr[i].name}</td></tr>`);
      $("#reviews").append(list_arr[i]);
}}
//////TODO:評価2のみ表示
else if(filter_Val==="2"){
const Val2_Arr=data.filter((a)=>a.number==="2");
    $("#sum_Review").append(`<h1>評価数：${Val2_Arr.length}件</h1>`)
    const list_arr = [];
    for (let i = 0; i < Val2_Arr.length; i++) {
      const stars = generateStars(Number(Val2_Arr[i].number));
      list_arr.push(`<tr><td>評価:${stars}</td></tr><tr><td>${Val2_Arr[i].today}<td></tr><tr><td>タイトル：${Val2_Arr[i].title}</td></tr>
      <tr><td>${Val2_Arr[i].message}</td></tr><tr><td>Name:${Val2_Arr[i].name}</td></tr>`);
      $("#reviews").append(list_arr[i]);
}}
//////TODO:評価1のみ表示
else if(filter_Val==="1"){
const Val1_Arr=data.filter((a)=>a.number==="1");
    $("#sum_Review").append(`<h1>評価数：${Val1_Arr.length}件</h1>`)
    const list_arr = [];
    for (let i = 0; i < Val1_Arr.length; i++) {
      const stars = generateStars(Number(Val1_Arr[i].number));
      list_arr.push(`<tr><td>評価:${stars}</td></tr><tr><td>${Val1_Arr[i].today}<td></tr><tr><td>タイトル：${Val1_Arr[i].title}</td></tr>
      <tr><td>${Val1_Arr[i].message}</td></tr><tr><td>Name:${Val1_Arr[i].name}</td></tr>`);
      $("#reviews").append(list_arr[i]);
}}



})
  </script>
</body>

</html>