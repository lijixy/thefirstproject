import requests
import json
import sys
sys.path.append(r'/data/wwwroot/wallet/storage/pythonconfig')
from config import configinit

class botApi:
    def __init__(self):
        self.token_api_key = ""

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
    print "history"+str(getHistoryNum)
    #chat_id="-279383587"
    #-1001379081728
    chat_id="-1001379081728"

    #Welcome to ELLIPAL Global!

    #As gift, please click the link to receive CCT:
    #http://wallet.ellipal.com/award?type=telegram

    botApi=botApi()
    getLastNum=botApi.getGroupNumberNow(chat_id)
    print "lastnum"+str(getLastNum)
    #r.set("telegramNum",getLastNum)

    if int(getLastNum)>int(getHistoryNum):
        r.set("telegramNum", getLastNum)
        result=botApi.senMessage(chat_id,message="Welcome to ELLIPAL Telegram group.\n\nPLEASE READ: \nBecareful of scammers, ELLIPAL team will never ask for your personal information or ask you for deposits. We also will not actively ask you if you have any problems. These are our official admins you can talk to: @Ellipal001 @ELLIPALteam @laurenELLIPAL. \n\nScammers can use similar letters to fake the username so please still be careful eventhough it looks the same.")
        if result:
            print "new people!"
            quit()
    if int(getLastNum)<int(getHistoryNum):
        r.set("telegramNum", getLastNum)
        print "people leave now!"

    print "link over!"
