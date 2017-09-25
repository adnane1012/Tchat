<div class="container app">
    <div class="row app-one">
        <div class="col-sm-4 side">
            <div class="side-one">

                <div class="row sideBar">
                    <?php foreach ($contacts as $contact) : ?>
                        <a class="selectedUser" data-target="<?php echo $contact->getContactUser()->getId(); ?>"
                           data-username="<?php echo $contact->getContactUser()->getUsername(); ?>"
                           href="#<?php echo $contact->getContactUser()->getId(); ?>">
                            <div class="row sideBar-body">
                                <div class="col-sm-3 col-xs-3 sideBar-avatar">
                                    <div class="avatar-icon">
                                        <img src="//ssl.gstatic.com/accounts/ui/avatar_2x.png">
                                    </div>
                                </div>
                                <div class="col-sm-9 col-xs-9 sideBar-main">
                                    <div class="row">

                                        <div class="col-sm-8 col-xs-8 sideBar-name">
                                            <span
                                                class="name-meta"><?php echo $contact->getContactUser()->getUsername(); ?></span>
                                        </div>

                                        <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                  <span class="time-meta pull-right">18:18
                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    <?php endforeach ?>
                </div>

            </div>

        </div>

        <div class="col-sm-8 conversation">
            <div class="row heading">
                <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
                    <div class="heading-avatar-icon">
                        <img src="//ssl.gstatic.com/accounts/ui/avatar_2x.png">
                    </div>
                </div>
                <div class="col-sm-8 col-xs-7 heading-name">
                    <a class="heading-name-meta" id="headerConverstaion">
                    </a>
                </div>
                <a href="?page=logout">
                    <div class="col-sm-1 col-xs-1  heading-dot pull-right">
                        <i class="fa fa-sign-out fa-2x  pull-right" aria-hidden="true"></i>
                    </div>
                </a>
            </div>

            <div class="row message" id="conversation">

            </div>

            <div class="row reply">
                <form>
                    <div class="col-sm-9 col-xs-9 reply-main">
                        <textarea class="form-control" rows="1" id="message"></textarea>
                    </div>
                    <div id="sendMessage" data-target=""
                         data-username=""
                         class="col-sm-1 col-xs-1 reply-send">
                        <i class="fa fa-send fa-2x" aria-hidden="true"></i>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var hash = location.hash.replace(/^.*?#/, '');
    console.log(hash);
    $('#sendMessage').click(function () {
        var $this = $(this);
        var target = $(this).data('target');
        var message = $("#message");
        $.ajax({
            url: "?page=submitMessage",
            method: "POST",
            data: { userId: target,message :message.val() },
            dataType: "json"
        }).done(function (msg) {
            console.log(msg);
            if(msg.code==1){
                getMessages($this);
                message.val("");
            }
        }).fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
            $('#preloader').delay(400).fadeOut('slow');
        });
    })
    function getMessages($this) {
        console.log($this);
        var username = $this.data('username');
        var target = $this.data('target');
        $.ajax({
            url: "?page=loadMessages",
            method: "POST",
            data: { userId: target },
            dataType: "html"
        }).done(function (msg) {
            $(".conversation").prepend('<div id="preloader"><div class="spinner-sm spinner-sm-1" id="status"></div></div>');
            $('#preloader').delay(400).fadeOut('slow'); // will fade out the white DIV that covers the website.
            $('#conversation').html(msg);
            $('#headerConverstaion').html(username);
            $('#sendMessage').data('target', target);
            $('#sendMessage').data('username', username);
            $("#conversation").scrollTop($('#conversation').height())

        }).fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
            $('#preloader').delay(400).fadeOut('slow');
        });

    }
    $('.selectedUser').click(function () {
        getMessages($(this));
    });
</script>
