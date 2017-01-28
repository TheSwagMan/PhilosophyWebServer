document.addEventListener('DOMContentLoaded', function() {
    getNewMessages()
    getNewMessageLoop();
}, false);

function setAndDestroy(formIframe){
    var sc=(window.innerHeight + window.scrollY) >= document.body.offsetHeight;
    document.getElementById("forum_div").innerHTML=formIframe[1].contentWindow.document.body.innerHTML;
    destroy(formIframe);
    if(sc){
        window.scrollTo(0,document.body.scrollHeight);
    }
}
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
    var todel = post("/get_messages.html",{});//{"TIMESTAMP":Date.now()-3000}
    setTimeout(function(){
        setAndDestroy(todel);
    },500);
}

function deleteMessage(id){
    var formIframe=post("/delete_message.html",{"message_id":id})
    setTimeout(function(){
        destroy(formIframe);
    },500);
}

function likeMessage(id){
    var formIframe=post("/like_message.html",{"message_id":id})
    setTimeout(function(){
        destroy(formIframe);
    },500);
}
function getRandomID(){
    var text = "";
    var possible = "azertyuiopqsdfghjklmwxcvbn";
    for( var i=0; i < 5; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}
function post(url,data){
    // use the form to fill the iframe (wait a litle before getting the result and remove created elements to avoid memory eating)
    var iframe=document.createElement("iframe");
    var iframeid="hidden_iframe_receive_"+getRandomID();
    iframe.setAttribute("style", "visibility: hidden;height:0;width:0;");
    iframe.setAttribute("name",iframeid);
    iframe.setAttribute("id",iframeid);
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("style", "visibility: hidden;height:0;width:0;");
    form.setAttribute("action", url);
    form.setAttribute("target", iframeid);
    for(var key in data) {
        if(data.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", data[key]);
            form.appendChild(hiddenField);
         }
    }
    document.body.appendChild(iframe);
    document.body.appendChild(form);
    form.submit();
    return [form,iframe];
}
