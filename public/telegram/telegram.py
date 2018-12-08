import requests



if __name__=="__main__":
    url="https://api.telegram.org/bot609116902:AAHT0wmU_k1ICQ6s3aLQBpaoEUy4CDSXhcY/sendMessage?chat_id=613744501&text=你好吗？大帅"
    response=requests.requst("GET",url=url)
    print response.text
    print "link over!"