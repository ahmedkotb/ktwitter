//update interval in mins
updateInterval = 2;
setInterval("getNewTweets()",updateInterval*60*1000);
function getNewTweets(){
    var oldTweetsDiv = document.getElementById('old-tweets');
    var newTweetsDiv = document.getElementById('new-tweets-content');     
    oldTweetsDiv.innerHTML = newTweetsDiv.innerHTML + oldTweetsDiv.innerHTML;
    
    var last_date = document.getElementById('last_date').innerHTML;
    run('tweets/update/'+last_date);
}

function updateDivs(){
    var count = parseInt(document.getElementById('count').innerHTML); 
    if (count == 0) return;
    var countDiv = document.getElementById('new-tweets-label');
    var oldCountDiv = document.getElementById('old-tweets-count');  
    var total = parseInt(oldCountDiv.innerHTML) + count;
    countDiv.innerHTML =total + ' new ktweets';
    oldCountDiv.innerHTML = total;
    var labelDiv = document.getElementById('new-tweets-label'); 
    labelDiv.style.display = 'block';
}

function showNewTweets(){
    var labelDiv = document.getElementById('new-tweets-label'); 
    var newDiv = document.getElementById('new-tweets-content');
    var oldDiv = document.getElementById('old-tweets');
    
    var tweetsDiv = document.getElementById('tweets');
    var oldCount = document.getElementById('old-tweets-count');
    labelDiv.style.display = 'none';
    tweetsDiv.innerHTML =  newDiv.innerHTML + oldDiv.innerHTML + tweetsDiv.innerHTML
    
    oldCount.innerHTML = '0';
    oldDiv.innerHTML = "";
}


function addedMoreTweets(){
   setTimeout('moreTweets()', 100);
}

function moreTweets(){ 
   var moreTweetsDiv = document.getElementById('more-tweets-content');
   var tweetsDiv = document.getElementById('tweets');
   tweetsDiv.innerHTML = tweetsDiv.innerHTML + moreTweetsDiv.innerHTML;
   moreTweetsDiv.innerHTML = '';
}

function addNewTweet(){
   setTimeout('showNewTweet()', 100);
}

function showNewTweet(){   
    var tweetResultDiv = document.getElementById('tweet_add_content');
    var errorDiv = document.getElementById('error');
    if (tweetResultDiv == null){
        errorDiv.innerHTML = "Invalid Tweet";
        return;
    }
    var tweetResult = tweetResultDiv.innerHTML;
    var tweetResultDate = document.getElementById('tweet_add_last_date').innerHTML;
    var last_date_div = document.getElementById('last_date');    
    var tweetsDiv = document.getElementById('tweets');
    last_date_div.innerHTML = tweetResultDate;
    errorDiv.innerHTML = "Tweet Added";
    tweetsDiv.innerHTML = tweetResult + tweetsDiv.innerHTML;
    document.getElementById('latest').innerHTML='<b style="color:#999999">latest :</b>' + document.getElementById('TweetContent').value;
    document.getElementById('TweetContent').value='';    
}

//ajax libs
function GetXmlHttpObject(){
    var xmlHttp = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    }
    catch (e) {
        // Internet Explorer
        try {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e) {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

function stateChanged(){
    if (xmlHttp.readyState == 4) {
        //alert(xmlHttp.responseText);
        var newdiv = document.getElementById('new-tweets');
        newdiv.innerHTML = xmlHttp.responseText;
        updateDivs();
    }
}

function run(scriptName){
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        if (!displayedSupportMessage){
            alert("Your browser does not support AJAX!");
            displayedSupportMessage = true;         
        }
        return;
    }
    var url = scriptName;
    xmlHttp.onreadystatechange = stateChanged;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
