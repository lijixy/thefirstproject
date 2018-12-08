import requests
import json
import sys
sys.path.append(r'/data/wwwroot/wallet/storage/pythonconfig')
from config import configinit

class botApi:
    def __init__(self):
        self.token_api_key="bot609116902:AAHT0wmU_k1ICQ6s3aLQBpaoEUy4CDSXhcY"

    def getGroupNumberNow(self,chat_id):
        url="https://api.telegram.org/"+self.token_api_key+"/getChatMembersCount?chat_id="+chat_id
        responseJsonNumber=requests.request("GET",url)
        jsonArr=json.loads(responseJsonNumber.text)
        return jsonArr["result"]
    def senMessage(self,chat_id,message):
        url = "https://api.telegram.org/" + self.token_api_key + "/sendMessage?chat_id=" + chat_id+"&text="+message
        responseJsonNumber = requests.request("GET", url)
        jsonArr = json.loads(responseJsonNumber.text)
        return jsonArr["ok"]



if __name__=="__main__":
    confignew = configinit()
    r = confignew.getRedisInit()
    getHistoryNum=r.get("telegramNum")
    chat_id="-279383587"

    botApi=botApi()
    getLastNum=botApi.getGroupNumberNow(chat_id)
    r.set("telegramNum",getLastNum)

    if int(getLastNum)!=int(getHistoryNum):
        result=botApi.senMessage(chat_id,message="Hello-new-people!")
        if result:
            print "new people!"
            quit()
    print "link over!"