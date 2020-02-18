<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?> </h1>
    <div class="notice notice-info"> 
        <p><strong>Gerencia as atividades de seu negócio</strong></p>
    </div>
    <div>
        <div class="form">
            <label>Negócio</label>
            <select class="page-title-action">
                <option>Selecione um negócio</option>
            </select>

            <label>Contato</label>
            <select class="page-title-action">
                <option>Maurélio Cezar</option>
            </select>

            <label>Prazo<input type="date" placeholder="Data limite" id="dateTask" style="width: 120px" class="page-title-action"/></label>
            <label>Prioridade </label>
            <select class="page-title-action">
                <option>Alta</option>
                <option>Baixa</option>
                <option>Urgente</option>
                <option>Imediato</option>
            </select>

            <label>Descrição<input type="text" style="none" placeholder="descrição da atividade" id="task" class="page-title-action"/> </label>
            <button id="add-button" class="page-title-action">Adicionar</button>
            <button id="add-button" class="page-title-action">Filtrar</button>
        </div>
        <div class="flex">
            <div class="scrum-board backlog">
                <h2><span class="dashicons dashicons-admin-tools"></span> Pendente</h2>
                <div class="input-group overflow">
                    <span>Wash dishes</span>
                    <!-- <a href="#" class="drag">Drag</a>-->
                    <div class="margin-top-10">
                        <span title="Pendente" class="dashicons dashicons-admin-tools button button-backlog">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Negociação" class="dashicons dashicons-lightbulb button button-progress ">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Concluído" class="dashicons dashicons-yes button button-done">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Cancelado" class="dashicons dashicons-no button button-cancel">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Adicionar notas" class="dashicons dashicons-media-document button">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Agenda" class="dashicons dashicons-calendar button">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Compartilhar" class="dashicons dashicons-share button">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Excluir" class="dashicons dashicons-trash button button-delete">&nbsp;&nbsp;&nbsp;</span>
                    </div>
                </div>
                <div class="input-group overflow">
                    <span>Make bed</span>
                    <!-- <a href="#" class="drag">Drag</a>-->
                    <div class="margin-top-10">
                        <span title="Pendente" class="dashicons dashicons-admin-tools button button-backlog">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Negociação" class="dashicons dashicons-lightbulb button button-progress ">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Concluído" class="dashicons dashicons-yes button button-done">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Cancelado" class="dashicons dashicons-no button button-cancel">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Adicionar notas" class="dashicons dashicons-media-document button">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Agenda" class="dashicons dashicons-calendar button">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Compartilhar" class="dashicons dashicons-share button">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Excluir" class="dashicons dashicons-trash button button-delete">&nbsp;&nbsp;&nbsp;</span>
                    </div>
                </div>
                <div class="input-group overflow">
                    <span>Cook dinner</span>
                    <!-- <a href="#" class="drag">Drag</a>-->
                    <div class="margin-top-10">
                        <span title="Pendente" class="dashicons dashicons-admin-tools button button-backlog">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Negociação" class="dashicons dashicons-lightbulb button button-progress ">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Concluído" class="dashicons dashicons-yes button button-done">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Cancelado" class="dashicons dashicons-no button button-cancel">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Adicionar notas" class="dashicons dashicons-media-document button">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Agenda" class="dashicons dashicons-calendar button">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Compartilhar" class="dashicons dashicons-share button">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Excluir" class="dashicons dashicons-trash button button-delete">&nbsp;&nbsp;&nbsp;</span>
                    </div>
                </div>
                <div class="input-group overflow">
                    <span>Ask wife permission to go on trip</span>
                    <!-- <a href="#" class="drag">Drag</a>-->
                    <div class="margin-top-10">
                        <span title="Pendente" class="dashicons dashicons-admin-tools button button-backlog">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Negociação" class="dashicons dashicons-lightbulb button button-progress ">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Concluído" class="dashicons dashicons-yes button button-done">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Cancelado" class="dashicons dashicons-no button button-cancel">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Adicionar notas" class="dashicons dashicons-media-document button">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Agenda" class="dashicons dashicons-calendar button">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Compartilhar" class="dashicons dashicons-share button">&nbsp;&nbsp;&nbsp;</span>
                        <span title="Excluir" class="dashicons dashicons-trash button button-delete">&nbsp;&nbsp;&nbsp;</span>
                    </div>
                </div>        
            </div>

            <div class="scrum-board in-progress">
                <h2><span class="dashicons dashicons-lightbulb"></span> Negóciação</h2>
            </div>
            <div class="scrum-board done">
                <h2><span class="dashicons dashicons-yes"></span> Concluído</h2>
            </div>
            <div class="scrum-board canceled">
                <h2><span class="dashicons dashicons-no"></span> Cancelado</h2>
            </div>


        </div>
    </div>
