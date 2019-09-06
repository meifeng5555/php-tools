# httpServer
## 使用
```
[A]$ php httpServer
[A]$ php httpServer --port 12580 
[A]
[A][2019-09-06 02:49:50]: httpServer building ...
[A][2019-09-06 02:49:50]: httpServer built success
[A][2019-09-06 02:49:50]: waiting request ...

[B]$ curl "http://127.0.0.1:12580" -d "hello world"
[B]{"request":{"header":{"User-Agent":" curl\/7.29.0\r","Host":" 127.0.0.1","Accept":" *\/*\r","Content-Length":" 11\r","Content-Type":" application\/x-www-form-urlencoded\r"},"body":"hello world","method":"POST","uri":"\/","version":"HTTP\/1.1"},"response":{"code":0,"msg":"connect success"}}
[B]$ curl "http://127.0.0.1:12580" -d "exit"
[B]{"request":{"header":{"User-Agent":" curl\/7.29.0\r","Host":" 127.0.0.1","Accept":" *\/*\r","Content-Length":" 4\r","Content-Type":" application\/x-www-form-urlencoded\r"},"body":"exit","method":"POST","uri":"\/","version":"HTTP\/1.1"},"response":{"code":0,"msg":"connect success"}}

[A][2019-09-06 05:23:19]: ------------------------------------------
[A][2019-09-06 05:23:19]: request_time: 1567747399
[A]POST / HTTP/1.1
[A]User-Agent: curl/7.29.0
[A]Host: 127.0.0.1:12581
[A]Accept: */*
[A]Content-Length: 11
[A]Content-Type: application/x-www-form-urlencoded
[A]
[A]hello world
[A][2019-09-06 05:23:19]: this request end, waiting next request ...
[A][2019-09-06 05:23:19]: ------------------------------------------
[A][2019-09-06 05:25:42]: ------------------------------------------
[A][2019-09-06 05:25:42]: request_time: 1567747542
[A]POST / HTTP/1.1
[A]User-Agent: curl/7.29.0
[A]Host: 127.0.0.1:12581
[A]Accept: */*
[A]Content-Length: 4
[A]Content-Type: application/x-www-form-urlencoded
[A]
[A]exit
[A][2019-09-06 05:25:42]: this request end, waiting next request ...
[A][2019-09-06 05:25:42]: ------------------------------------------
[A][2019-09-06 05:25:42]: this server has closed, Bye Bye !!!
```
## 参数解析
> --port  绑定的端口,缺省值12580
