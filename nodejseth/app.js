var Web3 = require('web3')
var web3 = new Web3(new Web3.providers.HttpProvider('http://localhost:7545'))


let source="pragma solidity >=0.4.17 <0.6.0;

contract Donation {
    // 抽奖参数
    // 抽检的开始时间 和 结束时间 （以秒为单位的出块时间）
    // 受益人 累计奖金额
    address payable[50] joinActivity;   //参与活动的地址组初始化
    uint8 count=0;                      //已经参与的个数
    uint nonce=0;
    //uint activityEndTime=0;             //本期活动的结束时间  备用
    uint amoutAll=0;                    //本期活动当前累计总金额
    
    mapping(uint => address) public joinPeoples;        //记录所有的参与者
    mapping(uint => uint) public winnerPeoples;         //记录所有的获奖者
    mapping(uint => uint) public winMoney;              //记录所有获奖的金额
    uint public historyWinNum=0;                          //历史获奖人数
    uint public historyJoinNum=0;                       //记录上一期已经参加过的人数
    uint public lastJoinNum=0;                          //当前已经参加的全部人数 
    
     
    
    function joinActivityDraw() public payable{
        //大于1个eth转账 才可以参与
        //require(msg.value>1 ether,"amount is not enough 1 eth!");
        //限制参与数为15个
        require(count<50,"has been max num");
        //判断活动是不是开始 
        //require(activityEndTime==0,"activity is not started!");
        //判断转账是否发生在互动期限期间
        //require(block.timestamp<activityEndTime,"activity is allready done!");
        
        
        joinActivity[count]=msg.sender;
        joinPeoples[lastJoinNum++]=msg.sender;   //lastJoinNum当前参与的所有人数
        amoutAll=amoutAll+msg.value;
        count++;
        historyJoinNum=lastJoinNum-count;       //historyJoinNum已经参加过抽奖的人数
        if(count==50){
            produceWinnerAndAmount();
        }
        
    }
    //随机计算获奖者
    function produceWinnerAndAmount() private returns(address,uint) {
        require(count == 50);
        //,address,address,address,address,address,address,address,address,address,address,address,address,address,address,address
        
        
        address winner=joinActivity[winnerNum()];
        /*
        for(uint i=historyJoinNum;i<lastJoinNum;i++){
            if(joinPeoples[i]==winner){
                winnerPeoples[historyWinNum++]=i;
                winMoney[historyWinNum]=amoutAll;
                break;
            }
        }
        */
        //登记获奖人
        winnerPeoples[historyWinNum++]=winnerNum()+1+historyJoinNum;
        //记录本期获奖金额
        winMoney[historyWinNum]=amoutAll;
        joinActivity[winnerNum()].transfer(amoutAll*3/10);
        uint amountMoney=amoutAll*3/10;
        delete joinActivity;
        amoutAll=0;
        count = 0;
        //,address1,address2,address3,address4,address5,address6,address7,address8,address9,address10,address11,address12,address13,address14,address15
        return (winner,amountMoney);
    }
    //计算获奖编号
    function winnerNum() private returns(uint) {
        uint winner = uint(keccak256(abi.encodePacked(now, msg.sender, nonce))) % 50;
        nonce++;
        return winner;
    }

}";

console.log(web3.eth.accounts)