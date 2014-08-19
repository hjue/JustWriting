Date: 2014-08-11
Title: 测试代码高亮的数学公式
intro:用于测试
Tags: 测试 test
Status: public



测试一下数学公式和尾注[^LaTeX]: 

$$E=mc^2$$

支持 **LaTeX** 编辑显示支持，例如：$\sum_{i=1}^n a_i=0$和$[((n-k)/i+m)]$， 访问 [MathJax][4] 参考更多使用方法。




```
POST /task?id=1 HTTP/1.1
Host: example.org
Content-Type: application/json; charset=utf-8
Content-Length: 137

{
  "status": "ok", 
  "extended": true,
  "results": [
    {"value": 0, "type": "int64"},
    {"value": 1.0e+3, "type": "decimal"}
  ]
}
```