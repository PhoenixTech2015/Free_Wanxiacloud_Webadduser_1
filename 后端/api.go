package main

import (
	"fmt"
	"io/ioutil"
	"net/http"
	"os/exec"
	"strings"
)

func main() {
	http.HandleFunc("/api", api)
	err := http.ListenAndServe(":12300", nil)
	if err != nil {
		fmt.Println("Error:", err)
	}
}

func api(w http.ResponseWriter, r *http.Request) {
	name := r.URL.Query().Get("name")
	pwd := r.URL.Query().Get("pwd")
	key := "1"

	if key != "" && name != "" && pwd != "" {
		if strings.Contains(name, "Administrator") || strings.Contains(name, "admin") {
			fmt.Fprintf(w, "{\"msg\": \"禁止创建此用户名\"}")
			return
		}
		if name == "yiluo" {
			fmt.Fprintf(w, "{\"msg\": \"您是黑名单人员\"}")
			return
		}

		if key == "1" {
			log := fmt.Sprintf("{\"用户名\": \"%s\", \"密码\": \"%s\"}", name, pwd)
			ioutil.WriteFile("log.txt", []byte(log), 0666)

			cmdAddUser := fmt.Sprintf("net user %s /add", name)
			cmdSetPassword := fmt.Sprintf("net user %s %s", name, pwd)

			exec.Command(cmdAddUser).Run()
			exec.Command(cmdSetPassword).Run()

			fmt.Fprintf(w, "{\"msg\": \"开户成功！\"}")
			return
		}
	}
	fmt.Fprintf(w, "{\"msg\": \"缺少参数\"}")
}

