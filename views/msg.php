<div class="clear"></div><div class=wrap'>
<div class="msg_<?php echo  $msg[1] ?>"><p><?php echo $msg[0]; ?></p></div>
</div> 
<style>
    .msg_error{
        background:#FFC8D3;
        border:1px solid #FF0A3B;
    }
    .msg_notification{
        background:#C6F7C7;
        border:1px solid #10F714;
    }
    
    .msg_error, .msg_notification{
        border-radius:4px;
        padding:10px;
        margin:15px 0;
        box-shadow: 0 0 0 1px 1px;
    }
    .msg_error p, .msg_notification p{
        font-size:1.25em;
    }
    
</style>