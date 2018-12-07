pragma solidity ^0.4.24;
contract Actionjoin {
    // 抽奖参数
    // 抽检的开始时间 和 结束时间 （以秒为单位的出块时间）
    // 受益人 累计奖金额
    address[50] joinActivity;   //参与活动的地址组初始化
    uint8 count=0;                      //已经参与的个数
    uint nonce=0;
    //uint activityEndTime=0;             //本期活动的结束时间  备用
    uint amoutAll=0;                    //本期活动当前累计总金额
    
    mapping(uint => address) public joinPeoples;        //记录所有的参与者
    //mapping(uint => uint) public joinBlock;           //记录所有参与者的块
    mapping(uint => uint) public joinTimeStamp;         //记录所有参与者的时间戳
    mapping(uint => uint) public winnerPeoples;         //记录所有的获奖者
    mapping(uint => uint) public winMoney;              //记录所有获奖的金额
    uint public historyWinNum=0;                        //历史获奖人数
    uint public historyJoinNum=0;                       //记录上一期已经参加过的人数
    uint public lastJoinNum=0;                          //当前已经参加的全部人数
    uint public currentActionTime=0;                    //设置当前活动的结束时间
    
    
    //uint public lastJoinBlockNum=0;
    
    
    address public actionSetAddr=address(this);
    
    
    //设置开启者地址
    /*
    function setActionStarter() public{
        actionSetAddr=address(this);
    }
    */

    //活动时间开启
    function getActionStartTime(uint startTime) public{
        if(actionSetAddr!=msg.sender){
            return ;
        }
        require(startTime>now,"starttime is not correct!");
        
        currentActionTime=startTime;
        actionSetAddr=msg.sender;
    } 
    
    function joinActivityDraw() public payable{
        //过滤开奖账号
        require(actionSetAddr!=msg.sender,"joiner is the owner!");
        //判断活动时间是否有效
        require(currentActionTime>now,"action is not started!");
        //require(now<currentActionTime,"action is not ended!");
        //大于1个eth转账 才可以参与
        require(msg.value>=1500000000000000000,"amount is not enough 1.5 eth!");
        //限制参与数为50个
        require(count<50,"has been max num");
        //判断活动是不是开始 
        //require(activityEndTime==0,"activity is not started!");
        //判断转账是否发生在互动期限期间
        //require(block.timestamp<activityEndTime,"activity is allready done!");
        //actionSetAddr.transfer(msg.value);
        
        joinActivity[count]=msg.sender;
        joinPeoples[lastJoinNum++]=msg.sender;   //lastJoinNum当前参与的所有人数
        //joinBlock[lastJoinNum]=block.number;
        //lastJoinBlockNum=block.number;
        joinTimeStamp[lastJoinNum]=now;  
        amoutAll=amoutAll+msg.value;
        count++;
        historyJoinNum=lastJoinNum-count;       //historyJoinNum已经参加过抽奖的人数
        if(count==50 || now>=currentActionTime){
            produceWinnerAndAmount();
        }
        
    }
    //随机计算获奖者
    function produceWinnerAndAmount() private returns(address,uint) {
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
        currentActionTime=0;
        return (winner,amountMoney);
    }
    //计算获奖编号
    function winnerNum() private returns(uint) {
        uint winner = uint(keccak256(abi.encodePacked(now, msg.sender, nonce))) % count;
        nonce++;
        return winner;
    }

}