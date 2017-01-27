document.addEventListener('DOMContentLoaded', function() {
    getNewMessages()
    getNewMessageLoop();
}, false);

function setAndDestroy(form){
    var sc=(window.innerHeight + window.scrollY) >= document.body.offsetHeight;
    document.getElementById("forum_div").innerHTML=document.getElementById("hidden_iframe_receive").contentWindow.document.body.innerHTML;
    document.body.removeChild(form);
    if(sc){
        window.scrollTo(0,document.body.scrollHeight);
    }
}

function getNewMessageLoop(){
    setInterval(function(){
        getNewMessages();
    },3000);
}
function getNewMessages() {
    var form = post("/get_messages.html",{});//{"TIMESTAMP":Date.now()-3000}
    setTimeout(function(){
        setAndDestroy(form);
    },500);
}

function deleteMessage(id){
    post("/delete_message.html",{"message_id":id})
}

function post(url,data){
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("style", "visibility: hidden;height:0;width:0;");
    form.setAttribute("action", url);
    form.setAttribute("target", "hidden_iframe_receive");
    for(var key in data) {
        if(data.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", data[key]);
            form.appendChild(hiddenField);
         }
    }
    document.body.appendChild(form);
    form.submit();
    return form;
}