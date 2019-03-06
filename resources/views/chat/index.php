<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-03-05
 * Time: 17:44
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>
<style>
    .container {
        margin-top: 2%;
    }
</style>
<body>
<div class="container">
    <div id="app">
        <h3 class="offset-md-3">{{ userName }}</h3>
        <div class="alert alert-warning col-sm-7">
            <strong>警告!</strong> 你们的聊天信息已经被全程监控...
        </div>
        <div v-for="(value, key) in list" :class="className(value.uid)" >
            {{ value.content }}
        </div>
        <div>
            <form action="" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="远在光年之外的你们，想聊些什么呢..." v-model="content" required="required">
                    </div>
                </div>
                <button type="submit" class="btn btn-info offset-md-6" @click.prevent="pushData">发送</button>
            </form>
        </div>
    </div>
</div>
<script>

    var ws = new WebSocket('ws://192.168.5.181:81/chat')
    ws.onopen = function() {
        var data = {
            'sendUid': vm.$data.uid,
            'type': 'bind',
            'receiveUid': '',
        }
        // 将uid推送到服务端，与fd进行绑定
        ws.send(JSON.stringify(data));
    }
    ws.onmessage = function(evt) {
        var data = JSON.parse(evt.data)
        if (data.content) {
            vm.$data.list.push(data)
        }
    }
    ws.onclose = function() {
        console.log('连接关闭')
    }

    var vm = new Vue({
        el: "#app",
        data: {
            list: [],
            content: '',
            uid: <?=$uid?>,
            receiveUid: <?=$receiveUid?>,
            userName: '<?=$userName?>',
        },
        methods: {
            className(uid) {
                if (uid === this.uid) {
                    return 'alert alert-success col-md-2'
                } else {
                    return 'alert alert-danger col-md-2 offset-md-5'
                }
            },
            pushData() {
                let data = {
                    'sendUid': this.uid,
                    'receiveUid': this.receiveUid,
                    'content': this.content,
                    'type': 'chat'
                }
                ws.send(JSON.stringify(data));
                this.content = ''
            }
        },

    })
</script>
</body>
</html>