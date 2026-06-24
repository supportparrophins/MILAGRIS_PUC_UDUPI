const morningTime = [4, 0, 0];
const afterNoonTime = [12, 0, 0];
const eveningTime = [17, 0, 0];
const SENDER_REQUESTS = [
    // { key:"SHOW_GENERAL_HELP_GUIDE", isStatic: true, value:"Please show me help guide", initText:"Here is your help guide"},
    { key:"GET_NOTIFICATIONS", value:"Please get me my latest notifications", initText:"Here is your latest notifications"},
    { key:"GET_HOLIDAYS", value:"Please list upcoming holidays", initText:"Here is your upcoming holidays"},
    { key:"GET_EXAMS", value:"Could you just list upcoming exams?", initText:"Here is exam's list", instantReply:"Certainly, Just give me a minute"},
]

class ChatBot{
    static RESPONDER_NAME;
    static PERSON_NAME;
    static RESPONDER_IMG;
    static PERSON_IMG;
    static msgerSubmitButton;
    static msgerInput;
    static msgerChat;
    static apiURL;

    static getStaticReplies(reqKey){
        if(reqKey == "SHOW_GENERAL_HELP_GUIDE"){
            const link = '../assets/downloads/STUDENT_GUIDE_FOR_ONLINE_ADMISSION_PROCEDURE_2020.pdf';
            return `<a href='${this.apiURL+link}' target='_blank' class='btn btn-light'>Open Help Guide<i class='fas fa-external-link-alt ml-1'></i></a>`;
        }
        else return false;
    }
    static getCustomizedDate(format="",argDate = new Date()){
        let tempDate, tempMonth, tempYear, tempHour, tempMin;
        tempDate = argDate.getDate();
        tempMonth = argDate.getMonth() + 1;
        tempYear = argDate.getFullYear();
        tempHour = argDate.getHours();
        tempMin = argDate.getMinutes();
        if(tempDate < 10) tempDate = "0"+tempDate;
        if(tempMonth < 10) tempMonth = "0"+tempMonth;
    
        if(format.trim()=="yyyy-mm-dd"){
            return tempYear + "-" +  tempMonth + "-" + tempDate; 
        }else if(format.trim()=="dd-mm-yyyy"){
            return tempDate + "-" +  tempMonth + "-" + tempYear; 
        }else if(format.trim()=="hh:mm:ss"){
            tempHour %= 12;
            if(tempHour==0) tempHour=12;
            if(tempMin < 10) tempMin = "0"+tempMin;
            return tempHour + ":" +  tempMin + ":" + argDate.toLocaleTimeString().slice(-2); 
        }else{
            return argDate;
        }
    }
    static incrementChatCount(count=1){
        let tempCount = Number($('.floating-chat-badge').html());
        tempCount += count;
        $('.floating-chat-badge').html(tempCount)
    }
    static appendMessage(name, img, side, text){
        const msgHTML = `
                <div class="chat-msg ${side}-msg">
                    <div class="msg-img" style="background-image: url(${img})"></div>

                    <div class="msg-bubble">
                        <div class="msg-info">
                        <div class="msg-info-name">${name}</div>
                        <div class="msg-info-time">${this.getCustomizedDate('hh:mm:ss')}</div>
                        </div>

                        ${text}
                    </div>
                </div>
            `;
        this.msgerChat.append(msgHTML);
        $(this.msgerChat).scrollTop( $(this.msgerChat).scrollTop()+500 );
        this.incrementChatCount();
    }
    static setRequestView(reqText,reqKey){
        if (!reqKey) return;
        this.appendMessage(this.PERSON_NAME, this.PERSON_IMG, "right", `<span class="white-text">${reqText}</span>`);
        this.msgerInput.val('');
        this.respond(reqKey);
    }
    static setTypingView(){
        let typingView = '<div class="chat-msg left-msg chat-typing"><div class="msg-img" style="background-image: url('+ this.RESPONDER_IMG +')"></div>'+
                            '<div class="chat-bubble"><div class="typing"><span class="typing-span">typing<span> <div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>' +
                                '</div>';
        this.msgerChat.find('div.chat-typing').remove();
        this.msgerChat.append(typingView);
        $(this.msgerChat).scrollTop( $(this.msgerChat).scrollTop()+500 );
    }
    static setInitialChatView(){
        const[currTime,mt,ant,et]  = [new Date(),new Date(),new Date(),new Date()];
        let greetingText = "";
        mt.setHours(...morningTime);
        ant.setHours(...afterNoonTime);
        et.setHours(...eveningTime);
        if(currTime.getTime() >= mt.getTime() && currTime.getTime() < ant.getTime()){
            greetingText = "Good Morning..!";
        }else if(currTime.getTime() >= ant.getTime() && currTime.getTime() < et.getTime()){
            greetingText = "Good Afternoon..!";
        }else{
            greetingText = "Good Evening..!";
        }
        let initialChat='<div class="chat-msg left-msg">' +
                            '<div class="msg-img" style="background-image: url('+ this.RESPONDER_IMG +')"></div>' +
                            '<div class="msg-bubble">' +
                                '<div class="msg-info">' +
                                    '<div class="msg-info-name">'+ this.RESPONDER_NAME +'</div>' +
                                    '<div class="msg-info-time">'+ this.getCustomizedDate("hh:mm:ss") +'</div>' +
                                '</div>' +
                                '<div class="chat-msg-text black-text">' +
                                    'Hi, '+ greetingText +' Is there something I can do for you?' +
                                '</div>' +
                            '</div>' +
                        '</div>';
        this.msgerChat.html(initialChat);
    }
    static respond(reqKey){
        setTimeout(()=>{this.setTypingView()},1000);
        let initialReply,instantReply, isStatic;
        SENDER_REQUESTS.forEach(req=>{
            if(req.key==reqKey){
                initialReply=req.initText;
                instantReply=req.instantReply;
                isStatic=req.isStatic;
            }
        });
        if(isStatic){       
            (initialReply) && setTimeout(()=>{this.appendMessage(this.RESPONDER_NAME, this.RESPONDER_IMG, "left", `<span class="black-text">${initialReply}</span>`)},3000);     
            setTimeout(()=>{this.staticReply(reqKey)},3000);
        }else{
            (instantReply) && setTimeout(()=>{this.appendMessage(this.RESPONDER_NAME, this.RESPONDER_IMG, "left", `<span class="black-text">${instantReply}</span>`)},3000);
            setTimeout(()=>{this.apiRequest(this.apiURL+reqKey,initialReply)},6000);
        }
    }
    static staticReply(reqKey){
        const reply = this.getStaticReplies(reqKey);
        this.msgerChat.find('div.chat-typing').remove();
        if(reply){
            setTimeout(()=>{this.appendMessage(this.RESPONDER_NAME, this.RESPONDER_IMG, "left", reply)},1000);
        }else{
            this.appendMessage(this.RESPONDER_NAME, this.RESPONDER_IMG, "left", `<span class="black-text">Oops..! Something went wrong. Try again.</span>`);            
        }
    }
    static apiRequest(reqURL,initialReply){
        $.post(reqURL).done(responseText=>{
            this.msgerChat.find('div.chat-typing').remove();
            responseText && initialReply && this.appendMessage(this.RESPONDER_NAME, this.RESPONDER_IMG, "left", `<span class="black-text">${initialReply}</span>`);
            if(responseText=="") responseText=`<span class="black-text">There is nothing to display.</span>`;
            setTimeout(()=>{this.appendMessage(this.RESPONDER_NAME, this.RESPONDER_IMG, "left", responseText)},2000);
        }).catch(err=>{
            console.log("Error:",err);
            this.msgerChat.find('div.chat-typing').remove();
            this.appendMessage(this.RESPONDER_NAME, this.RESPONDER_IMG, "left", `<span class="black-text">Oops..! Something went wrong. Try again.</span>`);
        });
    }
    static initiateChatBot(respName,respIMG,personName,personIMG,rootURL){
        this.RESPONDER_NAME = respName || "RESPONDER";
        this.RESPONDER_IMG = respIMG;
        this.PERSON_NAME = personName || "SENDER";
        this.PERSON_IMG = personIMG;
        this.apiURL = rootURL+"/chatBot/";
        this.msgerInput = $(".chat-msger-input");
        this.msgerChat = $(".chat-msger-main");
        this.msgerSubmitButton = $('.chat-msger-send-btn');
        SENDER_REQUESTS.forEach(({key,value})=>{
            this.msgerInput.append(`<option value=${key}>${value}</option>`);
        });
        this.setInitialChatView();
        const $this = this;
        this.msgerSubmitButton.on('click',function() {
            let reqText, reqKey;
            if($(this).is('button')){
                reqText = $(this).data('reqtext');
                reqKey = $(this).data('reqkey');
            }else{
                reqText = $this.msgerInput.find('option:selected').text();
                reqKey = $this.msgerInput.val();
            }
            $this.setRequestView(reqText, reqKey);
        });
    } 
}