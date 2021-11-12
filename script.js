function run2(check_init, roll) {
    // Name: Script.js
    // Description: This is for creating the fancy rolling animation
    // Author: KTK27
    var checkinit = check_init;
    if (!checkinit) {
        alert("insufficent Funds!");
        throw new Error("Insufficient Funds!");
    }
    const button = document.getElementById('activate');
    const money = document.getElementById('money');
    const result = document.getElementById('result');
    const itemheader = document.getElementById('item-header');
    const itemstatus = document.getElementById('item-status');
    const itemdescription = document.getElementById('description');
    const musicplayer = document.getElementById('musicplayer');
    var oXHR = new XMLHttpRequest();
    oXHR.onreadystatechange = reportStatus;
    oXHR.open("GET", "store/items.json", true);
    oXHR.send();
    function reportStatus(){
        if(oXHR.readyState == 4){
            data  = this.responseText;
            data2 = JSON.parse(data);
            prepare(data2,roll);

    }
    function fourstar(info,roll) {
        const fourstar = document.getElementById('4star');
        const fourstarplayer = document.getElementById('fourstarplayer');
        button.style.display = "none";
        money.style.display = "none";
        fourstar.style.display = "block";
        fourstar.play();
        fourstar.addEventListener('ended',function (){
            fourstar.style.display = "none";
            document.body.style.backgroundImage = "none";
            document.body.style.backgroundImage = "url('https://i.pinimg.com/originals/6e/14/50/6e1450119e41d766505a26821d27f76a.jpg')";
            result.style.display = "block";
            itemheader.innerHTML = roll;
            itemstatus.innerHTML = '<span class="rare">Rare</span>';
            itemdescription.innerHTML = info[roll][0]["Description"];
            fourstarplayer.play();
            musicplayer.pause();
            musicplayer.currentTime = 0;
        },false);
    }
    function fivestar(info,roll) {
        const fivestarjojo = document.getElementById('5starjojo');
        const fivestarjudge = document.getElementById('5starjudge');
        const fivestarjojoplayer = document.getElementById('5starjojoplayer');
        const fivestarjudgeplayer = document.getElementById('5starjudgeplayer');
        button.style.display = "none";
        money.style.display = "none";
        var x = Math.floor(Math.random()*2);
        if(x==0){
            fivestarjojo.style.display = "block";
            fivestarjojo.play();
            fivestarjojo.addEventListener('ended', function (){
                fivestarjojo.style.display = "none";
                document.body.style.backgroundImage = "none";
                document.body.style.backgroundImage = "url('https://i.pinimg.com/originals/6e/14/50/6e1450119e41d766505a26821d27f76a.jpg')";
                result.style.display = "block";
                itemheader.innerHTML = roll;
                itemstatus.innerHTML = '<span class="legendary">Legendary</span>';
                itemdescription.innerHTML = info[roll][0]["Description"];
                fivestarjojoplayer.play();
                musicplayer.pause();
                musicplayer.currentTime = 0;
            },false);
        } else {
            fivestarjudge.style.display = "block";
            fivestarjudge.play();
            fivestarjudge.addEventListener('ended',function (){
                fivestarjudge.style.display = "none";
                document.body.style.backgroundImage = "none";
                document.body.style.backgroundImage = "url('https://i.pinimg.com/originals/6e/14/50/6e1450119e41d766505a26821d27f76a.jpg')";
                result.style.display = "block";
                itemheader.innerHTML = roll;
                itemstatus.innerHTML = '<span class="legendary">Legendary</span>';
                itemdescription.innerHTML = info[roll][0]["Description"];
                fivestarjudgeplayer.currentTime = 55;
                fivestarjudgeplayer.play();
                musicplayer.pause();
                musicplayer.currentTime = 0;
            },false);
        }       
    }
    function threestar(info,roll) {
        const threestar = document.getElementById('3star');
        button.style.display = "none";
        money.style.display = "none";
        threestar.style.display ="block";
        threestar.play();
        threestar.addEventListener('ended',function () {
            threestar.style.display = "none";
            document.body.style.backgroundImage = "none";
            document.body.style.backgroundImage = "url('https://i.pinimg.com/originals/6e/14/50/6e1450119e41d766505a26821d27f76a.jpg')";
            result.style.display = "block";
            itemheader.innerHTML = roll;
            itemstatus.innerHTML = '<span class="uncommon">Uncommon</span>';
            itemdescription.innerHTML = info[roll][0]["Description"];
            musicplayer.play();
        },false);   
    }
    function twostar(info,roll) {
        const normal = document.getElementById('2star');
        button.style.display = "none";
        money.style.display = "none";
        normal.style.display = "block";
        normal.play();
        normal.addEventListener('ended', function(){
            normal.style.display = "none";
            document.body.style.backgroundImage = "none";
            document.body.style.backgroundImage = "url('https://i.pinimg.com/originals/6e/14/50/6e1450119e41d766505a26821d27f76a.jpg')";
            result.style.display = "block";
            itemheader.innerHTML = roll;
            itemstatus.innerHTML = 'Common';
            itemdescription.innerHTML = info[roll][0]["Description"];
            musicplayer.play();
        },false);
    }
    function prepare(info,roll) {
        var stars = info[roll][0]["stars"];
      
        switch (stars) {
            case 5:
                console.log("5 star detected");
                fivestar(info,roll);
                break;
            case 4:
                console.log("4 star detected");
                fourstar(info,roll);
                break;
            case 3:
                console.log("3 star detected");
                threestar(info,roll);
                break;
            case 2:
                console.log("2 star detected");
                twostar(info,roll);
                break;
        }
    }
    
}
}
