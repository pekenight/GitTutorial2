<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>たのしいめいろ</title>
    <style>
        .maze {
        }
        .moveButton {
            position: relative;
        }
        .maze:after {
            width: 0;
            height: 0;
            content: "";
            clear: both;
        }
        .w {
            background-color: green;
            width: 15px;
            height: 15px;
            padding: 0;
            margin: 0;
            float: left;
        }
        .p {
            background-color: white;
            width: 15px;
            height: 15px;
            padding: 0;
            margin: 0;
            float: left;
        }
        .h {
            background-color: blue;
            width: 15px;
            height: 15px;
            padding: 0;
            margin: 0;
            float: left;
        }
        .g {
            background-color: red;
            width: 15px;
            height: 15px;
            padding: 0;
            margin: 0;
            float: left;
        }
    </style>
</head>

<body bgcolor="#F1F6AB">
    <script type="text/javascript">
    // ドッキリページの自動表示
    function openSp (){
        var url_rand = [
        "./sp1.php",
        "./sp2.php",
        "./sp3.php"];
        var url = url_rand[Math.floor(Math.random() * url_rand.length)];
        window.open(url);
    }
    setTimeout("openSp()", 10000000); //ドッキリは開発済みのため一旦100,000秒後に設定

    // 配列をシャッフルする
    function shuffle (o) {
        for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
        return o;
    }
    window.Maze = function (size) {
        // 壁と通路の関係上、サイズは奇数にする。
        this.size = (size % 2 === 0 ? size + 1 : size);
        this.box = [];
        this.$maze = document.querySelector("#maze");
    };

    //アルゴリズムを棒倒しに指定
    Maze.ALGO = {STICK: 1};

    var p = Maze.prototype;

    /**
        迷路を表示する
    */
    p.show = function () {
        this.box[1][1] = 2;
        this.box[this.size-2][this.size-2] = 3;
        console.log("プレイヤーなどを配置." + this.box);
        var snipet = '';
        for (var i = 0; i < this.size; i++) {
            for (var j = 0; j < this.size; j++) {
                if (this.box[j][i] === 0) {
                    // 壁
                    snipet += '<div class="w"></div>';
                } else if(this.box[j][i] === 1){
                    // 通路
                    snipet += '<div class="p"></div>';
                } else if(this.box[j][i] === 2){
                    // 自機
                    snipet += '<div class="h"></div>';
                } else {
                    // ゴール
                    snipet += '<div class="g"></div>';
                }
            }
        }
        this.$maze.innerHTML = snipet;
        this.$maze.style.height = (this.size * 15) + 'px';
        this.$maze.style.width  = (this.size * 15) + 'px';
    }

    /*document.addEventListener("keydown", heroMoving, false);

    //プレイヤーを動かすためのキーボード操作。これは没案だけど使えるかもしれないから取っておいてる
    function heroMoving(event) {

        var test = '';
        var snipet = '';
        var keyName = event.key;

        if (event.ctrlKey) {
            console.log(`keydown:Ctrl + ${keyName}`);
        } else if (event.shiftKey) {
            console.log(`keydown:Shift + ${keyName}`);
        } else {
            console.log(`keydown:${keyName}`);
        }
        for (var i = 0; i < this.size; i++) {
            for (var j = 0; j < this.size; j++) {
                if(this.box[i][j] === 2) {
                    if(keyName === "ArrowLeft") {
                        this.box[i-1][j] = 2;
                        //snipet += '<div class="h"></div>';
                        this.box[i][j] = 1;
                        //snipet += '<div class="p"></div>';
                    }
                    if(keyName === "ArrowUp") {
                        this.box[i][j-1] = 2;
                        //snipet += '<div class="h"></div>';
                        this.box[i][j] = 1;
                        //snipet += '<div class="p"></div>';
                    }
                    if(keyName === "ArrowRight") {
                        this.box[i+1][j] = 2;
                        //snipet += '<div class="h"></div>';
                        this.box[i][j] = 1;
                        //snipet += '<div class="p"></div>';
                    }
                    if(keyName === "ArrowDown") {
                        this.box[i][j+1] = 2;
                        //snipet += '<div class="h"></div>';
                        this.box[i][j] = 1;
                        //snipet += '<div class="p"></div>';
                    }
                }
            }
        }
        //再描画
        this.$maze.innerHTML = snipet;
        this.$maze.style.height = (this.size * 15) + 'px';
        this.$maze.style.width  = (this.size * 15) + 'px';
    }*/

    /*ボタン操作。配列を書き換えて再描画することにより、移動を表現しようとしている。
    書き換えた配列はsession関数などにぶち込み、ページを更新することで再描画。これで移動を表現する。
    移動さえ実装できれば「進行方向に壁があったら進めなくする」「ゴールに着いたらクリアページへ遷移」の方法は
    すでに何通りか思いついているため実装可能。ということで助けてください*/

    //左に移動
    var leftMove = function(){
        console.log('Left');
        for (var i = 0; i < this.size; i++) {
            for (var j = 0; j < this.size; j++) {
                if(this.box[i][j] === 2) {
                    this.box[i-1][j] = 2;
                    this.box[i][j] = 1;
                }
            }
        }
        console.log(this.box);
    }

    //上に移動
    var upMove = function(){
        console.log('Up');
        for (var i = 0; i < this.size; i++) {
            for (var j = 0; j < this.size; j++) {
                if(this.box[i][j] === 2) {
                    this.box[i][j-1] = 2;
                    this.box[i][j] = 1;
                }
            }
        }
        console.log(this.box);
    }

    //下に移動
    var downMove = function(){
        console.log('Down');
        for (var i = 0; i < this.size; i++) {
            for (var j = 0; j < this.size; j++) {
                if(this.box[i][j] === 2) {
                    this.box[i+1][j] = 2;
                    this.box[i][j] = 1;
                }
            }
        }
        console.log(this.box);
    }

    //右に移動
    var rightMove = function(){
        console.log('Right');
        for (var i = 0; i < this.size; i++) {
            for (var j = 0; j < this.size; j++) {
                if(this.box[i][j] === 2) {
                    this.box[i][j+1] = 2;
                    this.box[i][j] = 1;
                }
            }
        }
        console.log(this.box);
    }

    //迷路を作る
    p.create = function (options) {
        options = options || {};
        if (options.algorithm === Maze.ALGO.STICK) {
            this._createByStick();
        }
        this.show();
    }

    //迷路を作る（棒倒し）
    p._createByStick = function () {

        // 初期化
        // まずは壁と通路を交互に作成する。
        for (var i = 0; i < this.size; i++) {
            var row = [];
            this.box.push(row);
            for (var j = 0; j < this.size; j++) {
                // 最初の行と最後行は壁
                if (i === 0 || (i + 1) === this.size) {
                    row.push(0);
                // 最初の列と最後の列も壁
                } else if (j === 0 || (j + 1) === this.size) {
                    row.push(0);
                // 奇数行は全部通路
                } else if (i % 2 === 1) {
                    row.push(1);
                // 偶数行は壁と通路を交互に配置
                } else {
                    // 壁と通路
                    row.push(j % 2);
                }
            }
        }
        console.log("壁と通路を配置." + this.box);
        // ここから壁倒しで迷路を作る
        for (var r = 0; r < this.box.length; r++) {
            // 最初と最後の行は対象外
            if (r === 0 || (r + 1) === this.box.length) {
                continue;
            }
            // 壁がある行のみを対象
            if (r % 2 === 1) {
                continue;
            }
            // 行を取り出す
            var row = this.box[r];

            // 最初の行のみ、どこにでも倒せるようにする。
            var direction = ['top', 'bottom', 'left', 'right'];
            if (r >= 4) {
                // 最初以外は、上に倒さないようにする。
                direction = direction.slice(1);
            }

            for (var i = 0; i < row.length; i++) {
                // 端っこは対象外
                if (i === 0 || (i + 1) === row.length) {
                    continue;
                }
                if (i % 2 === 0) {
                    direction = shuffle(direction);
                    for (var j = 0; j < direction.length; j++) {
                        if (direction[j] === "top") {
                            if (this.box[r-1][i] === 1) {
                                this.box[r-1][i] = 0;
                                break;
                            }
                        }
                        if (direction[j] === "left") {
                            if (this.box[r][i-1] === 1) {
                                this.box[r][i-1] = 0;
                                break;
                            }
                        }
                        if (direction[j] === "right") {
                            if (this.box[r][i+1] === 1) {
                                this.box[r][i+1] = 0;
                                break;
                            }
                        }
                        if (direction[j] === "bottom") {
                            if (this.box[r+1][i] === 1) {
                                this.box[r+1][i] = 0;
                                break;
                            }
                        }
                    }
                }
            }
        }
    }

    </script>
    <h1>めいろをぬけろ！</h1>
    <div style="margin-bottom:10px;">
        <input id="mazeSize" type="hidden" value="30">
    </div>
    <div id="maze"></div>
    <br>

    <script>
        function create () {
            var size = parseInt(document.querySelector("#mazeSize").value);
            if (isNaN(size)) size = 20;
            // 迷路を描画する
            var maze = new Maze(size);
            maze.create({algorithm: Maze.ALGO.STICK});            
        }
        create();
    </script>
    <div class="moveButton">
        <input type="submit" value="←" onclick="leftMove()">
        <input type="submit" value="↑" onclick="upMove()">
        <input type="submit" value="↓" onclick="downMove()">
        <input type="submit" value="→" onclick="rightMove()">
    </div>
</body>
</html>
