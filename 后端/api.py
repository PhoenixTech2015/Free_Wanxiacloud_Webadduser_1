import json
import flask
import subprocess
from flask import Flask, request

# 创建 Flask 应用
server = flask.Flask(__name__)


# 定义 API 路由
@server.route('/api', methods=['get', 'post'])
def api():
    name = request.values.get('name')  # 获取 url 请求传的用户名，明文
    pwd = request.values.get('pwd')  # 获取 url 请求传的密码，明文
    key ="1"
    if key and name and pwd:
        if name in {"Administrator", "admin"}:
            resu = {"msg": "禁止创建此用户名"}
            return json.dumps(resu, ensure_ascii=False)
        if name == "yiluo":
            resu = {"msg": "您是黑名单人员"}
            return json.dumps(resu, ensure_ascii=False)
#如果key是1
        if key == "1":
            print_log = open("log.txt", 'a')
            print({"用户名": name, "密码": pwd}, file=print_log)
            print_log.close()

            cmd_add_user = "net user %s /add" % name
            ps_add_user = subprocess.Popen(cmd_add_user, shell=True)
            ps_add_user.wait()

            cmd_set_password = "net user %s %s" % (name, pwd)
            ps_set_password = subprocess.Popen(cmd_set_password, shell=True)
            ps_set_password.wait()

            resu = {"msg": "开户成功！"}
            return json.dumps(resu, ensure_ascii=False)
    else:
        resu = {"msg": "缺少参数"}
        return json.dumps(resu, ensure_ascii=False)

# 启动服务器
if __name__ == '__main__':
    # server.run(debug=True, port=12300, host='0.0.0.0')
    server.run(port=12300, host='0.0.0.0')
