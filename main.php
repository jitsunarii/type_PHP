<?php







?>
<!DOCTYPE html>
<html lang="jp">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TYPING GAME DX</title>
    <style>
        /* スタート画面 */
        #TITLE_start {
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-flow: column;
            margin-top: 13%;
        }

        /* スタートボタン */
        button {
            text-align: center;
            font-size: 40px;
            width: 6em;
            height: 2em;
        }

        /* ゲーム画面 */
        #game {
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-flow: column;
            margin-top: 17%;
        }

        /* 終了する前までの文字 */
        h1 {
            text-align: center;
            font-size: 100px;
        }

        /* 終了！ */
        #finish_1 {
            margin-top: 17%;
        }

        /* 結果は */
        #finish_2 {
            padding-top: 5%;
            padding-left: 10%;
            font-size: 60px;
        }

        /* 〇分〇秒,の位置*/
        #finish_3 {
            text-align: center;
        }

        /* 〇分〇秒,の文字*/
        #pass_time {
            font-size: 100px;
        }

        /* あなたのランクは,の位置*/
        #finish_4 {
            padding-top: 2%;
            padding-left: 2%;
            font-size: 40px;
        }

        /* rank,の文字*/
        #rank {
            margin-top: 0px;
            margin-bottom: 0px;
            text-align: center;
            font-size: 160px;
            font-weight: bold;
        }

        /* です */
        #desu {
            padding-right: 12%;
            padding-bottom: 20%;
            font-size: 40px;
            text-align: right;
        }

        .star-rating {
      direction: rtl;
      display: inline-block;
      padding: 20px;
    }
    .star-rating input[type="radio"] {
      display: none;
    }
    .star-rating label {
      font-size: 2em;
      color: #ddd;
      cursor: pointer;
    }
    .star-rating input[type="radio"]:checked ~ label {
      color: #f5c518;
    }
    .star-rating label:hover,
    .star-rating label:hover ~ label {
      color: #f5c518;
    }
    </style>
</head>

<body>
<!--******************************************************************************************
タイトル画面
**********************************************************************************************-->
    <div id="TITLE_start">
        <h1 class="title">タイピングゲームDX</h1>
        <!-- TODO:名前を入力 -->
        <p>名前</p><input type="text" id="player">
        <!-- スタートボタン -->
        <button id="start_button">スタート</button>
    </div>
<!--******************************************************************************************
ゲームプレイ画面(ゲーム終了後の結果表示画面も含む)
**********************************************************************************************-->
    <!-- ゲームスタート後画面 -->
    <div id="game" style="display:none">
        <!-- 問題文表示 -->
        <h1 id="start" class="text"></h1>
    </div>
    <!-- 終了! -->
    <div id="finish_1" style="display:none">
        <h1>終了！</h1>
    </div>
    <div id="finish_2_3">
        <!-- 結果は -->
        <div id="finish_2" style="display:none">
            <p>結果は。。。</p>
        </div>
        <!-- 〇分〇秒 -->
        <div id="finish_3" style="display:none">
            <p id="pass_time"></p>
        </div>
    </div>
    <!-- あなたのランクは -->
    <div id="finish_4" style="display: none">
        <p>あなたのランクは</p>
    </div>
    <!-- rank -->
    <div>
        <p id="rank"></p>
    </div>
    <!-- です -->
    <div>
        <p id="desu"></p>
    </div>
    <!-- TODO:全ての文字が表示した後に出てくるボタン -->
    <div style="display: none;">
        <button id="fin_Btn">タイトルに戻る</button>
    </div>
    </div>
<!--******************************************************************************************
フォーム画面
**********************************************************************************************-->
    <!-- TODO:レビューフォーム（PHPでデータ送信） -->
    <a href="./review_txt_read.php">レビューを見る</a>
    <form id="review" action="./review_txt_create.php" method="GET" style="display: block;">
    <!-- 記入日    -->

    <label for="day">記入日:</label>
    <div id="today"></div>
    <!-- 名前欄 -->
        <div>
            <label for="name">名前:</label>
            <input type="text" id="name" name="name">
        </div>
         <div>
      <label for="star">評価:</label>
      <div class="star-rating">
        <input type="radio" id="5-stars" name="number" value="5"><label for="5-stars">&#9733;</label>
        <input type="radio" id="4-stars" name="number" value="4"><label for="4-stars">&#9733;</label>
        <input type="radio" id="3-stars" name="number" value="3"><label for="3-stars">&#9733;</label>
        <input type="radio" id="2-stars" name="number" value="2"><label for="2-stars">&#9733;</label>
        <input type="radio" id="1-star" name="number" value="1"><label for="1-star">&#9733;</label>
      </div>
    </div>
        <!-- タイトル欄 -->
        <div>
        <label for="title">タイトル:</label>
        <input type="text" id="title" name="title">
    </div>
        <!-- 本文 -->
        <div>
         <label for="message">内容:</label>
            <textarea id="message" name="message"></textarea>
        </div>
        <!-- 送信ボタン -->
           <input type="submit" value="送信する">
    </form>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
