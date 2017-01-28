document.addEventListener('DOMContentLoaded', function() {
    getNewMessages()
    getNewMessageLoop();
}, false);

function destroy(formIframe){
    document.body.removeChild(formIframe[0]);
    document.body.removeChild(formIframe[1]);
}
function getNewMessageLoop(){
    setInterval(function(){
        getNewMessages();
    },5000);
}
function getNewMessages() {
    var sc=(window.innerHeight + window.scrollY) >= document.body.offsetHeight;
    var formIframe = post("/get_messages.html",{"order": document.getElementById("order").value});//{"TIMESTAMP":Date.now()-3000}
    setTimeout(function(){
        document.getElementById("forum_div").innerHTML=formIframe[1].contentWindow.document.body.innerHTML;
        destroy(formIframe);
        if(sc&&document.body.getAttribute("class")=="desk"){
            console.log("WORKING !");
            window.scrollTo(0,document.body.scrollHeight);
        }
    },500);
}

function deleteMessage(id){
    var formIframe=post("/delete_message.html",{"message_id":id})
    setTimeout(function(){
        destroy(formIframe);
    },500);
    getNewMessages();
}
function sendMessage(id){
    var formIframe=post("/send_message.html",{"post_content":document.getElementById("post_content").value})
    document.getElementById('post_content').value='';
    setTimeout(function(){
        destroy(formIframe);
    },500);
    getNewMessages();
}
function likeMessage(id){
    var formIframe=post("/like_message.html",{"message_id":id})
    setTimeout(function(){
        destroy(formIframe);
    },500);
    getNewMessages();
}
function getRandomID(){
    var text = "";
    var possible = "azertyuiopqsdfghjklmwxcvbn";
    for( var i=0; i < 5; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}
function orderByDate(){
    document.getElementById("order").value="date";
    getNewMessages();
}
function orderByLike(){
    document.getElementById("order").value="like";
    getNewMessages();
}
function post(url,data){
    // use the form to fill the iframe (wait a litle before getting the result and remove created elements to avoid memory eating)
    var iframe=document.createElement("iframe");
    var iframeid="hidden_iframe_receive_"+getRandomID();
    iframe.setAttribute("style", "visibility: hidden;height:0;width:0;");
    iframe.setAttribute("name",iframeid);
    iframe.setAttribute("id",iframeid);
    var form = document.createElement("form");
    form.setAttribute("style", "visibility: hidden;height:0;width:0;");
    form.setAttribute("method", "post");
    form.setAttribute("action", url);
    form.setAttribute("target", iframeid);
    for(var key in data) {
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", key);
        hiddenField.setAttribute("value", data[key]);
        form.appendChild(hiddenField);
    }
    document.body.appendChild(iframe);
    document.body.appendChild(form);
    form.submit();
    return [form,iframe];
}