</div>
<style>
    .form{
        background-color: white;
        padding: 20px;
    }

    .button{
        display: inline-block;
        padding: 5px !important;
        background: linear-gradient(#79a6e2 2%, #3366aa 5%, #1e4e8e);
        border: none;
        border-radius: 5px;
        color: #fff;
        font-weight: bold;
        font-size: 11px !important;
        box-shadow: 0px 3px 0px #113c75,
            0px 5px 5px #333;

    }

    .button-backlog{
        background: transparent;
        box-shadow: none;
        color: #3366aa;
        font-weight: normal;
    }
    .button-progress{
        background: transparent;
        box-shadow: none;
        color: #c06300;
        font-weight: normal;
    }
    .button-done{
        background: transparent;
        box-shadow: none;
        color: #007b03;
        font-weight: normal;
    }
    .button-delete{
        background: transparent;
        box-shadow: none;
        color: #be0000;
        font-weight: normal;
    }
    .button-cancel{
        background: transparent;
        box-shadow: none;
        color: #FF4081;
        font-weight: normal;
    }
    .form > h2{
        margin-top: 0
    }
    .col-3rds{
        box-sizing: border-box;
        width:25.0%;
        float:left;
    }
    .flex{
        display: flex;
        flex-direction: row;
    }
    .scrum-board{
        background: white;
        flex: 1;
        padding:20px;
        border-right:1px solid #ddd;
        border-bottom:1px solid #ddd;
    }
    .scrum-board:first-child{
        flex: 1;
        padding:20px;
        border-left:1px solid #ddd;
    }
    .input-group{
        position: relative;
        display: block;
        padding: 10px ;
        border: 1px solid #dddddd;
        border-left: 5px solid #ccc;
        margin-bottom: 10px;
        border-radius: 5px;
        background-color: #f1f1f1;
    }
    .input-group span{
        color:#333;
        font-weight: bold;
    }
    .inline{
        display: inline;
    }
    .float-right{
        float: right;
    }
    .overflow{
        overflow: auto;
    }
    .margin-top-10{
        margin-top: 10px;
    }
    .drag{
        font-size: 12px;
        color: #333;
        text-decoration: none;
        position: absolute;
        top:5px;
        right: 5px;
        border: 1px solid #ccc;
        padding: 3px;
        border-radius: 5px;
        cursor: move;
    }
    .placeholder {
        display: block;
        background-color: #fff;
        border: 5px dashed #ededed;
        min-height: 100px;
        margin-bottom: 10px;
    }

</style>
<script>
//Init
    init();

//Button Functions------------------------------------------
    function init() {
        jQuery(".button-backlog").on("click", function () {
            if (!(jQuery(this).closest(".backlog").length > 0)) {
                jQuery(this).parents(".input-group").appendTo(".backlog").css({
                    "background-color": "",
                    "border": ""
                });
            }
        });
        jQuery(".button-progress").on("click", function () {
            if (!(jQuery(this).closest(".in-progress").length > 0)) {
                jQuery(this).parents(".input-group").appendTo(".in-progress").css({
                    "background-color": "#ffdfbc",
                    "border": "none"
                });
            }
        });
        jQuery(".button-done").on("click", function () {
            if (!(jQuery(this).closest(".done").length > 0)) {
                jQuery(this).parents(".input-group").appendTo(".done").css({
                    "background-color": "#cfffd0",
                    "border": "none"
                });

            }
        });
        jQuery(".button-cancel").on("click", function () {
            if (!(jQuery(this).closest(".done").length > 0)) {
                jQuery(this).parents(".input-group").appendTo(".canceled").css({
                    "background-color": "#F8BBD0",
                    "border": "none"
                });

            }
        });
        jQuery(".button-delete").on("click", function () {
            jQuery(this).parents(".input-group").remove();
        });

        var placeholderDiv = document.createElement("div");
        var placeholderAtt = document.createAttribute("class");
        var taskDivAttVal = placeholderAtt.value = "placeholder";
        placeholderDiv.setAttributeNode(placeholderAtt);

        //DRAG Functions------------------------------------------
        //Drag - onmousedown
        jQuery(".drag").on("mousedown", function ($) {
            var taskWidth = jQuery(this).parents(".input-group").width();
            var taskHeight = jQuery(this).parents(".input-group").height();
            var $this = jQuery(this);
            jQuery(this).parents(".input-group").css({
                "position": "absolute",
                "width": taskWidth
            });

            jQuery(this).parents(".input-group").after(placeholderDiv);
            jQuery(".backlog").css({"background-color": "#fffce0"});
            jQuery(".in-progress").css({"background-color": "#fffce0"});
            jQuery(".done").css({"background-color": "#fffce0"});
            jQuery(".canceled").css({"background-color": "#FF4081"});

            //Drag - onmousemove
            jQuery(document.body).on("mousemove", function (event) {
                jQuery(this).parents(".input-group").css({
                    "position": "absolute",
                    "top": event.pageY - 13,
                    "left": event.pageX - taskWidth,
                    "width": taskWidth,
                    "z-index": "1000"
                });
            });
        });

        //Drag - onmouseup
        jQuery(".drag").on("mouseup", function ($) {
            $(this).parents(".input-group").after(placeholderDiv);
            placeholderDiv.remove();
            $(this).parents(".input-group").removeAttr("style");
            $(document.body).unbind("mousemove");
            $(".backlog").css({"background-color": ""});
            $(".in-progress").css({"background-color": ""});
            $(".done").css({"background-color": ""});
        });

    }

//Create Task------------------------------------------
    jQuery("#add-button").on("click", function ($) {

        var taskDiv = document.createElement("div");
        var taskSpan = document.createElement("span");
        var buttonsDiv = document.createElement("div");
        var buttonPendente = document.createElement("span");
        var buttonProgress = document.createElement("span");
        var buttonFechado = document.createElement("span");
        var buttonDelete = document.createElement("span");
        var buttonCanceled = document.createElement("span");

        var taskDivAtt = document.createAttribute("class");
        var buttonsDivAtt = document.createAttribute("class");
        var buttonPendenteAtt = document.createAttribute("class");
        var buttonProgressAtt = document.createAttribute("class");
        var buttonFechadoAtt = document.createAttribute("class");
        var buttonDeleteAtt = document.createAttribute("class");
        var buttonCanceledAtt = document.createAttribute("class");

        var taskDivAttVal = taskDivAtt.value = "input-group overflow";
        var buttonsDivAttVal = buttonsDivAtt.value = "margin-top-10";
        var buttonPendenteAttVal = buttonPendenteAtt.value = "button button-backlog dashicons dashicons-admin-tools";
        var buttonProgressAttVal = buttonProgressAtt.value = "button button-progress dashicons dashicons-lightbulb";
        var buttonFechadoAttVal = buttonFechadoAtt.value = "button button-done dashicons dashicons-yes";
        var buttonDeleteAttVal = buttonDeleteAtt.value = "button button-delete dashicons dashicons-trash";
        var buttonCanceledAttVal = buttonCanceledAtt.value = "button button-cancel dashicons dashicons-no";

        taskDiv.setAttributeNode(taskDivAtt);
        buttonsDiv.setAttributeNode(buttonsDivAtt);
        buttonPendente.setAttributeNode(buttonPendenteAtt);
        buttonProgress.setAttributeNode(buttonProgressAtt);
        buttonFechado.setAttributeNode(buttonFechadoAtt);
        buttonDelete.setAttributeNode(buttonDeleteAtt);
        buttonCanceled.setAttributeNode(buttonCanceledAtt);

        var taskText = document.createTextNode(jQuery("#task").val());
        var buttonPendenteText = document.createTextNode("");
        var buttonProgressText = document.createTextNode("");
        var buttonFechadoText = document.createTextNode("");
        var buttonDeleteText = document.createTextNode("");
        var buttonCanceledText = document.createTextNode("");

        taskSpan.appendChild(taskText);
        taskDiv.appendChild(taskSpan);
        taskDiv.appendChild(buttonsDiv);
        buttonPendente.appendChild(buttonPendenteText);
        buttonProgress.appendChild(buttonProgressText);
        buttonFechado.appendChild(buttonFechadoText);
        buttonDelete.appendChild(buttonDeleteText);
        buttonCanceled.appendChild(buttonCanceledText);
        buttonsDiv.appendChild(buttonPendente);
        buttonsDiv.appendChild(buttonProgress);
        buttonsDiv.appendChild(buttonFechado);
        buttonsDiv.appendChild(buttonDelete);
        buttonsDiv.appendChild(buttonCanceled);

        jQuery('.backlog').append(taskDiv);

        init();

    });
</script>