/***************************************************************************************
使用する変数、関数の設定
***************************************************************************************/

        // 問題に使う単語
        let Q_Array = ["hadoken",]
        //残りの問題数
        let Q_REST = Q_Array.length;
        //出題される問題
        let Q_WORD_CREATE = Math.floor(Math.random() * Q_REST);
        // 回答の初期値 何文字目まで正解しているか
        let A_WORD_LENGTH = 0;
        // if条件の計算用 問題になっている単語の文字数
        let Q_WORD_LENGTH_2 = Q_Array[Q_WORD_CREATE].length;
        // スタートボタンを押した回数
        let START_COUNT = 0;
        //正解数のカウント
        let CORRECT_COUNT= 0;

        //問題の単語を表示させる関数
        function show_words() {
            $("#start").html(Q_Array[Q_WORD_CREATE].substring(A_WORD_LENGTH, Q_WORD_LENGTH_2));
        }


/********************************************************************************************
ゲームスタート
**********************************************************************************************/        
// スタートボタンを押した時の処理

        $("#start_button").click(function () {
        //TODO:プレイヤー名が入力されていない時
             if (!$('#player').val()){
             alert("Write your name!!")


        //TODO:入力されている時
        }else{
            //スタート音
            new Audio("race_start.mp3").play();
            // 開始時間を記録
            const startTime = Date.now();
            // ゲーム画面を表示
            $("#game").css("display", "block");
            // スタート画面を消去
            $("#TITLE_start").css("display", "none");
            //問題を表示
            show_words();
            // キー入力時の処理
            $(window).keydown(function push_keydown() {// window.=画面を開いてる時

                //押されたキー情報を取得
                let keyCode = event.key;

                //条件:正解のキーを押した
                if (Q_Array[Q_WORD_CREATE].charAt(A_WORD_LENGTH) == keyCode) {

                    // 入力音
                    new Audio('good.mp3').play();
                    // 正解している文字数を更新
                    A_WORD_LENGTH++;
                    //単語の表記を更新
                    show_words();
                } else {
                }
                //条件:１単語の全ての文字を打ち終わった
                if (Q_WORD_LENGTH_2 - A_WORD_LENGTH === 0) {

                    //配列から回答済みの単語を削除
                    Q_Array.splice(Q_WORD_CREATE, 1);
                    //配列内の単語の個数情報を更新
                    Q_REST = Q_Array.length;
                    console.log(Q_REST);
                    //正解音
                    new Audio('ok.mp3').play();
                    //正解数をプラス
                    CORRECT_COUNT++;


                    // 条件：配列内に単語が残ってる
                    if (Q_REST >= 1) {

                        //問題、回答に関わる変数を初期値に戻す作業
                        Q_WORD_CREATE = Math.floor(Math.random() * Q_Array.length);
                        A_WORD_LENGTH = 0;
                        Q_WORD_LENGTH_2 = Q_Array[Q_WORD_CREATE].length;
                        //問題を表示
                        show_words();
                    }




/**************************************************************************************
ゲーム終了
***************************************************************************************/
//条件：配列内の単語が残っていない

                    if (Q_REST <= 0) {
                        //終了時の時間を計測
                        const endTime = Date.now();
                        //終わるまでかかった時間
                        const typeTime = endTime - startTime;
                        //かかった時間を分秒に変換する
                        let min = Math.floor(typeTime / 60000);
                        let sec = Math.floor(typeTime / 1000);
                        //条件：かかった時間が1分以上
                        if (min > 0) {
                            min = Math.floor(typeTime / 60000);
                            sec = Math.floor((typeTime / 1000) - (60 * min));
                        }
                        //かかった時間が1分未満
                        else if (min < 0) {
                            min = Math.floor(typeTime / 60000);
                            sec = Math.floor(typeTime / 1000);
                        }
                        // ゲーム画面を消す処理
                        $("#game").css("display", "none");
                        // TODO:１秒後に「終了！」を画面に出す処理
                        setTimeout(function () {
                            $("#finish_1").css("display", "block");
                            new Audio('finish.mp3').play();
                        }, 1000);
                        // TODO:2秒後に「結果は」を出す処理
                        //ドラムロール音
                        const drum_audio = new Audio('drum.mp3');
                        setTimeout(function () {
                            //ドラムロール開始
                            drum_audio.play();
                            // 「結果は」を表示する処理
                            $("#finish_1").css("display", "none");
                            $("#finish_2").css("display", "block");

                        }, 2000);
                        // TODO:4秒後にタイムを表示する処理
                        setTimeout(function () {
                            // ドラムロール停止
                            drum_audio.pause();
                            //ドラムロール後の音声再生
                            new Audio("after_drum.mp3").play();
                            // タイムを表示
                            $("#finish_3").css("display", "block");
                            $("#pass_time").append(min + "分" + sec + "秒");
                        }, 4000);
                        // TODO:5秒後に「あなたのランクは」を表示する処理
                        setTimeout(function () {
                            //太鼓の音
                            new Audio("don.mp3").play();
                            //前の画面を消去
                            $("#finish_2_3").css("display", "none");
                            //「あなたのランクは」を表示
                            $("#finish_4").css("display", "block");
                        }, 5000);

                        // TODO:6秒後にrankを表示する処理
                        setTimeout(function () {
                            //太鼓の音
                            new Audio("don.mp3").play();
                            //条件:かかった時間が60秒以上
                            if (typeTime >= 60000) {
                                $("#rank").append("ブロンズ");
                                $("#rank").css("color", "brown");
                            }
                            //条件:かかった時間が50秒以上,60秒未満
                            else if (typeTime >= 50000 && 60000 > typeTime) {
                                $("#rank").append("シルバー");
                                $("#rank").css("color", "silver");
                            }
                            //条件:かかった時間が40秒以上,50秒未満
                            else if (typeTime >= 40000 && 50000 > typeTime) {
                                $("#rank").append("ゴールド");
                                $("#rank").css("color", "yellow");
                            }
                            //条件:かかった時間が30秒以上,40秒未満
                            else if (typeTime >= 30000 && 40000 > typeTime) {
                                $("#rank").append("プラチナ");
                                $("#rank").css("color", "blue");
                            }
                            //条件:かかった時間が20秒以上,30秒未満
                            else if (typeTime >= 20000 && 30000 > typeTime) {
                                $("#rank").append("ダイヤ");
                                $("#rank").css("color", "pink");
                            }//条件:かかった時間が2秒以上,20秒未満
                            else if (typeTime >= 2000 && 20000 > typeTime) {
                                $("#rank").append("マスター");
                                $("#rank").css("color", "red");
                            }
                        }, 6000);
                        //TODO:7秒後に「です」を表示する処理
                        setTimeout(function () {
                            //「です」を表示
                            $("#desu").append("です");
                            //太鼓の音
                            new Audio("do_don.mp3").play();
                        }, 7000);
                        //TODO:8秒後にrankに応じた音楽を流す処理
                        setTimeout(function () {
                            //条件:ブロンズ、シルバー
                            if (typeTime >= 50000) {
                                new Audio("pafu.mp3").play();
                            }
                            //条件:ゴールド,プラチナ
                            else if (typeTime >= 30000 && 50000 > typeTime) {
                                new Audio("donpafuye.mp3").play();
                                //条件:ダイヤ
                            } else if (typeTime >= 20000 && 30000 > typeTime) {
                                new Audio("Congratulations.mp3").play();
                                //条件:マスター
                            } else if (typeTime >= 2000 && 20000 > typeTime) {
                                new Audio("syakin.mp3").play();
                            }
                            //「タイトルに戻るボタン」を表示
                            $("#fin_Btn").css("display","block");
                        }, 8000)
     const date = new Date();
            const year = date.getFullYear();
            const month = date.getMonth();
            const day = date.getDate();
            console.log(date);
            console.log(year);
            console.log(month);
            console.log(day);
          $("#today").append(`<input type="date" name="today" value="${year.toString().padStart(4,"0")}/${month.toString().padStart(2,"0")}/${day.toString().padStart(2,"0")}">`)
                }
                }
            });
        }
        });
    </script>
</body>
</html>