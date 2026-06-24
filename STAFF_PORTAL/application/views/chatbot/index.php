<!doctype html>
<html>
    <head>
        <title>ChatBot Widget</title>
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700,800" rel="stylesheet">
        <link href="<?=base_url()?>assets/chatbot/index.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    </head>
    <body>
        <section class="chat-msger-root">
            <main class="chat-msger-main">        
                    
            </main>
            <form class="chat-msger-inputarea">
                <div class="input-group mb-3 p-1">
                    <label id="chatOptionCollapseButton" data-collapsed="false" class="input-group-text" data-toggle="collapse" data-target="#chat-option-collapse">
                        <i style="font-size:1.3em;" class="fas fa-th-list"></i>
                    </label>
                    <select class="custom-select chat-msger-input">
                        <option value="" selected>Choose...</option>
                    </select>
                    <label class="input-group-text btn btn-primary chat-msger-send-btn">
                        <i style="font-size:1.3em;" class="fas fa-paper-plane"></i>
                    </label>
                </div>
                <div class="collapse multi-collapse" id="chat-option-collapse">
                    <div class="collapse-card-container mb-4">
                        <!-- <button data-reqtext="Help Guide" data-reqkey="SHOW_GENERAL_HELP_GUIDE" type="button" class="btn btn-primary btn-sm chat-msger-send-btn">
                            <i class="fas fa-question-circle"></i><span class="pl-2">Help Guide</span>
                        </button> -->
                        <button data-reqText="Upcoming Exams" data-reqKey="GET_EXAMS" type="button" class="btn btn-danger btn-sm chat-msger-send-btn">
                            <i class="fas fa-book-reader"></i><span class="pl-2">Exams</span>
                        </button>
                        <button data-reqText="Holidays" data-reqKey="GET_HOLIDAYS" type="button" class="btn btn-success btn-sm chat-msger-send-btn">
                            <i class="fas fa-calendar-day"></i><span class="pl-2">Holidays</span>
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </body>      
    <script src="<?=base_url()?>assets/chatbot/jquery.min.js"></script>    
    <script src="<?=base_url()?>assets/chatbot/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous" async></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous" async></script>
    <script src='<?=base_url()?>assets/chatbot/helper.js'></script>
    <script>
        $(document).ready(()=>{
            const botIMG = "<?=base_url()?>assets/chatbot/chat_logo.png";
            const userIMG = "<?=$this->session->userdata('photo_url');?>" || "<?=base_url()?>assets/chatbot/chat-default-user.png";
            const name= "<?=$this->session->userdata('name');?>";
            //ChatBot.initiateChatBot("Name of Responder, Image of Responder, Name of Sender, Image of Sender, Base URL");
            ChatBot.initiateChatBot("SJPUC",botIMG,name,userIMG,"<?=base_url()?>");
        });
    </script>
</html>