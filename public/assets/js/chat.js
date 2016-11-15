//server add 159.203.78.168:3000
var socket      = io.connect("127.0.0.1:3000");
var data        = {};
var auth        = $('input[name=auth]').val();
var SelectedFile = {};
var FReader, Name ,SelectedFile;
if(auth)
  data = JSON.parse(auth);

data.receiver   = $('input[name=receiver]').val();

$(document).ready(function() {
  if(typeof(data.receiver) !="undefined"){
    socket.emit('setup',data);
  }
  else{
    socket.emit('online',data);
  }

  $('#chatbtn').click(function(){
    data.message    = $('#message').val();
    if(data.message == '')
      return false;
    sendMessage();
  })

  $('#message').keydown(function(event){
      if(event.which == 13){
        data.message    = $('#message').val();
        if(data.message == '')
          return false;
        sendMessage();
      }
      socket.emit('typing',data);
  });

  socket.on('receiver',function(data){
    var message  =  '<p>'+data.message+'</p>';
    var html = '<li class="left bg-white"><span class="chat-img pull-left"><img src="/assets/img/user.png" alt="User Avatar"></span><div class="chat-body"><div class="header"><strong class="primary-font user-name-bold">'+data.name+'</strong><small class="pull-right text-muted"><i class="fa fa-clock-o"></i> Now</small></div>'+message+'</div></li>';
    $('.chat').append(html);
     $("html, body").animate({ scrollTop: $(document).height() }, 1000);
  });

function sendMessage(){
  $('#message').val('');
  var message  =  '<p>'+data.message+'</p>';
  socket.emit('chat',data);
  var html = '<li class="right bg-white"><span class="chat-img pull-right"><img src="/assets/img/user.png" alt="User Avatar"></span><div class="chat-body"><div class="header"><strong class="primary-font user-name-bold">'+data.name+'</strong><small class="pull-right text-muted"><i class="fa fa-clock-o"></i>Now</small></div>'+message+'</div></li>';
  $('.chat').append(html);
  $("html, body").animate({ scrollTop: $(document).height() }, 1000);
}

});
