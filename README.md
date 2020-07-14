# Express api service for Kuaidi100
### Run from source
```
git clone https://github.com/loadmemo/express.git
docker build -t express .
# run with KEY
docker run -d --name express -e KEY="1234567890" -p 9090:80 express
# run wihout KEY
docker run -d --name express -p 9090:80 express
```
### Run from image
```
docker pull zikloa/express
# run with KEY
docker run -d --name express -e KEY="1234567890" -p 9090:80 express
# run wihout KEY
docker run -d --name express -p 9090:80 express
```

---
### API
#### method
```
GET
```
#### request
```
sn: express sn  eg: 'YT4629130296173'
code: express company code eg:'yuantong'
key: if you run with KEY
```
#### response
```
{
  "message": "ok",
  "nu": "YT4629130296173",
  "ischeck": "1",
  "condition": "F00",
  "com": "yuantong",
  "status": 1,
  "state": "3", 快递单状态:0在途,1揽收,2疑难,3签收,4退签,5派件,6退回,7转单,10待清关,11清关中,12已清关,13清关异常,14收件人拒签
  "data": [
    {
      "time": "2020-07-01 17:09:24",
      "ftime": "2020-07-01 17:09:24",
      "context": "客户签收人: 门卫 已签收 感谢使用圆通速递，期待再次为您服务 如有疑问请联系：17521615014，投诉电话：021-67222227",
      "location": ""
    },
    {
      "time": "2020-07-01 13:30:44",
      "ftime": "2020-07-01 13:30:44",
      "context": "【上海市金山区新城公司】 派件中 派件人: 高志勇 电话 17521615014 如有疑问，请联系：021-67222227",
      "location": ""
    },
    {
      "time": "2020-07-01 13:27:19",
      "ftime": "2020-07-01 13:27:19",
      "context": "【上海市金山区新城公司】 已收入",
      "location": ""
    },
    {
      "time": "2020-07-01 09:17:56",
      "ftime": "2020-07-01 09:17:56",
      "context": "【浦东转运中心】 已发出 下一站 【上海市金山区新城公司】",
      "location": ""
    },
    {
      "time": "2020-07-01 08:55:57",
      "ftime": "2020-07-01 08:55:57",
      "context": "【浦东转运中心公司】 已收入",
      "location": ""
    },
    {
      "time": "2020-06-30 23:11:59",
      "ftime": "2020-06-30 23:11:59",
      "context": "【温州转运中心】 已发出 下一站 【浦东转运中心公司】",
      "location": ""
    },
    {
      "time": "2020-06-30 22:50:59",
      "ftime": "2020-06-30 22:50:59",
      "context": "【温州转运中心公司】 已收入",
      "location": ""
    },
    {
      "time": "2020-06-30 19:59:03",
      "ftime": "2020-06-30 19:59:03",
      "context": "【福建省宁德市福鼎市】 已发出 下一站 【温州转运中心公司】",
      "location": ""
    },
    {
      "time": "2020-06-30 19:39:50",
      "ftime": "2020-06-30 19:39:50",
      "context": "【福建省宁德市福鼎市公司】 已打包",
      "location": ""
    },
    {
      "time": "2020-06-30 19:20:49",
      "ftime": "2020-06-30 19:20:49",
      "context": "【福建省宁德市福鼎市公司】 已收件 取件人: 庄千市 (18521107024)",
      "location": ""
    }
  ]
}
```